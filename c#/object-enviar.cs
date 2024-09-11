using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class UploadObject
{
    static async Task Main(string[] args)
    {
        if (args.Length != 6 || args[0] != "--bucket-name" || args[2] != "--key-name" || (args[4] != "--path" && args[4] != "--data"))
        {
            Console.WriteLine("Usage: dotnet run --bucket-name <bucket-name> --key-name <key-name> --path <file-path> ou --data <data>");
            return;
        }

        string bucketName = args[1];
        string keyName = args[3];
        string pathOrData = args[5];
        var credentials = JObject.Parse(File.ReadAllText("credentials.json"));

        var config = new AmazonS3Config
        {
            ServiceURL = credentials["endpoint_url"].ToString(),
            ForcePathStyle = true
        };

        var s3Client = new AmazonS3Client(credentials["access_key"].ToString(), credentials["secret_key"].ToString(), config);

        try
        {
            var putObjectRequest = new PutObjectRequest
            {
                BucketName = bucketName,
                Key = keyName,
                ContentBody = args[4] == "--path" ? File.ReadAllText(pathOrData) : pathOrData
            };

            var response = await s3Client.PutObjectAsync(putObjectRequest);
            Console.WriteLine($"Objeto {keyName} enviado com sucesso para o bucket {bucketName}.");
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao enviar o objeto: {e.Message}");
        }
    }
}
