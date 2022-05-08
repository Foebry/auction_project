<?php

namespace models;

class Article {

    private $art_id;

    private $art_name;

    private $art_img;

    private $art_cat_id;

    /**
     * @param $art_id
     * @param $art_name
     * @param $art_img
     * @param $art_cat_id
     */
    public function __construct($art_id, $art_name, $art_img, $art_cat_id) {
        $this->art_id = $art_id;
        $this->art_name = $art_name;
        $this->art_img = $art_img;
        $this->art_cat_id = $art_cat_id;
    }

    /**
     * @return int
     */
    public function getArtId() {
        return $this->art_id;
    }

    /**
     * @return string
     */
    public function getArtName() {
        return $this->art_name;
    }

    /**
     * @param string $art_name
     */
    public function setArtName($art_name) {
        $this->art_name = $art_name;
    }

    /**
     * @return string
     */
    public function getArtImg() {
        return $this->art_img;
    }

    /**
     * @param string $art_img
     */
    public function setArtImg($art_img) {
        $this->art_img = $art_img;
    }

    /**
     * @return int
     */
    public function getArtCatId() {
        return $this->art_cat_id;
    }

    /**
     * @param int $art_cat_id
     */
    public function setArtCatId($art_cat_id) {
        $this->art_cat_id = $art_cat_id;
    }

}