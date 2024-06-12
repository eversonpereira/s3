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

class UpdateObjectVisibilityCommand extends Command
{
    protected static $defaultName = 'update-object-visibility';

    protected function configure()
    {
        $this
            ->setDescription('Torna o objeto público ou fechado')
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
                'public',
                null,
                InputOption::VALUE_REQUIRED,
                'Se o objeto deve ser público ou fechado (true/false)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bucketName = $input->getOption('bucket-name');
        $keyName = $input->getOption('key-name');
        $isPublic = $input->getOption('public');

        if (!$bucketName || !$keyName || is_null($isPublic)) {
            $output->writeln('<error>Os parâmetros bucket-name, key-name e public são obrigatórios.</error>');
            return Command::FAILURE;
        }

        $isPublic = filter_var($isPublic, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (is_null($isPublic)) {
            $output->writeln('<error>O parâmetro public deve ser true ou false.</error>');
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
            if ($isPublic) {
                // Tornar o objeto público
                $s3Client->putObjectAcl([
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'ACL' => 'public-read',
                ]);
                $output->writeln('<info>Objeto ' . $keyName . ' no bucket ' . $bucketName . ' agora é público.</info>');
            } else {
                // Tornar o objeto privado
                $s3Client->putObjectAcl([
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'ACL' => 'private',
                ]);
                $output->writeln('<info>Objeto ' . $keyName . ' no bucket ' . $bucketName . ' agora é privado.</info>');
            }
        } catch (AwsException $e) {
            $output->writeln('<error>Erro ao atualizar a visibilidade do objeto: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

$application = new Application();
$application->add(new UpdateObjectVisibilityCommand());
$application->run();
