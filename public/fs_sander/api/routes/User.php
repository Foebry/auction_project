<?php

use models\Response;
use models\User;

    /**
     * @param \models\Container $container
     * @param string $payload
     * @return Response
     */
    function handleRegister( \models\Container $container, string $payload ):\models\Response {
        $dbm = $container->getDbManager();
        $payload = json_decode($payload, true);
        
        // check if all required fields are sent
        if (
            !in_array("usr_name", array_keys($payload))||
            !in_array("usr_email", array_keys($payload)) || 
            !in_array("usr_password", array_keys($payload))
        ) {
            $dbm->closeConnection();
            $container->getResponseHandler()->badRequest();
        }

        // check if email is taken
        $users = $dbm->getSQL(
            sprintf("select usr_email from gw_user where usr_email = '%s'", $payload["usr_email"])
        );
        
        if ($users){
            $dbm->closeConnection();
            $container->getResponseHandler()->unprocessableEntity("This emailadress is taken");
        }

        $user = new User(
            null,
            $payload["usr_name"],
            $payload["usr_email"],
            password_hash($payload["usr_password"], 1)
        );
        
        // retrieve id from newly inserted entity
        $id = $dbm->insertSQL(
            sprintf(
                "INSERT into gw_user (usr_name, usr_email, usr_password) values('%s', '%s', '%s')",
                $user->getUsrName(), $user->getUsrEmail(), $user->getUsrPassword()
            ));
        
        $dbm->closeConnection();

        return new Response(["usr_id"=>$id, "usr_name"=>$user->getUsrName()]);
    }

    function getUserDetail($id) {
        print("GET user detail logic");
    }

    function patchUser($id, $payload){
        print("PATCH user detail logic");
    }

    function updateUser($payload){
        print("PUT user detail logic");
    }

    function getUserArticles($id) {
        print("GET user articles logic");
    }