<?php
  declare(strict_types=1);

  function database_connect() : PDO {
    $databasePath = __DIR__ . '/../Data/database.db';
    $dbh = new PDO('sqlite:' . $databasePath);
    return $dbh;
  }
  
?>