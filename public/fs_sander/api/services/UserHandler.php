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
    }