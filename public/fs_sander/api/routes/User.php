<?php

use models\Response;
use models\User;
use models\Container;

    /**
     * @param Container $container
     * @param string $payload
     * @return Response
     */
    function handleRegister( Container $container, string $payload ): Response {
        $dbm = $container->getDbManager();
        $payload = json_decode($payload, true);
        
        // check if all required fields are sent
        if (
            !in_array("usr_name", array_keys($payload))||
            !in_array("usr_email", array_keys($payload)) || 
            !in_array("usr_password", array_keys($payload)) ||
            !in_array("usr_lastname", array_keys($payload))
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
            $container->getResponseHandler()->unprocessableEntity(["message"=>"Unproccesable Entity", "usr_email"=>"This emailadress is taken"]);
        }

        $user = new User(
            null,
            $payload["usr_name"],
            $payload["usr_lastname"],
            $payload["usr_email"],
            password_hash($payload["usr_password"], 1)
        );
        
        // retrieve id from newly inserted entity
        $usr_id = $dbm->insertSQL(
            sprintf(
                "INSERT into gw_user (usr_name, usr_lastname, usr_email, usr_password) values('%s', '%s', '%s', '%s')",
                $user->getUsrName(), $user->getLastName(), $user->getUsrEmail(), $user->getUsrPassword()
            ));
        
        $user->setUsrId($usr_id);

        startSession($user);
        
        $dbm->closeConnection();

        return new Response(["usr_name"=>$user->getUsrName(), "usr_id"=>$user->getUsrId(), "csrf"=>$_SESSION["csrf"]]);
    }

    function getUserDetailSelf( Container $container, array $user_data ): Response {

        $email = $user_data["usr_email"];
        $user = $container->getUserHandler()->getUserByEmail($email, $container);

        $container->getDbManager()->closeConnection();

        return new Response($user->asAssociativeArray(), 200);
    }

    function PatchUserSelf( string $payload, Container $container, array $user_data ): Response {

        $payload = json_decode($payload, true);

        $payload = checkPayloadPATCH(["usr_name", "usr_lastname", "usr_email", "usr_password"], $payload, $container);

        $usr_id = $container->getUserHandler()->getUserByEmail($user_data["usr_email"], $container)->getUsrId();

        $container->getDbManager()->getSQL("UPDATE gw_user SET $payload where usr_id = $usr_id");
        $user = $container->getUserHandler()->getUserById($usr_id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($user->asAssociativeArray(), 200);
    }

    function getUserDetail(int $id, Container $container): Response {

        $user = $container->getUserHandler()->getUserById($id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($user->asAssociativeArray(), 200);
    }

    function updateUser(int $usr_id, string $payload, Container $container): Response {

        $payload = json_decode($payload, true);

        $payload = checkPayloadPATCH(["usr_name", "usr_lastname", "usr_email", "usr_is_admin"], $payload, $container);

        $container->getDbManager()->getSQL("UPDATE gw_user set $payload where usr_id = $usr_id");
        $user = $container->getUserHandler()->getUserById($usr_id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($user->asAssociativeArray(), 200);
    }

    function deleteUser(int $usr_id, Container $container): Response {

        $container->getUserHandler()->getUserById($usr_id, $container);

        $container->getDbManager()->getSQL("Delete from gw_user where usr_id = $usr_id");

        $container->getDbManager()->closeConnection();

        return new Response([], 204);
    }

    function getUserAuctionsSelf( Container $container, array $user_data ): Response {

        $usr_id = $container->getUserHandler()->getUserByEmail( $user_data["usr_email"], $container )->getUsrId();

        $auctions_won = fetchAuctionsWonByUser($usr_id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($auctions_won, 200);
    }

    function getUserAuctions(int $usr_id, Container $container): Response {

        $user = $container->getUserHandler()->getUserById($usr_id, $container);

        $auctions = fetchAuctionsWonByUser($usr_id, $container);

        $data = [
            "user"=>[
                "id"=>$usr_id,
                "name"=>$user->getUsrName(),
                "biddings"=> $auctions
            ],
        ];

        $container->getDbManager()->closeConnection();

        return new Response($data, 200);
    }

    function getUserBiddingsSelf( Container $container, array $user_data): Response {

        $usr_id = $container->getUserHandler()->getUserByEmail( $user_data["usr_email"], $container )->getUsrId();

        $user_biddings = fetchBiddingsByUser($usr_id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($user_biddings, 200);
    }

    function getUserBiddings( int $usr_id, Container $container ): Response {

        $user = $container->getUserHandler()->getUserById($usr_id, $container);

        $biddings = fetchBiddingsByUser($usr_id, $container);

        $data = [
            "user"=>[
                "id"=>$usr_id,
                "name"=>$user->getUsrName(),
                "biddings"=> $biddings
            ],
        ];

        $container->getDbManager()->closeConnection();

        return new Response($data, 200);
    }