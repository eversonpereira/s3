#!/usr/bin/env node

const { S3Client, PutObjectCommand } = require("@aws-sdk/client-s3");
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
    .requiredOption('--bucket-name <bucketName>', 'Nome do bucket que armazenará o objeto')
    .requiredOption('--key-name <keyName>', 'Digite a key do objeto')
    .option('--path <filePath>', 'O caminho do arquivo a ser armazenado')
    .option('--data <data>', 'O dado a ser armazenado');

program.parse(process.argv);

const options = program.opts();

if (!options.path && !options.data) {
    console.error('É necessário fornecer --path ou --data');
    process.exit(1);
}

const uploadObject = async () => {
    try {
        const uploadParams = { Bucket: options.bucketName, Key: options.keyName };
        if (options.path) {
            uploadParams.Body = fs.createReadStream(options.path);
        } else {
            uploadParams.Body = options.data;
        }
        await s3Client.send(new PutObjectCommand(uploadParams));
        console.log(`Objeto ${options.keyName} enviado com sucesso para o bucket ${options.bucketName}.`);
    } catch (err) {
        console.error('Erro ao enviar o objeto:', err);
    }
};

uploadObject();

