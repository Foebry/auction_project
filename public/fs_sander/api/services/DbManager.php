<?php

  namespace services;

use DateTime;
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
          $host = env("DBHOST");
          $dbname = env("DBNAME");
          $dbuser = env("DBUSER");
          $dbpass = env("DBPASSWORD");

          $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        } 
        catch (PDOException $error) {
          $this->getResponseHandler()->internalServerError($this, ["message"=>$error->getMessage()]);
          die();
        }
      }
      return $this->connection;
    }

    public function closeConnection() {
      $this->connection = null;
    }

    public function getSQL($query) {

      DbManager::log($query);

        try{
          $conn = $this->getConnection();
          $result = $conn->query($query);

          return $result->rowCount() > 0 ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
        }
        catch(PDOException $exc){
          DbManager::log($exc->getMessage(), "error");

        }
    }

    public function insertSQL($query): int{

      $conn = $this->getConnection();
      
      DbManager::log($query);

      $conn->exec($query);
      $id = $conn->lastInsertId();
      
      return $id;
    }

    public function getTableHeaders(string $table): array{
      $headers = [];

      $data = $this->getSQL(sprintf("SELECT * from information_schema.columns where table_name='%s' and table_schema='fs_sander'", $table));

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

    public static function log($msg, $mode="log"){

      $logfile = env("LOGFILE_LOG");
      $now = new DateTime("now");
      $time = $now->format("Y-m-d H:i:s");

      if( $mode === "error" ) $logfile = env("LOGFILE_ERROR");

      if(strpos($logfile, "ROOT") !== false){
        $logfile = str_replace("ROOT", $_SERVER["DOCUMENT_ROOT"], $logfile);
      }

      // exit(print($logfile));

      $fs = fopen($logfile, "a");
      fwrite($fs, "$time - $msg \n");
      fclose($fs);
    }

  }