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

    /**
     * validateJWT
     *
     * @param  Container $container
     * @return array
     */
    function validateJWT(Container $container):array {

        //check if a __refresh_token__ cookie was sent
        if ( !isset($_COOKIE["__refresh_token__"]) )
            $container->getResponseHandler()->unauthorized("no token present");
        
        $token = $_COOKIE["__refresh_token__"];

        //check if token has correct structure
        if ( count( explode( ".", $token ) ) != 3 )
            $container->getResponseHandler()->unauthorized("incorrect token");

        [$header, $payload, $signature] = explode(".", $token);
        
        $header_decoded = json_decode(base64_decode($header), true);

        // if signature is faked, error code 
        if (hash_hmac($header_decoded["alg"], "BOO", "$header.$payload") !== $signature)
            $container->getResponseHandler()->unauthorized("incorrect token");
        
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
        $user_info = validateJWT($container);

        // check if user is admin
        if ( $user_info["isAdmin"] !== true )
            $container->getResponseHandler()->unauthorized();

        refreshToken($user_info, 60);
    }

    /**
     * ProtectedRoute
     *
     * @param  Container $container
     * @return void
     */
    function ProtectedRoute(Container $container): void {

        $user_info = validateJWT($container);
        refreshToken($user_info);
    }
