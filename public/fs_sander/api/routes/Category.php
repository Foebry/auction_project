<?php

    use models\Container;
    use models\Response;

    function getCategories(Container $container): Response {

        $data = $container->getDbManager()->getSQL("SELECT cat_id id, cat_name name from gw_category");

        $container->getDbManager()->closeConnection();

        return new Response($data, 200);
    }

    function getCategory($id) {
        print("GET category logic or id $id");
    }

    function postCategory() {
        print("POST category logic");
    }

    function updateCategory() {
        print("PUT category logic");
    }