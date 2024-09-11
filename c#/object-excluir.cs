using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class DeleteObject
{
    static async Task Main(string[] args)
    {
        if (args.Length != 4 || args[0] != "--bucket-name" || args[2] != "--key-name")
        {
            Console.WriteLine("Usage: dotnet run --bucket-name <bucket-name> --key-name <key-name>");
            return;
        }

        string bucketName = args[1];
        string keyName = args[3];
        var credentials = JObject.Parse(File.ReadAllText("credentials.json"));

        var config = new AmazonS3Config
        {
            ServiceURL = credentials["endpoint_url"].ToString(),
            ForcePathStyle = true
        };

        var s3Client = new AmazonS3Client(credentials["access_key"].ToString(), credentials["secret_key"].ToString(), config);

        try
        {
            var deleteObjectRequest = new DeleteObjectRequest
            {
                BucketName = bucketName,
                Key = keyName
            };

            await s3Client.DeleteObjectAsync(deleteObjectRequest);
            Console.WriteLine($"Objeto {keyName} removido com sucesso do bucket {bucketName}.");
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao excluir o objeto: {e.Message}");
        }
    }
}
