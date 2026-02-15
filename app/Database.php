<?php

namespace App;

use mysqli;

class Database
{
  private static ?mysqli $connection = null;

  public static function getConnection(): mysqli
  {
    if (self::$connection === null) {
      self::$connection = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME']
      );

      if (self::$connection->connect_error) {
        throw new \RuntimeException('Erreur de connexion à la base de données.');
      }

      self::$connection->set_charset('utf8mb4');
    }

    return self::$connection;
  }
}