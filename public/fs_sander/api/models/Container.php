<?php

namespace models;

use ArticleHandler;
use AuctionHandler;
use BiddingHandler;
use CategoryHandler;
use ResponseHandler;
use UserHandler;
use \services\DbManager;

class Container {

    private $articleHandler;

    private $auctionHandler;

    private $biddingHandler;

    private $categoryHandler;

    private $responseHandler;

    private $userHandler;

    private $dbManager;

    function __construct() {
        $this->articleHandler = NULL;
        $this->auctionHandler = NULL;
        $this->biddingHandler = NULL;
        $this->categoryHandler = NULL;
        $this->responseHandler = NULL;
        $this->userHandler = NULL;
        $this->dbManager = NULL;
    }

    function getArticleHandler(): ArticleHandler {
        if ($this->articleHandler === NULL) {
            $this->articleHandler = new ArticleHandler();
        }
        return $this->articleHandler;
    }

    function getAuctionHandler(): AuctionHandler {
        if ($this->auctionHandler === NULL) {
            $this->auctionHandler = new AuctionHandler();
        }
        return $this->auctionHandler;
    }

    function getBiddingHandler(): BiddingHandler {
        if ($this->biddingHandler === NULL) {
            $this->biddingHandler = new BiddingHandler();
        }
        return $this->biddingHandler;
    }

    function getCategoryHandler(): CategoryHandler {
        if ($this->categoryHandler === NULL) {
            $this->categoryHandler = new CategoryHandler();
        }
        return $this->categoryHandler;
    }

    function getResponseHandler(): ResponseHandler {
        if ($this->responseHandler === NULL) {
            $this->responseHandler = new ResponseHandler();
        }
        return $this->responseHandler;
    }

    function getUserHandler(): UserHandler {
        if ($this->userHandler === NULL) {
            $this->userHandler = new UserHandler();
        }
        return $this->userHandler;
    }

    function getDbManager(): DbManager {
        if ($this->dbManager === NULL) {
            $this->dbManager = new DbManager($this->getResponseHandler());
        }
        return $this->dbManager;
    }

}