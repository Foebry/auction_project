<?php

    namespace models;

    use BaseModel;
    use TypeError;
use ResponseHandler;
use services\DbManager;

    class Article extends BaseModel{

        protected $art_id;

        protected $art_name;

        protected $art_img;

        protected $art_cat_id;

        /**
         * @param $art_id
         * @param $art_name
         * @param $art_img
         * @param $art_cat_id
         */
        public function __construct($payload) {
            try{
                $this->setArtId($payload["art_id"] ?? null);
                $this->setArtName($payload["art_name"]);
                $this->setArtImg($payload["art_img"]);
                $this->setArtCatId($payload["art_cat_id"]);
            }
            catch(TypeError $error){
                $rh = new ResponseHandler();
                $rh->badRequest(["message"=>$error->getMessage()]);
            }
        }

        /**
         * @return int
         */
        public function getArtId() {
            return $this->art_id;
        }

        public function setArtId(int $art_id=null):void {
            $this->art_id = $art_id;
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
        public function setArtName(string $art_name) {
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
        public function setArtImg(string $art_img) {
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
        public function setArtCatId(int $art_cat_id) {
            $this->art_cat_id = $art_cat_id;
        }
    }