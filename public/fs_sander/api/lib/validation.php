<?php

use models\Container;
    
    /**
     * checkPayloadPOST
     *
     * @param  array $fields
     * @param  array $payload
     * @param  Container $container
     * @return void
     */
    function checkPayloadPOST(array $fields, array $payload, Container $container): void {

        foreach($fields as $field){
            if ( !in_array($field, array_keys($payload)) ){
                $container->getDbManager()->closeConnection();
                $container->getResponseHandler()->badRequest();
            }
        }
    }

    function validateJWT(string $token): false | array {
        [$header, $payload, $signature] = explode(".", $token);
        
        $header_decoded = json_decode(base64_decode($header), true);

        // if signature is faked, return false
        if (hash_hmac($header_decoded["alg"], "BOO", "$header.$payload") !== $signature)
            return false;
        
        // if signature is correct, return the userInformation + tokenExp as array
        return json_decode(base64_decode($payload), true);
    }
