#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListBucketsCommand extends Command
{
    protected static $defaultName = 'list-buckets';

    protected function configure()
    {
        $this
            ->setDescription('Lista todos os buckets');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
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
            $result = $s3Client->listBuckets();
            $buckets = $result['Buckets'];
            if (empty($buckets)) {
                $output->writeln('<info>Nenhum bucket encontrado.</info>');
            } else {
                foreach ($buckets as $bucket) {
                    $output->writeln('<info>' . $bucket['Name'] . '</info>');
                }
            }
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao listar os buckets: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new ListBucketsCommand());
$application->run();
