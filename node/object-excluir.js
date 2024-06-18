#!/usr/bin/env node

const { S3Client, DeleteObjectCommand } = require("@aws-sdk/client-s3");
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
    .requiredOption('--bucket-name <bucketName>', 'Nome do bucket que contém o objeto')
    .requiredOption('--key-name <keyName>', 'Digite a key do objeto');

program.parse(process.argv);

const options = program.opts();

const deleteObject = async () => {
    try {
        await s3Client.send(new DeleteObjectCommand({ Bucket: options.bucketName, Key: options.keyName }));
        console.log(`Objeto ${options.keyName} removido com sucesso do bucket ${options.bucketName}.`);
    } catch (err) {
        console.error('Erro ao excluir o objeto:', err);
    }
};

deleteObject();

