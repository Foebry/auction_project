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
function handleLogin(Container $container, string $payload): Response {
    $payload = json_decode($payload, true);
    $dbm = $container->getDbManager();

    // check if required fields are sent
    if (
        !in_array("usr_email", array_keys($payload)) ||
        !in_array("usr_password", array_keys($payload)) //||
        // !in_array("csrf", array_keys($payload)) ||
        // !in_array("form-key", array_keys($payload))
    ) {
        $container->getResponseHandler()->badRequest(["message"=>"Invalid form"]);
    }

    $user = $container->getUserHandler()->getUserByEmail($payload["usr_email"], $container);
    $_SESSION["response"] = [];
    $_SESSION["response"]["user in handlelogin"] = json_encode($user->asAssociativeArray());
    //check if passwords do not match
    if ( !password_verify(($payload["usr_password"]), $user->getUsrPassword()) ){
        $dbm->closeConnection();
        $container->getResponseHandler()->unprocessableEntity(["message"=>"Invalid data", "usr_password"=>"Invalid password"]);
    }

    startSession($user->getUsrId(), $container);

    $dbm->closeConnection();

    return new Response([
        "usr_name"=>$user->getUsrName(),
        "usr_id"=>$user->getUsrId(),
        "csrf"=>$_SESSION["csrf"]
    ]);

}


/**
 * refreshToken
 *
 * @param  User $user_data
 * @param  int $minutes
 * @return string
 */
function generateJWT(User $user, int $minutes=5): string {

    // Eerste deel van de JWT bevat info over algoritme & vervaltijd (om steeds nieuwe token te creëren)
    $header = base64_encode(json_encode(["token"=>"jwt", "alg"=>"sha256", "exp"=>time()+60*$minutes]));

    // Tweede deel van de JWT bevat info over de user
    if( $user ) {
        $user_data = ["usr_id"=>$user->getUsrId(), "usr_email"=>$user->getUsrEmail(), "usr_password"=>$user->getUsrPassword()];
        $payload = base64_encode(json_encode($user_data));
    }
    else $payload = explode(".", $_SESSION["__refresh_token__"])[1];

    // Derde en laatste deel van de JWT is een signature.
    // De signature is de gehashte waarde van "$header.$payload" volgens het algoritme bepaald in de $header
    $signature = hash_hmac("sha256", "BOO", "$header.$payload");

    return "$header.$payload.$signature";
}

function createJwtCookie(User $user): string {

    $minutes = boolval($user->IsAdmin()) ? 15 : 5;

    $token = generateJWT($user, $minutes);

    $expireAt = time() + 60 * $minutes;
    $options = ["expires"=>$expireAt, "secure"=>true, "httponly"=>true, "SameSite"=>"None"];

    //set HTTP_cookie for token
    setcookie("jwt", $token, $options);

    return $token;
}

function handleLogout(): Response {

    $token = $_COOKIE["jwt"];

    $options = ["expires"=>time(), "secure"=>true, "httponly"=>true, "SameSite"=>"None"];
    // laat cookie vervallen
    setcookie("jwt", $token, $options);
    unset($_COOKIE["jwt"]);

    destroySession();

    return new Response([], 204);
}
