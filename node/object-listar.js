#!/usr/bin/env node

const { S3Client, ListObjectsV2Command } = require("@aws-sdk/client-s3");
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
    .requiredOption('--bucket-name <bucketName>', 'Nome do bucket que contém os objetos');

program.parse(process.argv);

const options = program.opts();

const listObjects = async () => {
    try {
        const data = await s3Client.send(new ListObjectsV2Command({ Bucket: options.bucketName }));
        if (data.Contents.length === 0) {
            console.log(`Nenhum objeto encontrado no bucket ${options.bucketName}.`);
        } else {
            data.Contents.forEach(obj => {
                const objUrl = `${credentials.endpoint_url}/${options.bucketName}/${obj.Key}`;
                console.log(`${obj.Key} - ${objUrl}`);
            });
        }
    } catch (err) {
        console.error('Erro ao listar objetos:', err);
    }
};

listObjects();

