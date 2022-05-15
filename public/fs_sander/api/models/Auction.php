<?php

namespace models;

use DateTime;

class Auction {

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
}