<?php

    namespace services\handlers;

    use models\User;
    use services\DbManager;

    class UserHandler{
                
        /**
         * getUsrByEmail
         *
         * @param  string $email
         * @param  Container $container
         * @return User
         */
        public function getUserByEmail( string $email, DbManager $dbm ): User{
            
            $userData = $dbm->getSQL("SELECT * from gw_user where usr_email = '$email'");
            
            if ($userData)
                return new User($userData[0]);
            
            $dbm->getResponseHandler()->unprocessableEntity($dbm, ["message"=>"Invalid data", "usr_email"=>"Unknown email adress"]);
        }

        /**
         * getUserById
         *
         * @param  int $user_id
         * @param  DbManager $container
         * @return User
         */
        public function getUserById( int $usr_id, DbManager $dbm ): User {

            $user_data = $dbm->getSQL("SELECT * from gw_user where usr_id = $usr_id");

            if (!$user_data) {
                $dbm->closeConnection();
                $dbm->getResponseHandler()->badRequest($dbm, ["message"=>"No user with usr_id $usr_id"]);
            }

            return new User($user_data[0]);
        }
    }