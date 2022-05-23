<?php

use models\Container;
use services\DbManager;
use services\requests\Request;

    /**
     * checkPayloadPOST
     *
     * @param  array $fields
     * @param  array $payload
     * @param  DbManager $dbm
     * @return void
     */
    function checkPayloadPOST(array $fields, array $payload, DbManager $dbm): void {

        foreach($fields as $field){
            if ( !in_array($field, array_keys($payload)) ){
                $dbm->closeConnection();
                $dbm->getResponseHandler()->badRequest();
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
     * validateUser
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
     * @param  Request $request
     * @return void
     */
    function AdminRoute(Request $request): void {

        [$header, $payload, $signature] = validateJWT($request);
        $user = getUserFromToken("$header.$payload.$signature", $request);

        // check if user is admin
        $user_is_admin = $request->getUserHandler()
                                 ->getUserById($user->getUsrId(), $request->getDbManager())
                                 ->IsAdmin();

        if ( !boolval($user_is_admin) )
            $request->getResponseHandler()->unauthorized();

        // verleng sessie met 60 min.
        extendSession(60);
    }

    /**
     * ProtectedRoute
     *
     * @param  Request $container
     * @return array
     */
    function ProtectedRoute(Request $request): array {

        $user_info = validateJWT($request);
        $user_is_admin = $user_info["usr_is_admin"];

        // verleng session 60 min voor admin, 15 voor user.
        extendSession(boolval($user_is_admin) ? 60 : 15 );

        return validateJWT($request);
    }
