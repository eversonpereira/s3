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
    parser = ArgumentParser(description='Tornar um objeto público ou fechado')
    parser.add_argument('--bucket-name',
                        dest='bucket_name',
                        action='store',
                        required=True,
                        help='Nome do bucket que contém o objeto')
    parser.add_argument('--key-name',
                        dest='key_name',
                        action='store',
                        required=True,
                        help='Digite a key do objeto')
    parser.add_argument('--public',
                        dest='public',
                        action='store',
                        required=True,
                        help='Define se o objeto será público (true) ou fechado (false)')
    args = parser.parse_args()

    s3_config = Config(signature_version='s3v4')

    s3 = boto3.client('s3',
                      endpoint_url=credentials['endpoint_url'],
                      aws_access_key_id=credentials['access_key'],
                      aws_secret_access_key=credentials['secret_key'],
                      config=s3_config,
                      use_ssl=True,
                      verify=False)

    acl = 'public-read' if args.public.lower() == 'true' else 'private'

    try:
        s3.put_object_acl(Bucket=args.bucket_name, Key=args.key_name, ACL=acl)
        visibility = 'público' if acl == 'public-read' else 'privado'
        print(f'Objeto {args.key_name} no bucket {args.bucket_name} agora é {visibility}.')
    except Exception as e:
        print(f'Erro ao atualizar a visibilidade do objeto: {e}')

if __name__ == '__main__':
    main()
