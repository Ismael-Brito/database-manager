<?php

namespace IsmaelBrito\DatabaseManager;

use \PDO;
use \PDOException;
use \PDOStatement;

class Database
{

  /**
   * Host de conexão com o banco de dados
   * @var string
   */
  private static $host;

  /**
   * Nome do banco de dados
   * @var string
   */
  private static $name;

  /**
   * Usuário do banco
   * @var string
   */
  private static $user;

  /**
   * Senha de acesso ao banco de dados
   * @var string
   */
  private static $pass;

  /**
   * Porta de acesso ao banco
   * @var integer
   */
  private static $port;

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $table;

  /**
   * Instancia de conexão com o banco de dados
   * @var PDO
   */
  private $connection;

  /**
   * Método responsável por configurar a classe
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   */
  public static function config(string $host, string $name, string $user, string $pass, int $port = 3306): void
  {
    self::$host = $host;
    self::$name = $name;
    self::$user = $user;
    self::$pass = $pass;
    self::$port = $port;
  }

  /**
   * Define a tabela e instancia e conexão
   * @param string $table
   */
  public function __construct($table = null)
  {
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection()
  {
    
    if (!self::$host || !self::$name || !self::$user) {
        throw new \RuntimeException('Configuração do banco incompleta.');
    }
    
    try {
      $this->connection = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$name . ';port=' . self::$port, self::$user, self::$pass);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      throw new \RuntimeException('Erro na conexão com o banco: ' . $e->getMessage());
    }
  }

  /**
   * Método responsável por acessar o PDO diretamente de uma conexão com o banco de dados
   */
  public function getConnection(): PDO
  {
    return $this->connection;
  }

  public function beginTransaction(): void {
    $this->connection->beginTransaction();
  }
  
  public function commit(): void {
    $this->connection->commit();
  }
  
  public function rollBack(): void {
    $this->connection->rollBack();
  }


  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute(string $query, array $params = []): PDOStatement
  {
    try {
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    } catch (PDOException $e) {
      throw new \RuntimeException('Erro na conexão com o banco: ' . $e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert(array $values): int
  {
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([], count($fields), '?');

    //MONTA A QUERY
    $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

    //EXECUTA O INSERT
    $this->execute($query, array_values($values));

    //RETORNA O ID INSERIDO
    return $this->connection->lastInsertId();
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select(
    ?string $where = null,
    ?string $order = null,
    ?string $limit = null,
    string $fields = '*'
  ): \PDOStatement {
    
    //DADOS DA QUERY
    $where = isset($where) && trim($where) !== '' ? 'WHERE ' . trim($where) : '';
    $order = isset($order) && trim($order) !== '' ? 'ORDER BY ' . trim($order) : '';
    $limit = isset($limit) && trim($limit) !== '' ? 'LIMIT ' . trim($limit) : '';

    //MONTA A QUERY
    $query = trim("SELECT $fields FROM {$this->table} $where $order $limit");

    //EXECUTA A QUERY
    return $this->execute($query);
  }
  
  /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update(string $where, array $values): bool
  {
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $set = implode(', ', array_map(fn($f) => "$f = ?", $fields));
    $query = "UPDATE {$this->table} SET $set WHERE $where";


    //EXECUTAR A QUERY
    $this->execute($query, array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete(string $where, array $params = []): bool
  {
    //MONTA A QUERY
    $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

    //EXECUTA A QUERY
    $this->execute($query, $params);

    //RETORNA SUCESSO
    return true;
  }
}
