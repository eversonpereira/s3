#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class CreateBucketCommand extends Command
{
    protected static $defaultName = 'create-bucket';

    protected function configure()
    {
        $this
            ->setDescription('Cria um bucket')
            ->addOption(
                'bucket-name',
                null,
                InputOption::VALUE_REQUIRED,
                'O nome do bucket a ser criado'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getOption('bucket-name');

        if (!$bucketName) {
            $output->writeln('<error>O nome do bucket é obrigatório.</error>');
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
            $s3Client->createBucket([
                'Bucket' => $bucketName,
            ]);
            $output->writeln('<info>Bucket criado com sucesso: ' . $bucketName . '</info>');
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao criar o bucket: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new CreateBucketCommand());
$application->run();