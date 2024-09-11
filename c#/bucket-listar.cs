using System;
using Amazon.S3;
using Newtonsoft.Json.Linq;
using System.IO;

class ListBuckets
{
    static async Task Main(string[] args)
    {
        var credentials = JObject.Parse(File.ReadAllText("credentials.json"));

        var config = new AmazonS3Config
        {
            ServiceURL = credentials["endpoint_url"].ToString(),
            ForcePathStyle = true
        };

        var s3Client = new AmazonS3Client(credentials["access_key"].ToString(), credentials["secret_key"].ToString(), config);

        try
        {
            var response = await s3Client.ListBucketsAsync();
            foreach (var bucket in response.Buckets)
            {
                Console.WriteLine(bucket.BucketName);
            }
        }
        catch (AmazonS3Exception e)
        {
            Console.WriteLine($"Erro ao listar buckets: {e.Message}");
        }
    }
}
