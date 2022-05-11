<?php

$method = $_SERVER["REQUEST_METHOD"];
$uri = explode("fs_sander", $_SERVER["REQUEST_URI"])[1];
$route = explode("/", $uri)[2];
$payload = file_get_contents("php://input");

$container = $_SESSION["container"];
$responseHandler = $container->getResponseHandler();
$dbm = $container->getDbManager();

switch ($route) {
    /*
    * /api/auctions
    * GET, POST
    */
    case "auctions":
        if ( $uri === "/api/$route" ) {

            if ( $method === "GET" ) getAuctions( $dbm );
            elseif ( $method === "POST" ) postAuction( $dbm, $payload );
            else $responseHandler->notAllowed();

        }
        else $responseHandler->invalidRoute();

        break;
    
    case "auction":
        /*
        * /api/auction/{id}
        * GET
        */
        if ( preg_match("|api/$route/[0-9]+$|", $uri) ) {

            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getAuctionDetail( $container, $id );
            else $responseHandler->notAllowed();
        }
        /*
        * /api/auction/{id}/biddings
        * GET
        */
        elseif ( preg_match("|api/$route/[0-9]+/biddings$|", $uri) ){
            
            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getAuctionBiddings($container, $id);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

    case "articles":
        /*
        * /api/articles
        * GET, POST
        */
        if ( $uri === "/api/$route" ) {
            
            if ( $method === "GET" ) getArticles();
            elseif ( $method === "POST" ) postArticle($payload);
            else $responseHandler->notAllowed();
        }

        else $responseHandler->invalidRoute();

        break;
    
    case "article":
        /*
        * /api/article/{id}
        * GET, PUT, PATCH
        */
        if( preg_match("|api/$route/[0-9]+$|", $uri) ){

            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getArticleDetail($id);
            elseif ( $method === "PUT" ) updateArticle($payload);
            elseif ( $method === "PATCH" ) patchArticle($id, $payload);

            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    case "biddings":
        /*
        * /api/biddings
        * GET
        */
        if ( $uri === "/api/$route" ) {

            if ( $method === "GET" ) getBiddings();
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
        
    case "categories":
        /*
        * /api/categories
        * GET, POST
        */
        if ( $uri === "/api/$route" ) {
            
            if ( $method === "GET" ) getCategories();
            elseif( $method === "POST" ) postCategory($payload);

            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
    
    case "category":
        /*
        * /api/category/{id}
        * GET, PUT
        */
        if( preg_match("|api/$route/[0-9]+$|", $uri) ){

            $id = explode("/", $uri)[3];
            
            if ( $method === "GET" ) getCategory($id);
            elseif ( $method === "PATCH" ) updateCategory($payload);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
    
    case "user":
        /*
        * /api/user/{id}
        * GET, PATCH, PUT
        */
        if ( preg_match("|api/$route/[0-9]+$|", $uri) ){

            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getUserDetail($id);
            elseif( $method === "PATCH" ) patchUser($id, $payload);
            elseif ( $method === "PUT" ) updateUser($payload);

            else $responseHandler->notAllowed();
        }
        /*
        * /api/user/{id}/articles
        * GET
        */
        elseif (preg_match("|api/$route/[0-9]*/articles$|", $uri)){
            
            $id = explode("/", $uri)[3];

            if ($method === "GET") getUserArticles($id);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    case "login":
        /*
        * /api/login
        * POST
        */
        if ($uri === "/api/$route") {
            
            if ($method === "POST") handleAuthentication($container, $payload);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    case "register":
        /*
        * /api/register
        * POST
        */
        if ($uri === "/api/$route") {
            
            if ($method === "POST") handleRegister( $container, $payload );
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    default:
    $responseHandler->invalidRoute();
        break;
}
