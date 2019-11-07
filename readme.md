# Teste - Send4
O presente projeto é uma API para gerenciar contatos e mensagens.

**Autor** Anderson Nunes da Silva<br>
**Email** contato@andersonsilva.dev

## Overview
O projeto foi desenvolvido em Laravel, com banco de dados inicialmente configurado para o mariadb, porém irá rodar em boa parte dos bancos relacionais.
O Laradock foi utilizado para facilitar a portabilidade do projeto.

## Pré-requisitos
Para que o projeto rode em sua máquina é necessário ter instalado os seguintes ítens:
 - Git
 - Docker

## Testando o projeto

1. Clone o projeto do github:

```git clone https://github.com/andersonef/send4-api ```

2. Acesse o diretório **laradock** dentro do projeto clonado

```cd send4-api/laradock```

3. Clone o Laradock para dentro do projeto

```git clone https://github.com/Laradock/laradock.git```

4. Acesse a pasta do laradock

```cd laradock```

5. Renomeie o env-example para .env

```cp env-example .env```

6. Levante os containeres

```docker-compose up -d nginx mariadb adminer```

7. Acesse a url: **http://localhost**

## Usando Insomnia
Com o Insomnia é possível testar todas as chamadas, bem como ler a documentação de cada uma.

Para isso é necessário importar os dados JSON do Insomnia

1. Abra o Insomnia
2. Clique no menu do Workspace
3. Clique na opção Import/Export
4. Clique em Import Data
5. From file
6. Localize o arquivo **insomnia-data.json** dentro desse repositório 

# Documentação das APIs

Abaixo segue a documentação individual de cada chamada da API. A mesma está disponível dentro do Insomnia também.

# Listar Contatos
Retorna a lista de contatos existentes no banco de dados. Se um limite não for informado, o sistema listará os 50 primeiros resultados.

## Parâmetros
 - *limit*: valor numérico indicando a quantidade de registros que deseja-se obter. Mínimo: 1, Máximo: 50.
 - *offset*: valor numérico indicando a quantidade de registros a partir do primeiro a se pesquisar. Mínimo: 0. 
 - *q*: valor alfanumérico usado para pesquisar registros específicos.
 
## Exemplos

### GET /api/contatos
Retorna a lista com os 50 primeiros registros

### GET /api/contatos?limit=10
Retorna a lista com os 10 primeiros registros

### GET /api/contatos?limit=10&offset=10
Retorna a lista cmo os 10 primeiros registros a partir do décimo registro, ou seja, os registros entre 10-20.


### GET /api/contatos?limit=10&q=joao
Retorna a lista com os 10 primeiros registros que contenham "joao" em algum de seus campos pesquisáveis (nome, sobrenome, email e telefone)

# Cadastrar Contatos

Cadastra um novo contato no banco de dados

## Requisição

POST /api/contatos
```
{
  "nome_contato": "Nome do contato",
  "sobrenome_contato": "Sobrenome do contato",
  "email_contato": "Email do contato",
  "telefone_contato": "Telefone do contato"
}
```

## Regras
 - Todos os campos são obrigatórios
 - Nome e sobrenome requer pelo menos 3 caracteres
 - Email deve possuir formato válido e deve ser único no banco de dados
 - Telefone deve possuir o seguinte formato: +## (###) ####-#####
   - Código do país deve possuir de 1 a 3 dígitos
   - Código do estado deve possuir de 2 a 3 dígitos
   - Telefone deve ser separado em 4 dígitos, hífen, 5 dígitos ou 5 dígitos, hífen e 4 dígitos.
   
## Resposta
Caso o cadastro ocorra com sucesso a seguinte resposta será devolvida:
```
{
  "status": "success",
  "data": {
    "id": 1,
    "nome_contato": "Nome do contato",
    "sobrenome_contato": "Sobrenome do contato",
    "email_contato": "Email do contato",
    "telefone_contato": "Telefone do contato"
  }
}
```

Caso um erro tenha ocorrido, a seguinte resposta será devolvida:
```
{
  "status": "error",
  "data": "Mensagem de erro da exception"
}
```

# Editar Contatos

Altera as informações de um determinado contato

## Requisição
PUT /api/contatos/{id}
```
{
  "nome_contato": "Nome do contato",
  "sobrenome_contato": "Sobrenome do contato",
  "email_contato": "Email do contato",
  "telefone_contato": "Telefone do contato"
}
```

