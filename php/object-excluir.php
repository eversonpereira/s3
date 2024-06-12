#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class DeleteObjectCommand extends Command
{
    protected static $defaultName = 'delete-object';

    protected function configure()
    {
        $this
            ->setDescription('Remove um objeto de um bucket')
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
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getOption('bucket-name');
        $keyName = $input->getOption('key-name');

        if (!$bucketName || !$keyName) {
            $output->writeln('<error>Os parâmetros bucket-name e key-name são obrigatórios.</error>');
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
            $s3Client->deleteObject([
                'Bucket' => $bucketName,
                'Key' => $keyName,
            ]);
            $output->writeln('<info>Objeto ' . $keyName . ' removido com sucesso do bucket ' . $bucketName . '.</info>');
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao remover o objeto: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new DeleteObjectCommand());
$application->run();
