<?php

namespace models;

class MyArticle {

    private $my_art_id;

    private $my_id;

    private $my_usr_id;

    /**
     * @param $my_art_id
     * @param $my_id
     * @param $my_usr_id
     */
    public function __construct($my_art_id, $my_id, $my_usr_id) {
        $this->my_art_id = $my_art_id;
        $this->my_id = $my_id;
        $this->my_usr_id = $my_usr_id;
    }

    /**
     * @return int
     */
    public function getMyArtId() {
        return $this->my_art_id;
    }

    /**
     * @return int
     */
    public function getMyId() {
        return $this->my_id;
    }

    /**
     * @param int $my_id
     */
    public function setMyId($my_id) {
        $this->my_id = $my_id;
    }

    /**
     * @return int
     */
    public function getMyUsrId() {
        return $this->my_usr_id;
    }

    /**
     * @param int $my_usr_id
     */
    public function setMyUsrId($my_usr_id) {
        $this->my_usr_id = $my_usr_id;
    }

}