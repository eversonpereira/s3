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

class DeleteBucketCommand extends Command
{
    protected static $defaultName = 'delete-bucket';

    protected function configure()
    {
        $this
            ->setDescription('Exclui um bucket S3')
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
            // Listando e excluindo todos os objetos do bucket antes de excluir o bucket
            $objects = $s3Client->listObjectsV2([
                'Bucket' => $bucketName,
            ]);

            if (!empty($objects['Contents'])) {
                foreach ($objects['Contents'] as $object) {
                    $s3Client->deleteObject([
                        'Bucket' => $bucketName,
                        'Key' => $object['Key'],
                    ]);
                }
            }

            // Excluindo o bucket
            $s3Client->deleteBucket([
                'Bucket' => $bucketName,
            ]);

            // Aguardando a exclusão do bucket
            $s3Client->waitUntil('BucketNotExists', [
                'Bucket' => $bucketName,
            ]);

            $output->writeln('<info>Bucket ' . $bucketName . ' excluído com sucesso.</info>');
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao excluir o bucket: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new DeleteBucketCommand());
$application->run();
