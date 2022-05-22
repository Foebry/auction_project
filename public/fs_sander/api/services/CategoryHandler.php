<?php 

    use models\Container;
    use models\Category;

    class CategoryHandler {
        
        public function getCategoryById(int $cat_id, Container $container): Category{

            $data = $container->getDbManager()->getSQL("SELECT * from gw_category where cat_id = $cat_id")[0];

            if(!$data) $container->getResponseHandler()->badRequest();

            return new Category( $data["cat_id"], $data["cat_name"] );
        }
    }