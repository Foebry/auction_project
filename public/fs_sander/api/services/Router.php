<?php

    namespace services;

    use ResponseHandler;
    use services\requests\AuctionRequest;
    use services\requests\ArticleRequest;
    use services\requests\BiddingRequest;
    use services\requests\AuthenticationRequest;
    use services\requests\CategoryRequest;
    use services\requests\UserRequest;

    class Router {

        public function __construct()
        {
            $this->uri = explode("fs_sander", $_SERVER["REQUEST_URI"])[1];
            $this->route = explode("/", $this->getUri())[2];
            $this->resolveRoute();
        }

        private function resolveRoute(): void{

            switch ($this->getRoute()){
                case ("auctions" || "auction"): 
                    new AuctionRequest();
                    break;
                case ("articles" || "article"): 
                    new ArticleRequest();
                    break;
                case ("biddings" || "bidding"): 
                    new BiddingRequest();
                    break;
                case ("categories" || "category"): 
                    new CategoryRequest();
                    break;
                case ("user"): 
                    new UserRequest();
                    break;
                case ("login" || "register" || "logout"): 
                    new AuthenticationRequest();
                    break;
                default:
                    $responseHandler = new ResponseHandler();
                    $responseHandler->invalidRoute();
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