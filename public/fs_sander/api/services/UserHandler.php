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

            $userData = $dbm->getSQL("SELECT * from gw_user where usr_email = '$email'")[0];

            if (!$userData) $container->getResponseHandler()->unprocessableEntity("Invalid email adress");

            return new User($userData["usr_id"], $userData["usr_name"], $userData["usr_email"], $userData["usr_password"]);
        }
    }