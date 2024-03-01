<?php

// Ici design pattern Singleton

namespace App\DB;

use PDO;
use PDOException;

class Db extends PDO
{
  // instance unique de la class
  private static $instance;

  // informations de connexion
  private const DBHOST = 'localhost';
  private const DBUSER = 'root';
  private const DBPASS = 'root';
  private const DBNAME = 'monimate_php';

  private function __construct()
  {
    $_dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::DBHOST;

    try {
      parent::__construct($_dsn, self::DBUSER, self::DBPASS);


      $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
      $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  // on récupère l'instance unique
  public static function getInstance():self // retourne DB ou PDO
  {
    // si pas encore instancié, on l'instance
    if(self::$instance === null) {
      self::$instance = new self(); // self = class DB
    }
    // sinon on retourne l'instance
    return self::$instance;
  }
}
