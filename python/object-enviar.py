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
    parser = ArgumentParser(description='Enviar um objeto para um bucket')
    parser.add_argument('--bucket-name',
                        dest='bucket_name',
                        action='store',
                        required=True,
                        help='Nome do bucket que armazenará o objeto')
    parser.add_argument('--key-name',
                        dest='key_name',
                        action='store',
                        required=True,
                        help='Digite a key do objeto')
    parser.add_argument('--path',
                        dest='path',
                        action='store',
                        help='O caminho do arquivo a ser armazenado')
    parser.add_argument('--data',
                        dest='data',
                        action='store',
                        help='O dado a ser armazenado')

    args = parser.parse_args()

    if not args.path and not args.data:
        parser.error('É necessário fornecer --path ou --data')

    s3_config = Config(signature_version='s3v4')

    s3 = boto3.resource('s3',
                        endpoint_url=credentials['endpoint_url'],
                        aws_access_key_id=credentials['access_key'],
                        aws_secret_access_key=credentials['secret_key'],
                        config=s3_config,
                        use_ssl=True,
                        verify=False)

    bucket = s3.Bucket(args.bucket_name)

    if args.path:
        with open(args.path, 'rb') as file_data:
            bucket.put_object(Bucket=args.bucket_name,
                              Key=args.key_name,
                              Body=file_data)
    else:
        bucket.put_object(Bucket=args.bucket_name,
                          Key=args.key_name,
                          Body=args.data)

if __name__ == '__main__':
    main()
