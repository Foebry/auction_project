<?php

use models\User;
use models\Container;

    class UserHandler{
                
        /**
         * getUsrByEmail
         *
         * @param  string $email
         * @param  Container $container
         * @return User
         */
        public function getUserByEmail( string $email, Container $container ): User{
            $dbm = $container->getDbManager();

            $userData = $dbm->getSQL("SELECT * from gw_user where usr_email = '$email'");

            if ($userData)
                return new User(
                    $userData[0]["usr_id"],
                    $userData[0]["usr_name"],
                    $userData[0]["usr_email"],
                    $userData[0]["usr_password"]
                );
            
            $dbm->closeConnection();
            $container->getResponseHandler()->unprocessableEntity("Unknown email adress");
        }

        /**
         * getUserById
         *
         * @param  mixed $user_id
         * @param  mixed $container
         * @return User
         */
        public function getUserById( int $user_id, Container $container ): User {

            $userData = $container->getDbManager()->getSQL("SELECT * from gw_user where usr_id = $user_id")[0];

            if (!$userData) $container->getResponseHandler()->badRequest();

            return new User(
                $userData["usr_id"],
                $userData["usr_name"],
                $userData["usr_email"],
                $userData["usr_password"]
            );
        }
    }