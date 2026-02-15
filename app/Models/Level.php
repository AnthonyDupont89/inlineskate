<?php

namespace App\Models;

use App\Database;

class Level
{
  public static function all(): array
  {
    $conn = Database::getConnection();
    $result = $conn->query('SELECT code, name, price FROM levels ORDER BY sort_order ASC');

    return $result->fetch_all(MYSQLI_ASSOC);
  }
}