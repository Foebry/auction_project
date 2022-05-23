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

    function checkPayloadPATCH(array $fields, array $payload, Container $container): string {

        $matching_fields = [];

        foreach($payload as $key=>$value) {
            if ( in_array($key, array_keys($fields)) ){
                $matching_fields[$key] = $value;
            }
        }
        if( $matching_fields === 0 ) $container->getResponseHandler()->badRequest();

        $update = [];

        foreach($matching_fields as $key=>$value) {
            if ($key === "usr_password") $value = password_hash($value, 1);
            $update[] = sprintf("$key='%s'", $value);
        }

        return implode(", ", $update);
    }

    /**
     * validateJWT
     *
     * @param  Container $container
     * @return array
     */
    function validateUser(Container $container):array {

        [$header, $payload, $signature] = validateJWT($container);
        
        $header_decoded = json_decode(base64_decode($header), true);

        // check signature van token.
        if (hash_hmac($header_decoded["alg"], "BOO", "$header.$payload") !== $signature)
            $container->getResponseHandler()->unauthorized();
        
        // if signature is correct, return the userInformation + tokenExp as array
        return json_decode(base64_decode($payload), true);
    }

    /**
     * AdminRoute
     *
     * @param  Container $container
     * @return void
     */
    function AdminRoute(Container $container): void {

        [$header, $payload, $signature] = validateJWT($container);
        $user = getUserFromToken("$header.$payload.$signature", $container);
        
        // check if user is admin
        $user_is_admin = $container->getUserHandler()->getUserById($user->getUsrId(), $container)->IsAdmin();
        
        if ( !boolval($user_is_admin) )
            $container->getResponseHandler()->unauthorized();
        
        // verleng sessie met 60 min.
        extendSession(60);
    }

    /**
     * ProtectedRoute
     *
     * @param  Container $container
     * @return array
     */
    function ProtectedRoute(Container $container): array {

        $user_info = validateJWT($container);
        $user_is_admin = $user_info["usr_is_admin"];

        // verleng session 60 min voor admin, 15 voor user.
        extendSession(boolval($user_is_admin) ? 60 : 15 );

        return validateJWT($container);
    }
