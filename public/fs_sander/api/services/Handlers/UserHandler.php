<?php

    namespace services\handlers;

    use models\User;
    use models\Container;
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
                return new User(
                    $userData[0]["usr_id"],
                    $userData[0]["usr_name"],
                    $userData[0]["usr_lastname"],
                    $userData[0]["usr_email"],
                    $userData[0]["usr_password"],
                    $userData[0]["usr_is_admin"],
                );
            
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

            $userData = $dbm->getSQL("SELECT * from gw_user where usr_id = $usr_id");

            if (!$userData) {
                $dbm->closeConnection();
                $dbm->getResponseHandler()->badRequest(["message"=>"No user with usr_id $usr_id"]);
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