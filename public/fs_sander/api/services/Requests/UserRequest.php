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

            if( $uri ==="/api/users" ) $this->getAllUsers( AdminRoute( $this ) );

            if( $uri === "/api/user" ) $this->resolveUser( ProtectedRoute( $this ));

            elseif( $uri === "/api/user/auctions") $this->getOwnAuctions( ProtectedRoute( $this ));

            elseif( $uri === "/api/user/biddings") $this->getOwnBiddings( ProtectedRoute( $this ));

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
                $this->getSpecificUsersBiddings($usr_id, AdminRoute( $this ) );
            }
            else $this->getResponseHandler()->notFound($this->getDbManager());            

        }
        /**
         * @Route("/api/users", method="GET")
         * @RouteType Admin
         */
        private function getAllUsers(){

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();
            
            $query = "SELECT usr_id id, concat(usr_name,' ', usr_lastname) name, usr_email email, usr_is_admin isAdmin, usr_created_at joinDate from gw_user";
            $data = $this->getDbManager()->getSQL($query);

            $this->respond($data);
        }
        /**
         * @Route("/api/user", methods=["GET", "PATCH"])
         * @RouteType protected
         */
        private function resolveUser(array $exploded_token): void{

            $method = $this->getMethod();

            if( $method === "GET") $this->getUserSelf( $exploded_token );
            elseif( $method === "PATCH" ) $this->updateUserSelf( $exploded_token );
           
            else $this->getResponseHandler()->notAllowed($this->getDbManager());
            
        }
        /**
         * @Route("/api/user/auctions", method="GET")
         * @RouteType protected
         */
        private function getOwnAuctions( array $exploded_token): void{

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $user = getUserFromToken(implode(".", $exploded_token), $this);
            $usr_id = $user->getUsrId();

            $auctions_won = User::fetchAuctionsWon($usr_id, $this->getDbManager());

            $this->respond($auctions_won);

        }
        /**
         * @Route("/api/user/biddings", method="GET")
         * @RouteType protected
         */
        private function getOwnBiddings( array $exploded_token ): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $user = getUserFromToken( implode(".", $exploded_token), $this );
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
            
            else $this->getResponseHandler()->notAllowed($this->getDbManager());
        }
        /**
         * @Route("/api/user/:id/auctions", method="GET")
         * @RouteType admin
         */
        private function getSpecificUserAuctions(int $usr_id):void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

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

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

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

        private function getUserSelf(array $exploded_token): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $user = getUserFromToken(implode(".", $exploded_token), $this);

            $this->respond($user->asAssociativeArray());
        }

        private function updateUserSelf(array $exploded_token): void {
            
            $user = getUserFromToken(implode(".", $exploded_token), $this);
            $usr_id = $user->getUsrId();

            $payload = $this->getPayload();

            if (in_array("usr_pass_verify", array_keys($payload)) && !password_verify($payload["usr_pass_verify"], $user->getUsrPassword())){
                $this->getResponseHandler()->badRequest(null, ["message"=>"Invalid password"]);
            }

            // gebruiker mag zichzelf geen admin maken. 
            // indien toch aanwezig in payload, filter uit.
            if( !$user->IsAdmin() && in_array("usr_is_admin", array_keys($payload)) ) unset($payload["usr_is_admin"]);

            $update = BaseModel::checkPatchPayload("gw_user", $payload, $this->getDbManager());

            if( in_array("usr_email", array_keys($payload)) ) $user->setUsrEmail($payload["usr_email"]);

            if( $update !== "" ){
                $this->getDbManager()->getSQL("UPDATE gw_user SET $update where usr_id=$usr_id");

                $user = $this->getUserHandler()->getUserById($usr_id, $this->getDbManager());
            }

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