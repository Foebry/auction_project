<?php

namespace models;

use BaseModel;
use \DateTime;

class Bidding extends BaseModel {

    protected $bid_id;

    protected $bid_user_id;

    protected $bid_auc_id;

    protected $bid_price;

    /**
     * @param $bid_id
     * @param $bid_user_id
     * @param $bid_auc_id
     * @param $bid_price
     */
    public function __construct($bid_id, $bid_user_id, $bid_auc_id, $bid_price) {
        $this->bid_id = $bid_id;
        $this->bid_user_id = $bid_user_id;
        $this->bid_auc_id = $bid_auc_id;
        $this->bid_price = $bid_price;
    }

    /**
     * @return int
     */
    public function getBidId() {
        return $this->bid_id;
    }

    public function setBidId($bid_id) {
        $this->bid_id = $bid_id;
    }

    /**
     * @return int
     */
    public function getBidUserId() {
        return $this->bid_user_id;
    }

    /**
     * @param int $bid_user_id
     */
    public function setBidUserId($bid_user_id) {
        $this->bid_user_id = $bid_user_id;
    }

    /**
     * @return int
     */
    public function getBidAucId() {
        return $this->bid_auc_id;
    }

    /**
     * @param int $bid_auc_id
     */
    public function setBidAucId($bid_auc_id) {
        $this->bid_auc_id = $bid_auc_id;
    }

    /**
     * @return double
     */
    public function getBidPrice() {
        return $this->bid_price;
    }

    /**
     * @param double $bid_price
     */
    public function setBidPrice($bid_price) {
        $this->bid_price = $bid_price;
    }

    public static function create(array $payload, Container $container) {

        $bidding = new Bidding(
            null,
            $payload["bid_usr_id"],
            $payload["bid_auc_id"],
            $payload["bid_price"]
        );

        Bidding::validateBidPrice($payload, $container);

        $now = new DateTime();
        $currentTimestamp = $now->getTimestamp()*1000;

        $bidding_id = $container->getDbManager()->insertSQL(
            sprintf(
                "INSERT into gw_bidding (bid_usr_id, bid_auc_id, bid_price, bid_time) values(%d, %d, %d, %d)",
                $bidding->getBidUserId(),
                $bidding->getBidAucId(),
                $bidding->getBidPrice(),
                $currentTimestamp
            )
        );

        $bidding->setBidId($bidding_id);

        return $bidding;
    }

    /**
     * validateBidPrice
     *
     * @param  array $payload
     * @param  Container $container
     * @return void
     */
    private static function validateBidPrice(array $payload, Container $container): void {

        $auction = $container->getAuctionHandler()->getById($payload["bid_auc_id"], $container);
        $dbm = $container->getDbManager();

        // valideer of bid hoger is dan hoogste bid op auction
        if ($payload["bid_price"] <= $auction->getHighestBidValue($dbm)){
            $dbm->closeConnection();
            $container->getResponseHandler()->badRequest("Bid too low");
        }
    }

}
