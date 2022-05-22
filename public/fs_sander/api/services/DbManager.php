<?php

namespace services;

use PDO;
use PDOException;

class DbManager {
  private $connection;
  private $responseHandler;

  public function __construct($responseHandler) {
    $this->connection = null;
    $this->responseHandler = $responseHandler;
  }

  public function getConnection() {
    if ($this->connection === null) { 
      try {
        $this->connection = new PDO('mysql:host=185.115.218.166;dbname=fs_sander', 'fs_sander', 'Y8SkDIvlwM8Y');
      } 
      catch (PDOException $error) {
        $this->responseHandler->internalServerError($error);
        die();
      }
    }
    return $this->connection;
  }

  public function closeConnection() {
    $this->connection = null;
  }

  public function getSQL($query) {
    $conn = $this->getConnection();
    $result = $conn->query($query);

    return $result->rowCount() > 0 ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
  }

  public function insertSQL($query): int{
    $conn = $this->getConnection();

    $conn->query($query);

    return $this->getLastInsertId();
  }

  private function getLastInsertId(): int{
    $conn = $this->getConnection();

    $result = $conn->query("SELECT LAST_INSERT_ID() as id");
    $id = $result->fetch(PDO::FETCH_ASSOC)["id"];

    return $id;
  }

}