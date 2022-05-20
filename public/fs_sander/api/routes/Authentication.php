<?php

use models\Response;
use models\Container;

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

    //check if passwords do not match
    if ( !password_verify(($payload["usr_password"]), $user->getUsrPassword()) ){
        $dbm->closeConnection();
        $container->getResponseHandler()->unprocessableEntity("Invalid password");
    }

    // renew cookie for 15min if user and 60 mins if admin
    refreshToken(
        ["usr_id"=>$user->getUsrId(), "usr_email"=>$user->getUsrEmail(), "usr_is_admin"=>$user->IsAdmin()],
        $user->IsAdmin() ? 60 : 15);

    $dbm->closeConnection();

    return new Response(["usr_name"=>$user->getUsrName(), "usr_id"=>$user->getUsrId()]);

}


/**
 * refreshToken
 *
 * @param  array $user_data
 * @param  int $minutes
 * @return void
 */
function refreshToken(array $user_data, int $minutes=15): void {

    //first section of token contains the algorithm used to hash the signature
    $header = base64_encode(json_encode(["token"=>"jwt", "alg"=>"sha256", "exp"=>time()+60*$minutes]));

    //second section of token contains the user_information
    $payload = base64_encode(json_encode($user_data));

    //third and final section of the token is the signature.
    //signature is a hashed value (hashed with a secret only known to server) of encoded headerString and payloadString combined with a "."
    $signature = hash_hmac("sha256", "BOO", "$header.$payload");

    $token = "$header.$payload.$signature";
    $expireAt = time() + 60 * $minutes;

    //set HTTP_cookie for token
    setcookie("__refresh_token__", $token, $expireAt, null, null, null, true);
}
