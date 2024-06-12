#!/usr/bin/env python3

import os
import sys
from argparse import ArgumentParser
import json

import boto3
from botocore.config import Config
from urllib3.exceptions import InsecureRequestWarning    
from urllib3 import disable_warnings    
disable_warnings(InsecureRequestWarning)

with open('credentials.json', 'r') as fd:
    credentials = json.loads(fd.read())

def main():
    parser = ArgumentParser(description='Excluir um bucket S3')
    parser.add_argument('--bucket-name',
                        dest='bucket_name',
                        action='store',
                        required=True,
                        help='Nome do bucket a ser excluído')
    args = parser.parse_args()

    s3_config = Config(signature_version='s3v4')

    s3 = boto3.client('s3',
                      endpoint_url=credentials['endpoint_url'],
                      aws_access_key_id=credentials['access_key'],
                      aws_secret_access_key=credentials['secret_key'],
                      config=s3_config,
                      use_ssl=True,
                      verify=False)

    try:
        # Listando e excluindo todos os objetos do bucket antes de excluir o bucket
        response = s3.list_objects_v2(Bucket=args.bucket_name)
        if 'Contents' in response:
            for obj in response['Contents']:
                s3.delete_object(Bucket=args.bucket_name, Key=obj['Key'])

        # Excluindo o bucket
        s3.delete_bucket(Bucket=args.bucket_name)

        # Aguardando a exclusão do bucket
        waiter = s3.get_waiter('bucket_not_exists')
        waiter.wait(Bucket=args.bucket_name)

        print(f'Bucket {args.bucket_name} excluído com sucesso.')
    except Exception as e:
        print(f'Erro ao excluir o bucket: {e}')

if __name__ == '__main__':
    main()
