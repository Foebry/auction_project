<?php

    use \models\Response;
    use \models\Container;
    use \models\Bidding;
    use \models\Auction;

    function getBiddings() {
        print("GET biddings logic");
    }

    function postBidding(Container $container, string $payload): Response {

        $payload = json_decode($payload, true);

        checkPayloadPOST(["bid_usr_id", "bid_auc_id", "bid_price"], $payload, $container);

        //valideer bestaand user
        $container->getUserHandler()->getUserById($payload["bid_usr_id"], $container);
        //valideer bestaand auction
        $auction = $container->getAuctionHandler()->getById($payload["bid_auc_id"], $container);
        //valideer tijd
        Auction::validateBidTiming($auction, $container);

        $bidding = Bidding::create($payload, $container);

        $container->getDbManager()->closeConnection();

        return new Response($bidding->asAssociativeArray());
    }
