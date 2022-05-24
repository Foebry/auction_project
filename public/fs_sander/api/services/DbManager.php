<?php

  namespace services;

  use PDO;
  use PDOException;
  use services\handlers\ResponseHandler;

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

    public function getTableHeaders(string $table): array{
      $headers = [];

      $data = $this->getSQL("SELECT * from information_schema.columns where table_name=$table and table_schema='fs_sander'");

      foreach($data as $row){
        $column = $row["COLUMN_NAME"];
        $column_datatype = $row["DATA_TYPE"];
        $column_key = $row["COLUMN_KEY"];
        $column_max_length = $row["CHARACTER_MAXIMUM_LENGTH"];
        $is_null = $row["IS_NULLABLE"];

        // nieuwe associatieve array aanmaken met nodige data. en toevoegen aan de $headers array
        $headers[$column] = [];
        $headers[$column]["datatype"] = $column_datatype;
        $headers[$column]["key"] = $column_key;
        $headers[$column]["max_size"] = $column_max_length;
        $headers[$column]["is_null"] = $is_null;
      }

      return $headers;
    }

    public function getResponseHandler(): ResponseHandler {
      if( $this->responseHandler === null ){
        $this->responseHandler = new ResponseHandler();
      }
      return $this->responseHandler;
    }

  }