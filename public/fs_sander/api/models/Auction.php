<?php

namespace models;

use BaseModel;
use DateTime;
use \services\DbManager;

class Auction extends BaseModel {

    private $auc_id;

    private $auc_art_id;

    private $auc_expiration;

    /**
     * @param $auc_id
     * @param $auc_art_id
     * @param $auc_expiration
     */
    public function __construct($auc_id, $auc_art_id, $auc_expiration) {
        $this->auc_id = $auc_id;
        $this->auc_art_id = $auc_art_id;
        $this->auc_expiration = $auc_expiration;
    }

    public function setAucId(int $auc_id){
        $this->auc_id = $auc_id;
    }

    /**
     * @return int
     */
    public function getAucId() {
        return $this->auc_id;
    }

    /**
     * @return int
     */
    public function getAucArtId() {
        return $this->auc_art_id;
    }

    /**
     * @param int $auc_art_id
     */
    public function setAucArtId($auc_art_id) {
        if (is_numeric($auc_art_id)) {
            $this->auc_art_id = $auc_art_id;
        }
    }

    /**
     * @return DateTime
     */
    public function getAucExpiration() {
        return $this->auc_expiration;
    }

    /**
     * @param DateTime $auc_expiration
     */
    public function setAucExpiration($auc_expiration) {
        if (is_numeric($auc_expiration)) {
            $this->auc_expiration = $auc_expiration;
        }
    }


    /**
     * getHighestBidValue
     *
     * @param  DbManager $dbm
     * @return int
     */
    public function getHighestBidValue(DbManager $dbm): int {

        $auction_id = $this->getAucId();
        $highest_bid = $dbm->getSQL("SELECT bid_price from gw_bidding where bid_auc_id = $auction_id order by bid_price desc limit 1")[0]["bid_price"];

        return $highest_bid;
    }

    /**
     * validateBidTiming
     *
     * @param  Auction $auction
     * @param  Container $container
     * @return void
     */
    public static function validateBidTiming(Auction $auction, Container $container): void{

        $now = new DateTime("now");
        $currentTimestamp = $now->getTimestamp()*1000;

        $auction_expired = $currentTimestamp > $auction->getAucExpiration();
        // $auction_not_started = $currentTimestamp < $auction->getAucStart();

        if ($auction_expired /*or $auction_not_started */)
            $container->getResponseHandler()->unprocessableEntity("You cannot bid on this auction at this time");

    }
}