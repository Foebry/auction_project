<?php

    namespace services\requests;

    use models\BaseModel;
    use models\User;

    class UserRequest extends Request{

        public function __construct(){
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(){

            $uri = $this->getUri();

            if( $uri === "/api/user" ) $this->resolveUser( ProtectedRoute( $this ));

            elseif( $uri === "/api/user/auctions") $this->getOwnAuctions( ProtectedRoute( $this ));

            elseif( $uri === "/api/usr/biddings") $this->getOwnBiddings( ProtectedRoute( $this ));

            elseif( preg_match("|api/user/[0-9]+$|", $uri) ) {
                $usr_id = explode("/", $uri)[3];
                $this->resolveSpecificUser($usr_id, AdminRoute( $this ));
            }
            elseif( preg_match("|api/user/[0-9]*/auctions$|", $uri) ){
                $usr_id = explode("/", $uri)[3];
                $this->getSpecificUserAuctions($usr_id, AdminRoute( $this ) );
            }
            elseif( preg_match("|api/user/[0-9]+/biddings$|", $uri) ) {
                $usr_id = explode("/", $uri)[3];
                $this->getSpecificUsersBiddings($usr_id);
            }
            else $this->getResponseHandler()->invalidRoute();            

        }
        /**
         * @Route("/api/user", methods=["GET", "PATCH"])
         * @RouteType protected
         */
        private function resolveUser(array $user_data): void{

            $method = $this->getMethod();

            if( $method === "GET") $this->getUserSelf( $user_data );
            elseif( $method === "PATCH" ) $this->updateUserSelf( $user_data );
           
            else $this->getResponseHandler()->notAllowed();
            
        }
        /**
         * @Route("/api/user/auctions", method="GET")
         * @RouteType protected
         */
        private function getOwnAuctions( array $user_data): void{

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $email = $user_data["usr_email"];
            $user = $this->getUserHandler()->getUserByEmail($email, $this->getDbManager());
            $usr_id = $user->getUsrId();

            $auctions_won = User::fetchAuctionsWon($usr_id, $this->getDbManager());

            $this->respond($auctions_won);

        }
        /**
         * @Route("/api/user/biddings", method="GET")
         * @RouteType protected
         */
        private function getOwnBiddings( array $user_data ): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $email = $user_data["usr_email"];
            $user = $this->getUserHandler()->getUserByEmail($email, $this->getDbManager());
            $usr_id = $user->getUsrId();

            $user_biddings = User::fetchBiddings($usr_id, $this->getDbManager());

            $this->respond($user_biddings);
        }
        /**
         * @Route("/api/user/:id", methods=["GET", "PATCH", "DELETE"])
         * @RouteType admin
         */
        private function resolveSpecificUser(int $usr_id): void {

            $method = $this->getMethod();

            if( $method === "GET" ) $this->getSpecificUser( $usr_id );
            elseif( $method === "PATCH" ) $this->updateSpecificUser( $usr_id );
            elseif( $method === "DELETE" ) $this->deleteSpecificUser( $usr_id );
            
            else $this->getResponseHandler()->notAllowed();
        }
        /**
         * @Route("/api/user/:id/auctions", method="GET")
         * @RouteType admin
         */
        private function getSpecificUserAuctions(int $usr_id):void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $auctions = User::fetchAuctionsWon( $usr_id, $this->getDbManager() );

            $data = [
                "user"=>[
                    "id"=>$usr_id,
                    "name"=>$user->getUsrFullName(),
                    "auctions"=>$auctions,
                ],
            ];

            $this->respond($data);
        }
        /**
         * @Route("/api/user/:id/biddings", method="GET")
         * @RouteType admin
         */
        private function getSpecificUsersBiddings(int $usr_id): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $biddings = User::fetchBiddings( $usr_id, $this->getDbManager());
        
            $data = [
                "user"=>[
                    "id"=>$usr_id,
                    "name"=>$user->getUsrName(),
                    "biddings"=> $biddings
                ],
            ];

            $this->respond($data);
        }

        private function getUserSelf(array $user_data): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $email = $user_data["usr_email"];
            $user = $this->getUserHandler()->getUserByEmail($email, $this->getDbManager());

            $this->respond($user->asAssociativeArray());
        }

        private function updateUserSelf(array $user_data): void {
            
            $email = $user_data["usr_email"];
            $user = $this->getUserHandler()->getUserByEmail($email, $this->getDbManager());
            $usr_id = $user->getUsrId();

            $payload = $this->getPayload();

            $update = BaseModel::checkPatchPayload("gw_user", $payload, $this->getDbManager());

            $this->getDbManager()->getSQL("UPDATE gw_user SET $update where usr_id=$usr_id");

            $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $this->respond($user->asAssociativeArray());
        }

        private function getSpecificUser( int $usr_id ): void {

            $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $this->respond($user->asAssociativeArray());
        }

        private function updateSpecificUser( int $usr_id ): void {

            //check of User met usr_id bestaat
            $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());
            
            $payload = $this->getPayload();
            $update = BaseModel::checkPatchPayload("gw_user", $payload, $this->getDbManager());

            $this->getDbManager()->getSQL("UPDATE gw_user set $update where usr_id=$usr_id");

            //ophalen nieuwe userdata
            $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $this->respond($user->asAssociativeArray());

        }

        private function deleteSpecificUser( int $usr_id ): void {

            //check of User met usr_id bestaat
            $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());

            $this->getDbManager()->getSQL("DELETE from gw_user where usr_id=$usr_id");

            $this->respond([], 204);
        }
    }