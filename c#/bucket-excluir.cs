using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class DeleteBucket
{
    static async Task Main(string[] args)
    {
        if (args.Length != 2 || args[0] != "--bucket-name")
        {
            Console.WriteLine("Usage: dotnet run --bucket-name <bucket-name>");
            return;
        }

        string bucketName = args[1];
        var credentials = JObject.Parse(File.ReadAllText("credentials.json"));

        var config = new AmazonS3Config
        {
            ServiceURL = credentials["endpoint_url"].ToString(),
            ForcePathStyle = true
        };

        var s3Client = new AmazonS3Client(credentials["access_key"].ToString(), credentials["secret_key"].ToString(), config);

        try
        {
            var listObjectsRequest = new ListObjectsV2Request
            {
                BucketName = bucketName
            };

            var listObjectsResponse = await s3Client.ListObjectsV2Async(listObjectsRequest);

            if (listObjectsResponse.S3Objects.Count > 0)
            {
                foreach (var obj in listObjectsResponse.S3Objects)
                {
                    await s3Client.DeleteObjectAsync(bucketName, obj.Key);
                }
            }

            var deleteBucketRequest = new DeleteBucketRequest
            {
                BucketName = bucketName
            };

            await s3Client.DeleteBucketAsync(deleteBucketRequest);
            Console.WriteLine($"Bucket {bucketName} excluído com sucesso.");
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao excluir o bucket: {e.Message}");
        }
    }
}
