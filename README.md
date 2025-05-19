# MeuDotEnv PORTUGUÊS

Leitor de variáveis `.env` leve e direto para projetos PHP.

Este pacote permite carregar variáveis de ambiente a partir de um arquivo `.env` para usar com `getenv()`, `$_ENV` ou `$_SERVER`, sem dependências externas além do PHP.

---

## 🚀 Instalação

Via [Composer](https://getcomposer.org):

```bash
composer require ismaelbrito/dot-env

```

## Como Usar

O uso da library e simples, primeiro crie um arquivo `.env` na raiz do seu projeto, seguindo o modelo abaixo (uma variável por linha):

```
DB_HOST=localhost
DB_USER=root
DB_PASS=pass
```

```php
<?php

require 'vendor/autoload.php';

//CARREGAR VARIAVEIS DE AMBIENTE DO ARQUIVO NA RAIZ
ismaelbrito\DotEnv\Environment::load(__DIR__);

//OBTENHA VARIÁVEL DE AMBIENTE
echo getenv('DB_HOST');

```

## Requisitos

Esta biblioteca requer PHP 7.0 ou superior.

---

# PHP Environment Variables Manager INGLÊS

A simple library for managing environment variables in PHP.

## Usage

To use this library, simply create a `.env` file at the root of the project, following the model below (one variable per line):

```
DB_HOST=localhost
DB_USER=root
DB_PASS=pass
```

```php
<?php

require 'vendor/autoload.php';

//LOAD ENVIRONMENT VARS FROM FILE ON ROOT
ismaelbrito\DotEnv\Environment::load(__DIR__);

//GET ENVIRONMENT VAR
echo getenv('DB_HOST');

```

## Requirements

This library needs PHP 7.0 or greater.
