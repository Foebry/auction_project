<?php

    use models\Container;

    function fetchAuctionsWonByUser(int $usr_id, Container $container): array{
        $auctions_won = [];

        $data = $container->getDbManager()->getSQL("
            select auc_id id, auc_start started, auc_expiration ended,
            (select max(bid_price) from gw_bidding where bid_auc_id=id) price,
            art_id, art_name, art_img from gw_auction gau
            join gw_article gar on gau.auc_art_id = gar.art_id
            where auc_usr_id = $usr_id");

        foreach($data as $auction){
            $auction["article"] = ["id"=>$auction["art_id"], "image"=>$auction["art_img"], "name"=>$auction["art_name"]];

            unset($auction["art_id"]);
            unset($auction["art_img"]);
            unset($auction["art_name"]);

            $auctions_won[] = $auction;
        }
        return $auctions_won;

    }