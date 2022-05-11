<?php

    use \models\Container;
    use \models\Auction;

    class AuctionHandler{
        
        public function getById($auction_id, Container $container){

            $data = $container->getDbManager()->getSQL("SELECT * from gw_auction where auc_id = $auction_id")[0];

            if(!$data) $container->getResponseHandler()->badRequest();

            return new Auction(
                $data["auc_id"],
                $data["auc_art_id"],
                $data["auc_expiration"]
            );

        }
    }