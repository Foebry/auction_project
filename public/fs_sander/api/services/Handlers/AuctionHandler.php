<?php

    namespace services\handlers;

    use \services\DbManager;
    use \models\Auction;

    class AuctionHandler{
        
        public function getAuctionById($auction_id, DbManager $dbm){

            $data = $dbm->getSQL("SELECT * from gw_auction where auc_id = $auction_id");

            if(!$data) $dbm->getResponseHandler()->badRequest($dbm, ["message"=>"No auction with id $auction_id"]);

            return new Auction($data[0]);

        }
    }