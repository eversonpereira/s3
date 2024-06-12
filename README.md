# S3 Bucket and Object Management Scripts

Este repositório contém scripts para gerenciar buckets e objetos em um serviço compatível com S3, utilizando tanto PHP quanto Python.

## Estrutura do Repositório

- `php/`: Contém scripts PHP para gerenciamento de buckets e objetos.
- `python/`: Contém scripts Python para gerenciamento de buckets e objetos.

## Instalação e Uso

### Pré-requisitos

- Para scripts PHP:
  - PHP 7.x ou superior
  - Composer

- Para scripts Python:
  - Python 3.x
  - `boto3` (biblioteca AWS SDK para Python)
  - `urllib3`

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

## Palavras-chave
* S3 Bucket Management
* S3 Object Management
* PHP S3 Scripts
* Python S3 Scripts
* AWS S3
* Storage Management
* Cloud Storage
* S3 API
* Boto3
* AWS SDK for PHP

## Observações
* Certifique-se de que as credenciais e o endpoint fornecidos no arquivo credentials.json estão corretos.
* Alguns comandos podem demorar dependendo do número de objetos no bucket ou do tamanho dos dados enviados.
* Os scripts foram testados em um ambiente compatível com S3 e em S3 Oficial.
Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.