<?php 

    namespace services\handlers;

    use models\Category;
    use services\DbManager;

    class CategoryHandler {
        
        public function getCategoryById(int $cat_id, DbManager $dbm): Category{

            $category_data = $dbm->getSQL("SELECT * from gw_category where cat_id = $cat_id");

            if(!$category_data) $dbm->getResponseHandler()->badRequest($dbm, ["art_cat_id"=>"No category with id $cat_id"]);

            return new Category( $category_data[0] );
        }
    }