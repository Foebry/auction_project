<?php

    namespace models;

    use BaseModel;
    use models\Category as _Category;
    use ResponseHandler;
    use services\requests\Request;
    use TypeError;

    class Category extends BaseModel {

        protected $cat_id;

        protected $cat_name;

        /**
         * @param int $cat_id
         * @param string $cat_name
         */
        public function __construct($data) {

            try{
                $this->setCatId($data["cat_id"] ?? null);
                $this->setCatName($data["cat_name"]);
            }
            catch(TypeError $error){
                $rh = new ResponseHandler();
                $rh->badRequest($error->getMessage());
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

        public static function create(array $payload, Request $request): _Category {

            $category = new Category($payload);

            $cat_id = $request->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_category(cat_name) values('%s')",
                    $payload["cat_name"]
                )
            );

            $category->setCatId($cat_id);

            return $category;
        }

    }