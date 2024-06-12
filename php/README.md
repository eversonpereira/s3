# S3 Bucket and Object Management Scripts - PHP - aws-sdk-php

Este conjunto de scripts PHP permite gerenciar buckets e objetos em um serviço compatível com S3. Os scripts utilizam a biblioteca `aws-sdk-php` e a `symfony/console` para facilitar a interação via linha de comando.

## Pré-requisitos

- PHP 7.x ou superior
- Composer
- As seguintes extensões PHP:
  - `xml`

## Instalação

### Passo 1: Clonar o repositório

```bash
git clone <URL_DO_REPOSITORIO>
cd <NOME_DO_REPOSITORIO>
```

### Passo 2: Instalar as dependências
Certifique-se de ter o Composer instalado. Em seguida, execute:
```bash
composer install
```

### Passo 3: Configurar as credenciais
Crie um arquivo credentials.json no diretório raiz do projeto com o seguinte conteúdo:
```json
{
    "endpoint_url": "https://s3.com4.com.br",
    "access_key": "CHAVE_DE_ACESSO",
    "secret_key": "CHAVE_SECRET"
}
```

## Scripts Disponíveis
### 1. Criar um Bucket
Cria um novo bucket.
```bash
php bucket-criar.php create-bucket --bucket-name <NOME_DO_BUCKET>
```

### 2. Listar Buckets
Lista todos os buckets.
```bash
php bucket-listar.php list-buckets
```

### 3. Excluir um Bucket
Exclui um bucket e todos os seus objetos.
```bash
php bucket-excluir.php --bucket-name <NOME_DO_BUCKET>
```

### 4. Enviar um Objeto
Envia um objeto para um bucket. Pode enviar um arquivo local ou dados diretamente.
```bash
# Enviar um arquivo
php object-enviar.php upload-object --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --path <CAMINHO_DO_ARQUIVO>

# Enviar dados diretamente
php object-enviar.php upload-object --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --data "<DADOS_DO_ARQUIVO>"
```

### 5. Listar Objetos
Lista todos os objetos em um bucket com seus links.
```bash
php object-listar.php list-objects --bucket-name <NOME_DO_BUCKET>
```

### 6. Alterar Visibilidade de um Objeto
Altera a visibilidade de um objeto para público ou privado.
```bash
# Tornar público
php object-visibilidade.php update-object-visibility --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public true

# Tornar privado
php object-visibilidade.php update-object-visibility --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public false
```

### 7. Excluir um Objeto
Exclui um objeto de um bucket.
```bash
php object-excluir.php delete-object --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO>
```

## Observações
* Certifique-se de que as credenciais e o endpoint fornecidos no arquivo credentials.json estão corretos.
* Alguns comandos podem demorar dependendo do número de objetos no bucket ou do tamanho dos dados enviados.
* Os scripts foram testados em um ambiente compatível com S3 e no S3 da AWS.
Contribuições são sempre bem vindas.
Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.