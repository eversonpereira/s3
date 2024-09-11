using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class ListObjects
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

            if (listObjectsResponse.S3Objects.Count == 0)
            {
                Console.WriteLine($"Nenhum objeto encontrado no bucket {bucketName}.");
            }
            else
            {
                foreach (var obj in listObjectsResponse.S3Objects)
                {
                    string objectUrl = $"{credentials["endpoint_url"]}/{bucketName}/{obj.Key}";
                    Console.WriteLine($"{obj.Key} - {objectUrl}");
                }
            }
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao listar objetos: {e.Message}");
        }
    }
}
