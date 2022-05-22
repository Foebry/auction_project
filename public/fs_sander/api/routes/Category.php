<?php

use models\Category;
use models\Container;
    use models\Response;

    function getCategories(Container $container): Response {

        $data = $container->getDbManager()->getSQL("SELECT cat_id id, cat_name name from gw_category");

        $container->getDbManager()->closeConnection();

        return new Response($data, 200);
    }

    function getCategory(int $cat_id, Container $container): Response {

        $category = $container->getCategoryHandler()->getCategoryById($cat_id, $container);

        $container->getDbManager()->closeConnection();

        return new Response($category->asAssociativeArray(), 200);
    }

    function postCategory(string $payload, Container $container): Response {

        $payload = json_decode($payload, true);

	    checkPayloadPOST(["cat_name"], $payload, $container);

	    $category = new Category(null, $payload["cat_name"]);

        $cat_id = $container->getDbManager()->insertSQL(
            sprintf(
                "INSERT into gw_category(cat_name) values('%s')",
                $payload["cat_name"]
            )
        );
        $category->setCatId($cat_id);

        $container->getDbManager()->closeConnection();

        return new Response($category->asAssociativeArray(), 201);
    }

    function updateCategory( int $cat_id, string $payload, Container $container): Response {

        $payload = json_decode($payload, true);

        $update = checkPayloadPATCH(["cat_name"], $payload, $container);

        $category = $container->getCategoryHandler()->getCategoryById($cat_id, $container);
        $category->setCatName($payload["cat_name"]);

        $container->getDbManager()->insertSQL("Update gw_category set $update where cat_id=$cat_id");

        $container->getDbManager()->closeConnection();

        return new Response($category->asAssociativeArray(), 200);
    }

    function deleteCategory(int $cat_id, Container $container): Response{

        $container->getCategoryHandler()->getCategoryById($cat_id, $container);

        $container->getDbManager()->getSQL("DELETE from gw_category where cat_id=$cat_id");

        $container->getDbManager()->closeConnection();

        return new Response([], 204);
    }