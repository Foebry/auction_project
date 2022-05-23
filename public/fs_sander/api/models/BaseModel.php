<?php

use services\DbManager;

    class BaseModel{
        
        /**
         * asAssociativeArray
         *
         * @param  mixed $obj
         * @return void
         */
        public function asAssociativeArray(){
            return get_object_vars($this);
        }

        public static function checkPostPayload(array $payload, DbManager $dbm){

            $table_headers = $dbm->getTableHeaders("auction");

            foreach($table_headers as $key => $row){
                if(!in_array($key, array_keys($payload))) $dbm->getResponseHandler()->badRequest(["$key"=>"Missing value"]);

                if( $row["key"] === "PRI" ) continue;

                if( $row["datatype"] === "varchar") {
                    $value = validateString($payload[$key], $key, $row, $dbm);
                    $payload[$key] = $value;
                }
                elseif( $row["datatype"] === "int") {
                    $value = validateInteger($payload[$key], $key, $dbm);
                    $payload[$key] = $value;
                }
            }

            return $payload;
        }

        public static function checkPatchPayload(array $payload, DbManager $dbm){

            $table_headers = $dbm->getTableHeaders("auction");
            $matching_fields = [];

            foreach( $payload as $key => $value ){
                if( in_array($key, array_keys($table_headers)) ){
                    if( $table_headers[$key]["key"] === "PRI" ) continue;

                    if( $table_headers[$key]["datatype"] === "varchar" ){
                        $value = validateString($value, $key, $table_headers[$key], $dbm);
                        $matching_fields[$key] = $value;
                    }
                    elseif( $table_headers[$key]["datatype"] === "int"){
                        $value = validateInteger($value, $key, $dbm);
                        $matching_fields[$key] = $value;
                    }
                }
            }

            if( count($matching_fields) === 0 ) $dbm->getResponseHandler()->badRequest();

            foreach( $matching_fields as $key => $value ) {
                if( $key === "usr_password" ) $value = password_hash($value, 1);
                $update[] = sprintf("$key='%s'", $value);
            }

            return implode(", ", $update);
        }
    }