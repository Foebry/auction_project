<?php

    namespace services;

    use services\handlers\ResponseHandler;
    use services\requests\AuctionRequest;
    use services\requests\ArticleRequest;
    use services\requests\BiddingRequest;
    use services\requests\AuthenticationRequest;
    use services\requests\CategoryRequest;
    use services\requests\UserRequest;

    class Router {

        private $uri;
        private $route;

        public function __construct()
        {   
            $this->setUri();
            $this->setRoute();
            
            $this->resolveRoute();
        }

        private function setUri(): void {

            $this->uri = explode("fs_sander", $_SERVER["REQUEST_URI"])[1];

        }

        private function setRoute(): void {

            $uri = $this->getUri();
            if( strpos( $uri, "?" ) !== false ){

                $uri = explode("?", $uri)[0];

            }

            $split = explode("api/", $uri);

            $route = count( $split ) === 1 ? "" : $split[1];

            $route = explode("/", $route)[0];

            $this->route = $route;

        }

        private function resolveRoute(): void{

            $route = $this->getRoute();

            switch($route) {

                case "":
                    $rh = new ResponseHandler();
                    $rh->render("swagger.html");

                case in_array($route, ["auctions", "auction"]):
                    new AuctionRequest();
                    break;
                
                case in_array($route, ["articles", "article", "upload"]):
                    new ArticleRequest();
                    break;
                
                case in_array($route, ["biddings", "bidding"]):
                    new BiddingRequest();
                    break;
                
                case in_array($route, ["user", "users"]):
                    new UserRequest();
                    break;
                    
                case in_array($route, ["categories", "category"]):
                    new CategoryRequest();
                    break;
                
                case in_array($route, ["login", "register", "logout"]):
                    new AuthenticationRequest();
                    break;
                
                default:
                    $rh = new ResponseHandler();
                    $rh->notFound(new DbManager($rh));
                    break;
            }
            
        }

        private function getUri(){
            return $this->uri;
        }

        private function getRoute(){
            return $this->route;
        }
    }