#!/usr/bin/env node

const { S3Client, ListBucketsCommand } = require("@aws-sdk/client-s3");
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

program.parse(process.argv);

const listBuckets = async () => {
    try {
        const data = await s3Client.send(new ListBucketsCommand({}));
        data.Buckets.forEach(bucket => {
            console.log(bucket.Name);
        });
    } catch (err) {
        console.error('Erro ao listar buckets:', err);
    }
};

listBuckets();

