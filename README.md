# Database PORTUGUÊS

Este projeto é uma estrutura modular em PHP puro (sem frameworks), organizado em uma classe simples para gerenciar conexões e operações com bancos de dados usando PDO.

## 🚀 Funcionalidades

- Inserção de dados
- Totalmente orientado a objetos
- Conexão com banco de dados MySQL via PDO
- Classe de banco de dados com suporte a:
  - `select`, `insert`, `update`, `delete`
  - Tipagem moderna (`string`, `array`, `PDOStatement`, etc)
  - Conexão via PDO com tratamento de erros
- Métodos disponíveis:
  - `beginTransaction()`: Inicia a transação.
  - `commit()`: Confirma todas as operações realizadas durante a transação.
  - `rollBack()`: Reverte todas as opreações em caso de erro.
- Seleção com cláusulas WHERE, ORDER BY, LIMIT
- Atualização e exclusão de registros
- Interface fluida e fácil de usar
- Preparado para uso em ambiente local (WAMP) e produção

---

## 🚀 Instalação

Adicione a classe ao seu projeto (via autoloader do Composer)
[Composer](https://packagist.org/packages/ismaelbrito/database-manager):

```bash
composer require ismaelbrito/database-manager

```

## Como Usar

O uso da library e simples, seguindo o modelo abaixo:

```
<?php

require 'vendor/autoload.php';

use IsmaelBrito\DatabaseManager\Database;

Database::config(
  'localhost',       // host
  'nome_do_banco',   // nome do banco
  'usuario',         // usuário
  'senha',           // senha
  3306               // porta (opcional, padrão é 3306)
);

```

## 🧪 Exemplos de Uso

```php


/*Criar uma instância*/
$db = new Database('usuarios'); // nome da tabela


/*Inserir dados*/
$id = $db->insert([
  'nome' => 'Ismael Brito',
  'email' => 'ismael@email.com'
]);


/*Selecionar dados*/
$results = $db->select('id > 10', 'id DESC', '10');

foreach ($results as $row) {
  print_r($row);
}


/*Atualizar dados*/
$db->update('id = 1', [
  'nome' => 'Ismael Atualizado'
]);


/*Deletar dados*/
$db->delete('id = 1');


/*Acessar o objeto PDO diretamente*/
$pdo = $db->getConnection();


```

## Exemplos de uso das Transações

```php

use IsmaelBrito\DatabaseManager\Database;

$db = new Database('usuarios');

try {
    $db->beginTransaction();

    $db->insert([
        'nome' => 'Ismael',
        'email' => 'ismael@email.com'
    ]);

    $db->update('id = ?', [
        'nome' => 'Ismael Brito',
        1
    ]);

    $db->commit();
    echo 'Transação concluída com sucesso!';
} catch (Exception $e) {
    $db->rollBack();
    echo 'Erro na transação: ' . $e->getMessage();
}


```

## 🛑 IMPORTANTE 

- Sempre envolva transações em blocos `try/catch`.
- Use `rollBack()` dentro do `catch` para garantir integridade dos dados.
- Após `commit()` ou `rollBack()`, a transação é finalizada - uma nova deve ser iniciada se necessário

---  

## Requisitos

- Esta biblioteca requer PHP 7.0 ou superior.
- Extensão PDO habilitada

---


# Database (ENGLISH)

This project is a modular structure built with pure PHP (no frameworks), organized into a simple class to manage database connections and operations using PDO.

## 🚀 Features

- Data insertion
- Fully object-oriented
- MySQL database connection via PDO
- Database class supports:
  - `select`, `insert`, `update`, `delete`
  - Modern type hinting (`string`, `array`, `PDOStatement`, etc.)
  - PDO connection with error handling
- Select queries with `WHERE`, `ORDER BY`, `LIMIT` clauses
- Record updates and deletions
- Simple and intuitive interface
- Ready for use in both local (e.g., WAMP) and production environments

---

## 🚀 Installation

Add the class to your project via Composer's autoloader:  
[Composer - Packagist](https://packagist.org/packages/ismaelbrito/database-manager)

```bash
composer require ismaelbrito/database-manager
```

## 📦 How to Use

Using this library is simple, just follow the example below:

```php
<?php

require 'vendor/autoload.php';

use IsmaelBrito\DatabaseManager\Database;

Database::config(
  'localhost',       // host
  'database_name',   // database name
  'username',        // user
  'password',        // password
  3306               // port (optional, default is 3306)
);
```

## 🧪 Usage Examples

```php
/* Create an instance */
$db = new Database('users'); // table name

/* Insert data */
$id = $db->insert([
  'name' => 'Ismael Brito',
  'email' => 'ismael@email.com'
]);

/* Select data */
$results = $db->select('id > 10', 'id DESC', '10');

foreach ($results as $row) {
  print_r($row);
}

/* Update data */
$db->update('id = 1', [
  'name' => 'Updated Ismael'
]);

/* Delete data */
$db->delete('id = 1');

/* Access the PDO object directly */
$pdo = $db->getConnection();

```

## 📋 Requirements

- This library requires PHP 7.0 or higher
- PDO extension must be enabled

---
