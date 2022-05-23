<?php

    use \services\DbManager;
    use \models\Auction;

    class AuctionHandler{
        
        public function getAuctionById($auction_id, DbManager $dbm){

            $data = $dbm->getSQL("SELECT * from gw_auction where auc_id = $auction_id")[0];

            if(!$data) $dbm->getResponseHandler()->badRequest();

            return new Auction(
                $data["auc_id"],
                $data["auc_art_id"],
                $data["auc_expiration"]
            );

        }
    }