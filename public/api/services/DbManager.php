<?php

class DbManager {

  public function __construct() {
    $this->connectDB();
  }

  private function connectDB() {
    try {
      $db = new PDO('mysql:host=185.115.218.166;dbname=fs_sander', 'fs_sander', 'Y8SkDIvlwM8Y');
      print 'Connection made';
      return $db;
    } catch (PDOException $error) {
      print 'ERROR' . $error->getMessage() . '<br/>';
      die();
    }
  }

  public function getSQL($query) {
    $conn = $this->connectDB();
    $result = $conn->query($query);

    return $result->rowCount() > 0 ? $result->fetchAll(PDO::FETCH_ASSOC) : 'No result';
  }

}