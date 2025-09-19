# UploadDB – Sistema de Upload de Arquivos em PHP

Um projeto simples em PHP para **upload, listagem, download e remoção de arquivos** armazenados em um banco de dados MySQL. O projeto simula um **terminal estilo MS-DOS** com tela preta, letras verdes e cursor piscando.

---

## CONSIDERAÇÕES PARA O GRUPO PENSAR & SUGESTÕES

Para integrar este projeto ao projeto integrador, algumas melhorias e funcionalidades adicionais precisam ser planejadas:

1. **Relacionar arquivos a usuários**:

   - Criar uma **relação entre a tabela `arquivos` e a tabela `usuarios`** usando chaves estrangeiras (`usuario_id`).
   - Quando um usuário comum (pais ou responsáveis) fizer login, ele deverá **ver apenas os documentos que ele enviou**.
   - Quando o administrador acessar o sistema, ele poderá **visualizar todos os documentos de um aluno ou responsável**, organizando por usuário para facilitar o gerenciamento.

2. **Indicar tipo de documento**:

   - Adicionar uma coluna `tipo_documento` na tabela `arquivos` para classificar os arquivos, como **CPF, RG, Comprovante de Endereço**, etc.
   - Essa classificação ajuda a **organizar e identificar rapidamente quais documentos estão faltando** para cada usuário ou aluno.
   - No formulário de upload, incluir um **dropdown ou seleção de tipo de documento** para que o usuário escolha a categoria correta.

3. **Autenticação e controle de acesso**:
   - Garantir que **apenas usuários autenticados** possam enviar, baixar ou remover arquivos.
   - Diferenciar permissões entre **usuário comum** (restrito aos próprios documentos) e **administrador** (visualização e gerenciamento de todos os documentos).

---

## Funcionalidades

- Upload de arquivos de qualquer tipo (PDF, JPG, PNG, DOC, etc).
- Armazenamento dos arquivos diretamente no banco de dados.
- Listagem dos arquivos enviados com detalhes: ID, Nome, Tipo, Tamanho, Data.
- Download de arquivos diretamente do navegador.
- Remoção de arquivos com confirmação.
- Interface simulando um terminal antigo (MS-DOS).

---

## Estrutura do Projeto

```
/uploaddb
│
├─ index.php      # Tela principal estilo terminal para digitar comandos (list/create)
├─ upload.php     # Formulário de upload de arquivos
├─ list.php       # Lista todos os arquivos com botões de download e remover
├─ download.php   # Script que força download de um arquivo pelo ID
├─ delete.php     # Script que remove um arquivo pelo ID
└─ README.md      # Este arquivo
```

---

## Scripts do Banco de Dados

### Criação do banco

```sql
CREATE DATABASE IF NOT EXISTS upload_db;
USE upload_db;
```

### Criação da tabela `arquivos`

```sql
CREATE TABLE IF NOT EXISTS arquivos (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Identificador único do arquivo
    nome VARCHAR(255) NOT NULL,             -- Nome original do arquivo
    tipo VARCHAR(100) NOT NULL,             -- Tipo MIME do arquivo (ex: image/png)
    tamanho INT NOT NULL,                   -- Tamanho do arquivo em bytes
    conteudo LONGBLOB NOT NULL,             -- Conteúdo do arquivo (armazenado em binário)
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Data e hora de upload
);
```

---

## Explicação dos Scripts PHP

### 1. `index.php`

- Simula um terminal MS-DOS.
- Recebe o comando do usuário:
  - `list` → Redireciona para `list.php`.
  - `create` → Redireciona para `upload.php`.
- Comando inválido exibe uma mensagem de erro.

---

### 2. `upload.php`

- Formulário para envio de arquivos.
- Recebe o arquivo via `POST` e verifica se não houve erro.
- Salva no banco de dados:
  - `nome` → Nome original do arquivo.
  - `tipo` → Tipo MIME.
  - `tamanho` → Tamanho em bytes.
  - `conteudo` → Conteúdo do arquivo (LONGBLOB).
- Mostra mensagem de sucesso ou erro.

---

### 3. `list.php`

- Conecta ao banco e busca todos os arquivos ordenados por ID (mais recentes primeiro).
- Mostra uma tabela com:
  - ID, Nome, Tipo, Tamanho (formatado em KB/MB/GB), Data.
  - Botões:
    - **Download** → Baixa o arquivo (`download.php?id=ID`).
    - **Remover** → Remove o arquivo (`delete.php?id=ID`) com confirmação.

---

### 4. `download.php`

- Recebe o `id` do arquivo via GET.
- Busca o arquivo no banco e envia headers HTTP para download.
- O navegador baixa o arquivo com o nome original.

---

### 5. `delete.php`

- Recebe o `id` do arquivo via GET.
- Executa `DELETE` no banco para remover o arquivo.
- Redireciona de volta para a página de listagem (`list.php`).

---

## Observações

- O projeto **não salva arquivos no sistema de arquivos**, tudo é feito dentro do banco de dados.
- O tamanho do banco pode crescer rapidamente se muitos arquivos forem enviados.
- Ideal para **aprendizado de PHP, PDO, upload e download de arquivos**, e para introduzir conceitos de **relacionamento entre tabelas e tipos de documentos**.

---

## Como Rodar

1. Crie o banco de dados e a tabela usando os scripts acima.
2. Configure seu servidor local (XAMPP, WAMP ou similar) com PHP e MySQL.
3. Coloque os arquivos do projeto na pasta do servidor.
4. Acesse `index.php` pelo navegador.
5. Digite `create` para enviar arquivos ou `list` para ver os arquivos existentes.
