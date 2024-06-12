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
    parser = ArgumentParser(description='Lista todos os objetos em um bucket')
    parser.add_argument('--bucket-name',
                        dest='bucket_name',
                        action='store',
                        required=True,
                        help='Nome do bucket que contém os objetos')
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
        response = s3.list_objects_v2(Bucket=args.bucket_name)

        if 'Contents' in response:
            for obj in response['Contents']:
                obj_url = f"{credentials['endpoint_url']}/{args.bucket_name}/{obj['Key']}"
                print(f"{obj['Key']} - {obj_url}")
        else:
            print(f"Nenhum objeto encontrado no bucket {args.bucket_name}.")
    except Exception as e:
        print(f'Erro ao listar os objetos: {e}')

if __name__ == '__main__':
    main()
