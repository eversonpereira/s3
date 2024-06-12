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
    parser = ArgumentParser(description='Cria um bucket')
    parser.add_argument('--bucket-name',
                        dest='bucket_name',
                        action='store',
                        required=True,
                        help='O nome do bucket a ser criado')
    args = parser.parse_args()

    s3_config = Config(signature_version='s3v4')

    s3 = boto3.resource('s3',
                        endpoint_url=credentials['endpoint_url'],
                        aws_access_key_id=credentials['access_key'],
                        aws_secret_access_key=credentials['secret_key'],
                        config=s3_config,
                        use_ssl=True,
                        verify=False)  # Usando o bundle de certificados atualizado

    bucket = s3.Bucket(args.bucket_name)
    bucket.create()

if __name__ == '__main__':
    main()
