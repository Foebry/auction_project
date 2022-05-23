<?php

namespace models;

use BaseModel;
use ResponseHandler;
use TypeError;

class Category extends BaseModel {

    protected $cat_id;

    protected $cat_name;

    /**
     * @param $cat_id
     * @param $cat_name
     */
    public function __construct($data) {

        try{
            $this->setCatId($data["cat_id"] ?? null);
            $this->setCatName($data["cat_name"]);
        }
        catch(TypeError $error){
            $rh = new ResponseHandler();
            $rh->badRequest();
        }
    }

    /**
     * @return int
     */
    public function getCatId() {
        return $this->cat_id;
    }

    public function setCatId(int $cat_id): void{
        $this->cat_id = $cat_id;
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
        if(is_string($cat_name)){
            $this->cat_name = $cat_name;
        }
    }

}