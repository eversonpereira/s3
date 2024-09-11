# S3 Bucket and Object Management Scripts

Este repositório contém scripts para gerenciar buckets e objetos em um serviço compatível com S3, utilizando tanto PHP, NodeJS, Python e C#.

## Estrutura do Repositório

- `php/`: Contém scripts PHP para gerenciamento de buckets e objetos.
- `python/`: Contém scripts Python para gerenciamento de buckets e objetos.
- `node/`: Contém scripts NodeJS para gerenciamento de buckets e objetos.
- `c#/`: Contém scripts C# para gerenciamento de buckets e objetos.

## Instalação e Uso

### Pré-requisitos

- Para scripts PHP:
  - PHP 7.x ou superior
  - Composer

- Para scripts Python:
  - Python 3.x
  - `boto3` (biblioteca AWS SDK para Python)
  - `urllib3`

- Para scripts NodeJS
  - NodeJS 20
  - @aws-sdk/client-s3
  - @aws-sdk/node-http-handler
  - commander

- Para scripts C#
  - AWSSDK.S3

### Passos para Instalação

#### PHP

1. **Navegue até a pasta `php/`:**
   ```bash
   cd php
   ```

2. **Instale as dependências:**
   ```bash
   composer install
   ```

3. **Configurar as credenciais**
Crie um arquivo credentials.json no diretório php/ com o seguinte conteúdo:
   ```json
    {
    "endpoint_url": "https://s3.com4.com.br",
    "access_key": "CHAVE_DE_ACESSO",
    "secret_key": "CHAVE_SECRET"
    }
   ```

#### Python
1. **Navegue até a pasta python/:**
   ```bash
   cd python
   ```

2. **Instale as dependências:**
   ```bash
   pip install boto3 urllib3
   ```

3. **Configurar as credenciais**
   ```json
    {
    "endpoint_url": "https://s3.com4.com.br",
    "access_key": "CHAVE_DE_ACESSO",
    "secret_key": "CHAVE_SECRET"
    }
   ```

#### NodeJS
1. **Navegue até a pasta node/:**
   ```bash
   cd node
   ```

2. **Instale as dependências:**
   ```bash
   npm install @aws-sdk/client-s3 @aws-sdk/node-http-handler commander
   ```

3. **Configurar as credenciais**
   ```json
    {
    "endpoint_url": "https://s3.com4.com.br",
    "access_key": "CHAVE_DE_ACESSO",
    "secret_key": "CHAVE_SECRET"
    }
   ```

#### C#
1. **Instalar o AWS SDK for .NET (v3)** usando o NuGet Package Manager ou pela linha de comando:
   ```bash
   dotnet add package AWSSDK.S3
   ``` 

2. **Configurar as credenciais**

   Crie um arquivo `credentials.json` no diretório raiz do projeto com o seguinte conteúdo:

   ```json
   {
       "endpoint_url": "https://s3.com4.com.br",
       "access_key": "CHAVE_DE_ACESSO",
       "secret_key": "CHAVE_SECRET"
   }
   ```

3. **Criar um projeto C# (se ainda não tiver um):**
   ```bash
   dotnet new console -n S3BucketManager
   ```

4. **Adicionar os arquivos .cs ao seu projeto** e compilar.

   Copie os arquivos `.cs` para o diretório do projeto e compile o projeto com:
   ```bash
   dotnet build
   ```

## Scripts Disponíveis
### PHP
* Criar um Bucket: php create_bucket.php create-bucket --bucket-name <NOME_DO_BUCKET>
* Excluir um Bucket: php bucket-excluir.php delete-bucket --bucket-name <NOME_DO_BUCKET>
* Listar Buckets: php bucket-listar.php list-buckets
* Enviar um Objeto: php object-enviar.php upload-object --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --path <CAMINHO_DO_ARQUIVO> ou --data "<DADOS_DO_ARQUIVO>"
* Excluir um Objeto: php object-excluir.php delete-object --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO>
* Listar Objetos: php object-listar.php list-objects --bucket-name <NOME_DO_BUCKET>
* Alterar Visibilidade de um Objeto: php object-visibilidade.php update-object-visibility --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public true ou --public false

### Python
* Criar um Bucket: python bucket_criar.py --bucket-name <NOME_DO_BUCKET>
* Excluir um Bucket: python bucket_excluir.py --bucket-name <NOME_DO_BUCKET>
* Listar Buckets: python bucket_listar.py
* Enviar um Objeto: python object_enviar.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --path <CAMINHO_DO_ARQUIVO> ou --data "<DADOS_DO_ARQUIVO>"
* Excluir um Objeto: python object_excluir.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO>
* Listar Objetos: python object_listar.py --bucket-name <NOME_DO_BUCKET>
* Alterar Visibilidade de um Objeto: python object_visibilidade.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public true ou --public false

### NodeJS
* Criar um Bucket: node bucket-criar.js --bucket-name <NOME_DO_BUCKET>
* Excluir um Bucket: node bucket-excluir.js --bucket-name <NOME_DO_BUCKET>
* Listar Buckets: node bucket-listar.js
* Enviar um Objeto: node object-enviar.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --path <CAMINHO_DO_ARQUIVO> ou --data "<DADOS_DO_ARQUIVO>"
* Excluir um Objeto: node object-excluir.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE>
* Listar Objetos: node object-listar.js --bucket-name <NOME_DO_BUCKET>
* Alterar Visibilidade de um Objeto: node object-visibilidade.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --public true ou --public false

### C#
* Criar um Bucket: dotnet run --project bucket-criar.cs --bucket-name <NOME_DO_BUCKET>
* Excluir um Bucket: dotnet run --project bucket-excluir.cs --bucket-name <NOME_DO_BUCKET>
* Listar Buckets: dotnet run --project bucket-listar.cs
* Enviar um Objeto: dotnet run --project object-enviar.cs --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --path <CAMINHO_DO_ARQUIVO> ou --data "<DADOS_DO_ARQUIVO>"
* Excluir um Objeto: dotnet run --project object-excluir.cs --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE>
* Listar Objetos: dotnet run --project object-listar.cs --bucket-name <NOME_DO_BUCKET>
* Alterar Visibilidade de um Objeto: dotnet run --project object-visibilidade.cs --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --public true ou --public false

## Palavras-chave
* S3 Bucket Management
* S3 Object Management
* PHP S3 Scripts
* Python S3 Scripts
* NodeJS S3 Scripts
* C# S3 Scripts
* Com4 S3
* AWS S3
* Storage Management
* Cloud Storage
* S3 API
* Boto3
* AWS SDK for PHP
* AWS SDK for NodeJS

## Observações
* Certifique-se de que as credenciais e o endpoint fornecidos no arquivo credentials.json estão corretos.
* Alguns comandos podem demorar dependendo do número de objetos no bucket ou do tamanho dos dados enviados.
* Os scripts foram testados em um ambiente compatível com S3 e em S3 Oficial.
Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.