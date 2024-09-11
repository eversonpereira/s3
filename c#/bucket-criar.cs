using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class CreateBucket
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
            var putBucketRequest = new PutBucketRequest
            {
                BucketName = bucketName
            };
            var response = await s3Client.PutBucketAsync(putBucketRequest);
            Console.WriteLine($"Bucket {bucketName} criado com sucesso.");
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao criar o bucket: {e.Message}");
        }
    }
}
