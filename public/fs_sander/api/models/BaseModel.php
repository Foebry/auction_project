<?php

    namespace models;
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

        public static function checkPostPayload($table, array $payload, DbManager $dbm){

            $table_headers = $dbm->getTableHeaders($table);

            foreach($table_headers as $key => $row){
                if( $row["key"] === "PRI") continue;

                $can_be_null = $row["is_null"] === "YES";
                $included = in_array($key, array_keys($payload));

                if( !$included && !$can_be_null ) {
                    $dbm->getResponseHandler()->badRequest($dbm, ["$key"=>"Missing value"]);
                }
                elseif( !$included && $can_be_null ) continue;

                if( $row["datatype"] === "varchar") {
                    $value = validateString($table, $payload[$key], $key, $row, $dbm);
                    $payload[$key] = $value;
                }
                elseif( $row["datatype"] === "int") {
                    $value = validateInteger($payload[$key], $key, $dbm);
                    $payload[$key] = $value;
                }
                elseif ($row["datatype"] === "double"){
                    $value = validateFloat($payload[$key], $key, $dbm);
                    $matching_fields[$key] = $value;
                }
            }

            return $payload;
        }

        public static function checkPatchPayload($table, array $payload, DbManager $dbm){

            $table_headers = $dbm->getTableHeaders($table);
            $matching_fields = [];
            
            foreach( $payload as $key => $value ){
                if( in_array($key, array_keys($table_headers)) ){

                    $datatype = $table_headers[$key]["datatype"];

                    if( $table_headers[$key]["key"] === "PRI" ) continue;

                    if( $datatype === "varchar" ){
                        $value = validateString($table, $value, $key, $table_headers[$key], $dbm, true);
                        if ($value !== "") $matching_fields[$key] = $value;
                    }
                    elseif( $datatype === "int"){
                        $value = validateInteger($value, $key, $dbm);
                        $matching_fields[$key] = $value;
                    }
                    elseif ($datatype === "double"){
                        $value = validateFloat($value, $key, $dbm);
                        $matching_fields[$key] = $value;
                    }
                    elseif( $datatype === "timestamp"){
                        $value = validateTimestamp($value, $key, $dbm);
                        $matching_fields[$key] = $value;
                    }
                }
            }

            if( count($matching_fields) === 0 ) return "";

            foreach( $matching_fields as $key => $value ) {
                if( $key === "usr_password" ) $value = password_hash($value, 1);
                $update[] = sprintf("$key='%s'", $value);
            }

            return implode(", ", $update);
        }
    }