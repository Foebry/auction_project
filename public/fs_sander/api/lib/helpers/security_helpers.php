<?php

    use models\User;
    use services\requests\Request;

function generateCSRF(): string {

    return hash_hmac("sha256", session_id(), "BOO");
}

function validateJWT(Request $request){
    if(!isset($_SESSION)) session_start();
    
    //check if a jwt cookie was sent
    if ( !isset($_COOKIE["jwt"]) ) {
        
        // indien geen "jwt" cookie EN geen refresh_token, gebruiker is niet ingelogd.
        if( !isset($_SESSION["__refresh_token__"]) ) {
            
            $request->getResponseHandler()->unauthorized(
                $request->getDbManager(),
                ["message"=>"Please log in to perform this action", "expired"=>"Session Expired. Not logged in"]
            );
        }
        // indien geen "jwt" cookie maar WEL refresh_token, gebruiker cookie vervallen.
        // indien session niet expired, genereer een nieuwe jwt.
        $user = getUserFromToken($_SESSION["__refresh_token__"], $request);
        
        if( !sessionExpired() ) $token = createJwtCookie($user);

        // session is expired.
        else {
            destroySession();
            $request->getResponseHandler()->unauthorized(
                $request->getDbManager(),
                ["message"=>"Session expired", "expired"=>"Session Expired"]
            );
        }
    }
    else $token = $_COOKIE["jwt"];

    // check structuur van token.
    if ( count( explode( ".", $token ) ) != 3 )
        $request->getResponseHandler()->unauthorized(
            $request->getDbManager(),
            ["message"=>"wrong token format"]
        );

    return explode(".", $token);
}

function getUserFromToken(string $token, Request $request): User {

        
    $user_data = json_decode(base64_decode(explode(".", $token)[1]), true);

    $usr_id = $user_data["usr_id"];

    return $request->getUserHandler()->getUserById($usr_id, $request->getDbManager());
}