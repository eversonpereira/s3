using System;
using Amazon.S3;
using Amazon.S3.Model;
using Newtonsoft.Json.Linq;
using System.IO;

class UpdateObjectVisibility
{
    static async Task Main(string[] args)
    {
        if (args.Length != 6 || args[0] != "--bucket-name" || args[2] != "--key-name" || args[4] != "--public")
        {
            Console.WriteLine("Usage: dotnet run --bucket-name <bucket-name> --key-name <key-name> --public true ou false");
            return;
        }

        string bucketName = args[1];
        string keyName = args[3];
        bool isPublic = bool.Parse(args[5]);
        var credentials = JObject.Parse(File.ReadAllText("credentials.json"));

        var config = new AmazonS3Config
        {
            ServiceURL = credentials["endpoint_url"].ToString(),
            ForcePathStyle = true
        };

        var s3Client = new AmazonS3Client(credentials["access_key"].ToString(), credentials["secret_key"].ToString(), config);

        try
        {
            var putObjectAclRequest = new PutACLRequest
            {
                BucketName = bucketName,
                Key = keyName,
                CannedACL = isPublic ? S3CannedACL.PublicRead : S3CannedACL.Private
            };

            await s3Client.PutACLAsync(putObjectAclRequest);

            Console.WriteLine($"Objeto {keyName} no bucket {bucketName} agora é {(isPublic ? "público" : "privado")}.");
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao atualizar a visibilidade do objeto: {e.Message}");
        }
    }
}
