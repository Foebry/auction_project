<?php

use models\Response;

/**
 * handleAuthentication
 *
 * @param  \models\Container $container
 * @param  string $payload
 * @return \models\Response
 */
function handleAuthentication(\models\Container $container, string $payload): Response {
    $payload = json_decode($payload, true);

    // check if required fields are sent
    if (
        !in_array("usr_email", array_keys($payload)) ||
        !in_array("usr_password", array_keys($payload))
    ) {
        $container->getResponseHandler()->badRequest();
    }

    $user = $container->getUserHandler()->getUserByEmail($payload["usr_email"], $container);

    if ( !password_verify(($payload["usr_password"]), $user->getUsrPassword()) ){
        $container->getResponseHandler()->unprocessableEntity("Invalid password");
    }
    $container->getDbManager()->closeConnection();

    return new Response(["usr_id"=>$user->getUsrId(), "usr_name"=>$user->getUsrName()]);

}