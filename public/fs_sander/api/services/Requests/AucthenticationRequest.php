<?php

    namespace services\requests;

    use models\BaseModel;
    use models\User;

    class AuthenticationRequest extends Request{

        public function __construct(){
            
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(): void {

            $uri = $this->getUri();

            if( $uri === "/api/login" ) $this->handleLogin();
            elseif( $uri === "/api/register" ) $this->handleRegister();
            elseif( $uri === "/api/logout" ) $this->handleLogout(  );

            else $this->getResponseHandler()->notFound($this->getDbManager());
        }

        /**
         * @Route("/api/login", method="POST")
         * @RouteType public
         */
        private function handleLogin(): void {

            if( $this->method !== "POST" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $payload = $this->getPayload();

            // check dat alle benodigde velden meegestuurd zijn
            if (
                !in_array("usr_email", array_keys($payload)) ||
                !in_array("usr_password", array_keys($payload)) //||
                // !in_array("csrf", array_keys($payload)) ||
                // !in_array("formkey", array_keys($payload))
            ) {
                $this->getResponseHandler()->badRequest($this->getDbManager(), ["message"=>"Invalid form"]);
            }

            // if( $payload["csrf"] !== externalCsrf($payload["form-key"]) ) $this->getResponseHandler()->badRequest(["csrf"=>"Foutief CSRF token"]);
            
            $user = $this->getUserHandler()->getUserByEmail($payload["usr_email"], $this->getDbManager());

            if (!password_verify( $payload["usr_password"], $user->getUsrPassword())){
                $this->getResponseHandler()->unprocessableEntity($this->getDbManager(), ["usr_password"=>"Invalid password"]);
            }

            startSession($user->getUsrId(), $this);

            $this->respond([
                "usr_name"=>$user->getUsrName(),
                "usr_id"=>$user->getUsrId(),
                "csrf"=>$_SESSION["csrf"]
            ]);
        }
        /**
         * @Route("/api/register", method="POST")
         * @RouteType public
         */
        private function handleRegister(): void{

            if( $this->getMethod() !== "POST" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $payload = $this->getPayload();

            $payload = BaseModel::checkPostPayload("gw_user", $payload, $this->getDbManager());

            $user = User::create($payload, $this->getDbManager());

            startSession($user->getUsrId(), $this);

            $this->respond([
                "usr_name"=>$user->getUsrName(),
                "usr_id"=>$user->getUsrId(),
                "csrf"=>$_SESSION["csrf"]
            ]);
        }
        /**
         * @Route("/api/logout", method="DELETE")
         * @RouteType public
         */
        private function handleLogout(): void{

            if( $this->getMethod() !== "DELETE" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

            $token = $_COOKIE["jwt"];

            $options = ["expires"=>time(), "secure"=>true, "httponly"=>true, "SameSite"=>"None"];
            // laat cookie vervallen
            setcookie("jwt", $token, $options);
            unset($_COOKIE["jwt"]);

            destroySession();

            $this->respond([], 204);
        }
        
    }