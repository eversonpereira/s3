# S3 Bucket and Object Management Scripts in C#

Este repositório contém scripts em C# para gerenciar buckets e objetos em um serviço compatível com S3, utilizando o AWS SDK para .NET (v3). Os scripts seguem um padrão de argumentos na linha de comando para facilitar o uso.

## Estrutura do Repositório

- `bucket-criar.cs`: Cria um novo bucket no S3.
- `bucket-excluir.cs`: Exclui um bucket do S3 e seus objetos.
- `bucket-listar.cs`: Lista todos os buckets no S3.
- `object-enviar.cs`: Envia um objeto para um bucket S3, a partir de um caminho de arquivo ou dados diretamente.
- `object-excluir.cs`: Exclui um objeto específico de um bucket.
- `object-listar.cs`: Lista todos os objetos em um bucket, com seus links.
- `object-visibilidade.cs`: Altera a visibilidade de um objeto para público ou privado.

## Pré-requisitos

- .NET SDK 6.0 ou superior.
- AWS SDK para .NET (v3).

### Passos para Instalação

1. **Instalar o AWS SDK for .NET (v3)** usando o NuGet Package Manager ou pela linha de comando:
   ```bash
   dotnet add package AWSSDK.S3
   ```

2. **Configurar as credenciais**

   Crie um arquivo `credentials.json` no diretório raiz do projeto com o seguinte conteúdo:

   ```json
   {
       "endpoint_url": "https://s3.com4.com.br",
       "access_key": "CHAVE DE ACESSO",
       "secret_key": "SEGREDO"
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

## Uso dos Scripts

### 1. Criar um Bucket

Cria um novo bucket no S3.

```bash
dotnet run --project bucket-criar.cs --bucket-name <bucket-name>
```

### 2. Excluir um Bucket

Exclui um bucket e todos os seus objetos.

```bash
dotnet run --project bucket-excluir.cs --bucket-name <bucket-name>
```

### 3. Listar Buckets

Lista todos os buckets no S3.

```bash
dotnet run --project bucket-listar.cs
```

### 4. Enviar um Objeto

Envia um objeto para um bucket. Pode enviar um arquivo local ou dados diretamente.

```bash
# Enviar um arquivo
dotnet run --project object-enviar.cs --bucket-name <bucket-name> --key-name <key-name> --path <file-path>

# Enviar dados diretamente
dotnet run --project object-enviar.cs --bucket-name <bucket-name> --key-name <key-name> --data "<data>"
```

### 5. Excluir um Objeto

Exclui um objeto de um bucket.

```bash
dotnet run --project object-excluir.cs --bucket-name <bucket-name> --key-name <key-name>
```

### 6. Listar Objetos

Lista todos os objetos em um bucket com seus links.

```bash
dotnet run --project object-listar.cs --bucket-name <bucket-name>
```

### 7. Alterar Visibilidade de um Objeto

Altera a visibilidade de um objeto para público ou privado.

```bash
# Tornar público
dotnet run --project object-visibilidade.cs --bucket-name <bucket-name> --key-name <key-name> --public true

# Tornar privado
dotnet run --project object-visibilidade.cs --bucket-name <bucket-name> --key-name <key-name> --public false
```

## Palavras-chave

- S3 Bucket Management
- S3 Object Management
- AWS SDK for .NET
- C# S3 Scripts
- Amazon S3
- Cloud Storage
- S3 API
- .NET S3 Management

## Observações

- Certifique-se de que as credenciais e o endpoint fornecidos no arquivo `credentials.json` estão corretos.
- Os scripts foram testados em um ambiente compatível com S3.
- Se houver muitos objetos no bucket ou grandes quantidades de dados sendo enviados, o tempo de execução pode aumentar.

Sinta-se à vontade para contribuir ou reportar problemas via Issues no repositório.
