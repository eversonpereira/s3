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

class ListObjectsCommand extends Command
{
    protected static $defaultName = 'list-objects';

    protected function configure()
    {
        $this
            ->setDescription('Lista todos os objetos em um bucket')
            ->addOption(
                'bucket-name',
                null,
                InputOption::VALUE_REQUIRED,
                'O nome do bucket'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getOption('bucket-name');

        if (!$bucketName) {
            $output->writeln('<error>O parâmetro bucket-name é obrigatório.</error>');
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
            $result = $s3Client->listObjectsV2([
                'Bucket' => $bucketName,
            ]);

            if (empty($result['Contents'])) {
                $output->writeln('<info>Nenhum objeto encontrado no bucket.</info>');
            } else {
                foreach ($result['Contents'] as $object) {
                    $url = $s3Client->getObjectUrl($bucketName, $object['Key']);
                    $output->writeln('<info>' . $object['Key'] . ' - ' . $url . '</info>');
                }
            }
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao listar os objetos: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new ListObjectsCommand());
$application->run();
