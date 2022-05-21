<?php

use models\Response;
use models\Container;
use models\User;

/**
 * handleAuthentication
 *
 * @param  Container $container
 * @param  string $payload
 * @return Response
 */
function handleAuthentication(Container $container, string $payload): Response {
    $payload = json_decode($payload, true);
    $dbm = $container->getDbManager();

    // check if required fields are sent
    if (
        !in_array("usr_email", array_keys($payload)) ||
        !in_array("usr_password", array_keys($payload))
    ) {
        $container->getResponseHandler()->badRequest();
    }

    $user = $container->getUserHandler()->getUserByEmail($payload["usr_email"], $container);

    if ( !password_verify(($payload["usr_password"]), $user->getUsrPassword()) ){
        $dbm->closeConnection();
        $container->getResponseHandler()->unprocessableEntity("Invalid password");
    }
    $jwt = generateJWT($user, $payload["usr_password"]);

    $dbm->closeConnection();

    return new Response(["usr_name"=>$user->getUsrName(), "token"=>$jwt]);

}


function generateJWT(User $user): string {

    //first section of token contains the algorithm used to hash the signature
    $header = base64_encode(json_encode(["token"=>"jwt", "alg"=>"sha256"]));

    //second section of token contains the user_information + token expiration
    $payload = base64_encode(json_encode([
        "usr_email"=>$user->getUsrEmail(),
        "isAdmin"=>$user->isAdmin(),
        "exp"=> strtotime("now + 1 hour")
    ]));

    //third and final section of the token is the signature.
    //signature is a hashed value (hashed with a secret only known to server) of encoded headerString and payloadString combined with a "."
    $signature = hash_hmac("sha256", "BOO", "$header.$payload");

    return "$header.$payload.$signature";
}

function handleLogout(): Response {

    unset($_COOKIE["__refresh_token__"]);

    return new Response([], 204);
}