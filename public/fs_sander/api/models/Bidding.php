<?php

namespace models;

class Bidding {

    private $bid_id;

    private $bid_user_id;

    private $bid_auc_id;

    private $bid_price;

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
        if (is_numeric($bid_user_id)){
            $this->bid_user_id = $bid_user_id;
        }
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
        if (is_numeric($bid_auc_id)){
            $this->bid_auc_id = $bid_auc_id;
        }
    }

    /**
     * @return double
     */
    public function getBidPrice() {
        return $this->bid_price;
    }

    /**
     * @param float $bid_price
     */
    public function setBidPrice($bid_price) {
        if(is_float($bid_price)){
            $this->bid_price = $bid_price;
        }
    }
}