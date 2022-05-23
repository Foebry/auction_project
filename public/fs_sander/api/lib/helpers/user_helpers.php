<?php

    use models\Container;
    use models\User;
    use services\requests\Request;

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

    function fetchBiddingsByUser( int $usr_id, Container $container ): array{

        $user_biddings = [];

        $data = $container->getDbManager()->getSQL(
            "select bid_id id, max(bid_price) amount, bid_time time, bid_auc_id, art_name, art_id, art_img
            from gw_bidding
            join gw_auction ga on gw_bidding.bid_auc_id = ga.auc_id
            join gw_article g on ga.auc_art_id = g.art_id
            where bid_usr_id=$usr_id
            group by bid_auc_id"
        );

        foreach ($data as $bidding) {

            $bidding["auction"] = [
                "id"=>$bidding["bid_auc_id"],
                "article" => [
                    "id"=>$bidding["art_id"],
                    "name"=>$bidding["art_name"],
                    "image"=>$bidding["art_img"]
                ],
            ];

            unset($bidding["bid_auc_id"], $bidding["art_name"], $bidding["art_id"], $bidding["art_img"]);

            $user_biddings[] = $bidding;
        }
        return $user_biddings;
    }

    function getUserFromToken(string $token, Request $request): User {

        
        $user_data = json_decode(base64_decode(explode(".", $token)[1]), true);

        $usr_id = $user_data["usr_id"];

        return $request->getUserHandler()->getUserById($usr_id, $request->getDatabaseManager());
    }