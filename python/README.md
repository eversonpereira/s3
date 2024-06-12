# S3 Bucket and Object Management Scripts - Python - Boto3

Este conjunto de scripts Python permite gerenciar buckets e objetos em um serviço compatível com S3. Os scripts utilizam a biblioteca `boto3` para facilitar a interação com a API do S3.

## Pré-requisitos

- Python 3.x
- `boto3` (biblioteca AWS SDK para Python)
- As seguintes dependências adicionais:
  - `urllib3`

## Instalação

### Passo 1: Clonar o repositório

```bash
git clone <URL_DO_REPOSITORIO>
cd <NOME_DO_REPOSITORIO>
```

### Passo 2: Instalar as dependências
Certifique-se de ter o pip instalado. Em seguida, execute:
```bash
pip install boto3 urllib3
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
python bucket-criar.py --bucket-name <NOME_DO_BUCKET>
```

### 2. Excluir um Bucket
Exclui um bucket e todos os seus objetos.
```bash
python bucket-excluir.py --bucket-name <NOME_DO_BUCKET>
```

### 3. Listar Buckets
Lista todos os buckets.
```bash
python bucket-listar.py
```

### 4. Enviar um Objeto
Envia um objeto para um bucket. Pode enviar um arquivo local ou dados diretamente.
```bash
# Enviar um arquivo
python object-enviar.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --path <CAMINHO_DO_ARQUIVO>

# Enviar dados diretamente
python object-enviar.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --data "<DADOS_DO_ARQUIVO>"
```

### 5. Excluir um Objeto
Exclui um objeto de um bucket.
```bash
python object-excluir.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO>
```

### 6. Listar Objetos
Lista todos os objetos em um bucket com seus links.
```bash
python object-listar.py --bucket-name <NOME_DO_BUCKET>
```

### 7. Alterar Visibilidade de um Objeto
Altera a visibilidade de um objeto para público ou privado.
```bash
# Tornar público
python object-visibilidade.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public true

# Tornar privado
python object-visibilidade.py --bucket-name <NOME_DO_BUCKET> --key-name <NOME_DO_ARQUIVO> --public false
```

## Observações
* Certifique-se de que as credenciais e o endpoint fornecidos no arquivo credentials.json estão corretos.
* Alguns comandos podem demorar dependendo do número de objetos no bucket ou do tamanho dos dados enviados.
* Os scripts foram testados em um ambiente compatível com S3 e em S3 oficial.
Contribuições são sempre bem vindas.
Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.