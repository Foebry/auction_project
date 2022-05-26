<?php

    namespace models;

    use models\BaseModel;
    use TypeError;
    use ResponseHandler;
    use services\requests\Request;

    class Article extends BaseModel{

        protected $art_id;

        protected $art_name;

        protected $art_img;

        public $art_cat_id;

        /**
         * @param $art_id
         * @param $art_name
         * @param $art_img
         * @param $art_cat_id
         */
        public function __construct(array $data) {
            try{
                $this->setArtId($data["art_id"] ?? null);
                $this->setArtName($data["art_name"]);
                $this->setArtImg($data["art_img"] ?? "default.jpg");
                $this->setArtCatId($data["art_cat_id"]);
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

        public static function create(array $payload, Request $request): Article{

            $request->getCategoryHandler()->getCategoryById($payload["art_cat_id"], $request->getDbManager());
            
            $article = new Article($payload);

            $art_id = $request->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_article(art_name, art_img, art_cat_id) values('%s', '%s', %d)",
                    $article->getArtName(),
                    $article->getArtImg(),
                    $article->getArtCatId()
                  )
                );
            
            $article->setArtId($art_id);

            return $article;
        }

        
    }