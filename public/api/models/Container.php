<?php

    class Container{
        private $articleHandler;
        private $auctionHandler;
        private $biddingHandler;
        private $categoryHandler;
        private $responseHandler;
        private $userHandler;
        private $dbManager;

        function __construct() {
            print("created new container");
            $this->articleHandler = null;
            $this->auctionHandler = null;
            $this->biddingHandler = null;
            $this->categoryHandler = null;
            $this->responseHandler = null;
            $this->userHandler = null;
            $this->dbManager = null;
        }

        function getArticleHandler(): ArticleHandler {
            if($this->articleHandler === null){
                $this->articleHandler = new ArticleHandler();
            }
            return $this->articleHandler;
        }

        function getAuctionHandler(): AuctionHandler {
            if ($this->auctionHandler === null ) {
                $this->auctionHandler = new AuctionHandler();
            }
            return $this->auctionHandler;
        }

        function getBiddingHandler(): BiddingHandler {
            if ( $this->biddingHandler === null ) {
                $this->biddingHandler = new BiddingHandler();
            }
            return $this->biddingHandler;
        }

        function categoryHandler(): CategoryHandler {
            if ( $this->categoryHandler === null ) {
                $this->categoryHandler = new CategoryHandler();
            }
            return $this->categoryHandler;
        }

        function getResponseHandler(): ResponseHandler {
            if ( $this->responseHandler === null ) {
                $this->responseHandler = new ResponseHandler();
            }
            return $this->responseHandler;
        }

        function getUserHandler(): UserHandler {
            if ( $this->userHandler === null ) {
                $this->userHandler = new UserHandler();
            }
            return $this->userHandler;
        }

        function getDbManager(): DbManager {
            if ( $this->dbManager === null ) {
                $this->dbManager = new DbManager();
            }
            return $this->dbManager;
        }
    
    }