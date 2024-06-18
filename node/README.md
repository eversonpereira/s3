# S3 Bucket and Object Management Scripts - NodeJS - aws-sdk

Este conjunto de scripts NodeJS permitem gerenciar buckets e objetos em um serviço compatível com S3. Os scripts utilizam as bibliotecas `@aws-sdk/client-s3`, `@aws-sdk/node-http-handler` e a `commander` para facilitar a interação via linha de comando.

## Pré-requisitos

- NodeJS 20
- @aws-sdk/client-s3
- @aws-sdk/node-http-handler
- commander

## Instalação

### Passo 1: Clonar o repositório

```bash
git clone <URL_DO_REPOSITORIO>
cd <NOME_DO_REPOSITORIO>
```

### Passo 2: Instalar as dependências
Instale as dependências necessárias::
```bash
npm install @aws-sdk/client-s3 @aws-sdk/node-http-handler commander
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
node bucket-criar.js --bucket-name <NOME_DO_BUCKET>
```

### 2. Listar Buckets
Lista todos os buckets.
```bash
node bucket-listar.js
```

### 3. Excluir um Bucket
Exclui um bucket e todos os seus objetos.
```bash
node bucket-excluir.js --bucket-name <NOME_DO_BUCKET>
```

### 4. Enviar um Objeto
Envia um objeto para um bucket. Pode enviar um arquivo local ou dados diretamente.
```bash
# Enviar um arquivo
node object-enviar.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --path <CAMINHO_DO_ARQUIVO>

# Enviar dados diretamente
node object-enviar.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --data "<DADOS_DO_ARQUIVO>"
```

### 5. Listar Objetos
Lista todos os objetos em um bucket com seus links.
```bash
node object-listar.js --bucket-name <NOME_DO_BUCKET>
```

### 6. Alterar Visibilidade de um Objeto
Altera a visibilidade de um objeto para público ou privado.
```bash
# Tornar público
node object-visibilidade.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --public true

# Tornar privado
node object-visibilidade.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE> --public false
```

### 7. Excluir um Objeto
Exclui um objeto de um bucket.
```bash
node object-excluir.js --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DA_CHAVE>
```

## Observações
* Certifique-se de que as credenciais e o endpoint fornecidos no arquivo credentials.json estão corretos.
* Alguns comandos podem demorar dependendo do número de objetos no bucket ou do tamanho dos dados enviados.
* Os scripts foram testados em um ambiente compatível com S3 e no S3 da AWS.
Contribuições são sempre bem vindas.
Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.