## Regras
A alteração de um contato está sujeita às mesmas regras da criação do contato.

## Resposta
Caso a requisição tenha sido processada com sucesso, essa será a resposta
```
{
  "status": "success",
  "data": {
    "nome_contato": "Nome do contato",
    "sobrenome_contato": "Sobrenome do contato",
    "email_contato": "Email do contato",
    "telefone_contato": "Telefone do contato"
  }
}
```
Caso contrário, a resposta será:
```
{
  "status": "error",
  "data": "Mensagem da exception"
}
```

# Excluir Contato

Exclui um contato caso o mesmo não possua nenhuma mensagem atrelada a ele.

## Requisição
DELETE /api/contatos/{id}

## Regras
 - O id precisa ser de um contato válido
 - O contato não pode possuir mensagens atreladas a ele
 
## Resposta
Caso a exclusão tenha ocorrido com sucesso, a seguinte resposta será retornada pelo servidor:

```
{
  "status": "success",
  data: true
}
```

Caso um erro ocorra, será a seguinte resposta:

```
{
  "status": "error",
  data: "Mensagem da exception"
}
```

# Listar mensagens de um contato

Retorna a lista de mensagens de um determinado contato. Se um limite não for informado, o sistema listará os 50 primeiros resultados.

## Parâmetros
 - *limit*: valor numérico indicando a quantidade de registros que deseja-se obter. Mínimo: 1, Máximo: 50.
 - *offset*: valor numérico indicando a quantidade de registros a partir do primeiro a se pesquisar. Mínimo: 0. 
 - *q*: valor alfanumérico usado para pesquisar registros específicos.
 
## Exemplos

### GET /api/mensagens/{contato_id}
Retorna a lista com os 50 primeiros registros

### GET /api/mensagens/{contato_id}?limit=10
Retorna a lista com os 10 primeiros registros

### GET /api/mensagens/{contato_id}?limit=10&offset=10
Retorna a lista cmo os 10 primeiros registros a partir do décimo registro, ou seja, os registros entre 10-20.


### GET /api/mensagens/{contato_id}?limit=10&q=joao
Retorna a lista com os 10 primeiros registros que contenham "joao" em algum de seus campos pesquisáveis (nesse caso, apenas o campo: descricao_mensagem)

# Cadastrar Mensagem

Cadastra uma nova mensagem no banco de dados

## Requisição

POST /api/mensagens
```
{
  "contato_id": 3
  "descricao_mensagem": "Texto com a descrição da mensagem"
}
```

## Regras
 - Todos os campos são obrigatórios
 - O campo contato_id deve ser numérico, maior que zero e deve representar o id de um contato existente
   
## Resposta
Caso o cadastro ocorra com sucesso a seguinte resposta será devolvida:
```
{
  "status": "success",
  "data": {
    "id": 1,
    "contato_id": 1
    "descricao_mensagem": "Descrição da mensagem salva"
  }
}
```

Caso um erro tenha ocorrido, a seguinte resposta será devolvida:
```
{
  "status": "error",
  "data": "Mensagem de erro da exception"
}
```

# Editar Mensagem

Altera as informações de uma determinada mensagem

## Requisição
PUT /api/mensagens/{id}
```
{
  "contato_id": 5
  "descricao_mensagem": "mensagem alterada"
}
```

## Regras
A alteração de um contato está sujeita às mesmas regras da criação da mensagem.

## Resposta
Caso a requisição tenha sido processada com sucesso, essa será a resposta
```
{
  "status": "success",
  "data": {
    "id": 55,
    "contato_id": 5
    "descricao_mensagem": "mensagem alterada"
  }
}
```
Caso contrário, a resposta será:
```
{
  "status": "error",
  "data": "Mensagem da exception"
}
```

# Excluir Mensagem

Exclui uma mensagem.

## Requisição
DELETE /api/mensagens/{id}

## Regras
 - O id precisa ser de uma mensagem válida
 
## Resposta
Caso a exclusão tenha ocorrido com sucesso, a seguinte resposta será retornada pelo servidor:

```
{
  "status": "success",
  data: true
}
```

Caso um erro ocorra, será a seguinte resposta:

```
{
  "status": "error",
  data: "Mensagem da exception"
}
```