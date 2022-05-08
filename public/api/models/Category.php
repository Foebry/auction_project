<?php

namespace models;

class Category {

    private $cat_id;

    private $cat_name;

    /**
     * @param $cat_id
     * @param $cat_name
     */
    public function __construct($cat_id, $cat_name) {
        $this->cat_id = $cat_id;
        $this->cat_name = $cat_name;
    }

    /**
     * @return int
     */
    public function getCatId() {
        return $this->cat_id;
    }

    /**
     * @return string
     */
    public function getCatName() {
        return $this->cat_name;
    }

    /**
     * @param string $cat_name
     */
    public function setCatName($cat_name) {
        $this->cat_name = $cat_name;
    }

}