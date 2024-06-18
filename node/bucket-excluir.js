#!/usr/bin/env node

const { S3Client, ListObjectsV2Command, DeleteObjectsCommand, DeleteBucketCommand } = require("@aws-sdk/client-s3");
const { NodeHttpHandler } = require("@aws-sdk/node-http-handler");
const fs = require('fs');
const { Command } = require('commander');
const program = new Command();

const credentials = JSON.parse(fs.readFileSync('credentials.json'));

const s3Client = new S3Client({
    endpoint: credentials.endpoint_url,
    region: "us-east-1",
    credentials: {
        accessKeyId: credentials.access_key,
        secretAccessKey: credentials.secret_key
    },
    requestHandler: new NodeHttpHandler({
        httpsAgent: new require('https').Agent({
            rejectUnauthorized: false
        })
    }),
    forcePathStyle: true  // Força o estilo de caminho para o endpoint
});

program
    .requiredOption('--bucket-name <bucketName>', 'Nome do bucket a ser excluído');

program.parse(process.argv);

const options = program.opts();

const deleteObjects = async (bucket) => {
    try {
        const data = await s3Client.send(new ListObjectsV2Command({ Bucket: bucket }));
        if (data.Contents.length === 0) {
            return deleteBucket(bucket);
        }
        const objects = data.Contents.map(object => ({ Key: object.Key }));
        await s3Client.send(new DeleteObjectsCommand({
            Bucket: bucket,
            Delete: { Objects: objects }
        }));
        await deleteBucket(bucket);
    } catch (err) {
        console.error('Erro ao listar/excluir objetos:', err);
    }
};

const deleteBucket = async (bucket) => {
    try {
        await s3Client.send(new DeleteBucketCommand({ Bucket: bucket }));
        console.log(`Bucket ${bucket} excluído com sucesso.`);
    } catch (err) {
        console.error('Erro ao excluir o bucket:', err);
    }
};

deleteObjects(options.bucketName);

