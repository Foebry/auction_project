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
                    $userData[0]["usr_lastname"],
                    $userData[0]["usr_email"],
                    $userData[0]["usr_password"],
                    $userData[0]["usr_is_admin"],
                );
            
            $dbm->closeConnection();
            $container->getResponseHandler()->unprocessableEntity(["message"=>"Invalid data", "usr_email"=>"Unknown email adress"]);
        }

        /**
         * getUserById
         *
         * @param  mixed $user_id
         * @param  mixed $container
         * @return User
         */
        public function getUserById( int $usr_id, Container $container ): User {

            $userData = $container->getDbManager()->getSQL("SELECT * from gw_user where usr_id = $usr_id");

            if (!$userData) {
                $container->getDbManager()->closeConnection();
                $container->getResponseHandler()->badRequest(["message"=>"No user with usr_id $usr_id"]);
            }

            return new User(
                $userData[0]["usr_id"],
                $userData[0]["usr_name"],
                $userData[0]["usr_lastname"],
                $userData[0]["usr_email"],
                $userData[0]["usr_password"],
                $userData[0]["usr_is_admin"],
            );
        }
    }