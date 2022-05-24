<?php

    namespace services\requests;

    use services\handlers\ArticleHandler;
    use services\handlers\ResponseHandler;
    use services\DbManager;
    use models\Response;
    use services\handlers\AuctionHandler;
    use services\handlers\CategoryHandler;
    use services\handlers\UserHandler;

    class Request{

        protected $method;
        protected $payload;
        protected $dbm;
        protected $uri;
        protected $route;
        protected $responseHandler;
        protected $auctionHandler;
        protected $articleHandler;
        protected $userHandler;
        protected $categoryHandler;

        public function __construct(){
            $this->method = $_SERVER["REQUEST_METHOD"];
            $this->payload = json_decode(file_get_contents("php://input"));
            $this->uri = explode("fs_sander", $_SERVER["REQUEST_URI"])[1];
            $this->route = explode("/", $this->getUri)[2];
        }

        protected function getMethod(): string{
            return $this->method;
        }

        protected function getPayload(): array{
            return $this->payload;
        }

        protected function getUri(): string{
            return $this->uri;
        }

        protected function getRoute(): string{
            return $this->route;
        }

        public function getDbManager():DbManager{
            if( $this->dbm === null ) {
                $this->dbm = new DbManager($this->getResponseHandler());
            }
            return $this->dbm;
        }

        public function getResponseHandler(): ResponseHandler{
            if( $this->responseHandler === null ){
                $this->responseHandler = new ResponseHandler();
            }
            return $this->responseHandler;
        }

        public function getAuctionHandler(): AuctionHandler{
            if( $this->auctionHandler === null ){
                $this->auctionHandler = new AuctionHandler();
            }
            return $this->auctionHandler;
        }

        public function getUserHandler(): UserHandler{
            if( $this->userHandler === null ){
                $this->userHandler = new UserHandler();
            }
            return $this->userHandler;
        }

        public function getArticleHandler(): ArticleHandler{
            if( $this->articleHandler === null ){
                $this->articleHandler = new ArticleHandler();
            }
            return $this->articleHandler;
        }

        public function getCategoryHandler(): CategoryHandler{
            if( $this->categoryHandler === null ){
                $this->categoryHandler = new CategoryHandler();
            }
            return $this->categoryHandler;
        }

        protected function respond($data, $code=200): Response{
            $this->getDbManager()->closeConnection();

            return new Response($data, $code);
            
        }
    }