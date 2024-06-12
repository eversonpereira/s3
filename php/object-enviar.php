#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UploadObjectCommand extends Command
{
    protected static $defaultName = 'upload-object';

    protected function configure()
    {
        $this
            ->setDescription('Faz upload de um objeto para o bucket')
            ->addOption(
                'bucket-name',
                null,
                InputOption::VALUE_REQUIRED,
                'O nome do bucket'
            )
            ->addOption(
                'key-name',
                null,
                InputOption::VALUE_REQUIRED,
                'O nome da chave (key) do objeto'
            )
            ->addOption(
                'path',
                null,
                InputOption::VALUE_OPTIONAL,
                'O caminho do arquivo a ser enviado'
            )
            ->addOption(
                'data',
                null,
                InputOption::VALUE_OPTIONAL,
                'Os dados a serem enviados como objeto'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getOption('bucket-name');
        $keyName = $input->getOption('key-name');
        $filePath = $input->getOption('path');
        $data = $input->getOption('data');

        if (!$bucketName || !$keyName) {
            $output->writeln('<error>Os parâmetros bucket-name e key-name são obrigatórios.</error>');
            return Command::FAILURE;
        }

        if (!$filePath && !$data) {
            $output->writeln('<error>É necessário fornecer path ou data.</error>');
            return Command::FAILURE;
        }

        $credentials = json_decode(file_get_contents('credentials.json'), true);

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1', // Ajuste a região conforme necessário
            'endpoint' => $credentials['endpoint_url'],
            'credentials' => [
                'key' => $credentials['access_key'],
                'secret' => $credentials['secret_key'],
            ],
            'use_path_style_endpoint' => true,
            'http' => [
                'verify' => false, // Usando o bundle de certificados atualizado
            ],
        ]);

        try {
            if ($filePath) {
                // Upload de arquivo
                $s3Client->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'SourceFile' => $filePath,
                ]);
            } else {
                // Upload de dados
                $s3Client->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'Body' => $data,
                ]);
            }

            $output->writeln('<info>Objeto enviado com sucesso: ' . $keyName . '</info>');
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao enviar o objeto: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new UploadObjectCommand());
$application->run();
