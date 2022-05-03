<?php

$method = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$route = explode("/", $uri)[2];

$responseHandler = new ResponseHandler();

switch ($route) {
    /*
    * /api/auctions
    * GET, POST
    */
    case "auctions":
        if ($uri === "/api/$route") {

            if ($method === "GET") getAuctions();
            elseif ($method === "POST") postAuction($payload);
            else $responseHandler->notAllowed();

        }
        else $responseHandler->invalidRoute();

        break;
    
    case "auction":
        /*
        * /api/auction/{id}
        * GET
        */
        if ($uri === "|api/$route/[0-9]*$|") {
            if ($method === "GET") getAuctionDetail($id);
            else $responseHandler->notAllowed();
        }
        /*
        * /api/auction/{id}/biddings
        * GET
        */
        elseif ($uri === "|api/$route/[0-9]*/biddings$|"){

            if ($method === "GET") getAuctionBiddings($id);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

    case "articles":
        /*
        * /api/articles
        * GET, POST
        */
        if ($uri === "/api/$route") {
            
            if ($method === "GET") getArticles();
            elseif ($method === "POST") postArticle($payload);
            else $responseHandler->notAllowed();
        }

        else $responseHandler->invalidRoute();

        break;
    
    case "article":
        /*
        * /api/article/{id}
        * GET, PUT, PATCH
        */
        if($uri === "|api/$route/[0-9]*$|"){

            if ($method === "GET") getArticleDetail($id);
            elseif ($method === "PUT") updateArticle($payload);
            elseif ($method === "PATCH") patchArticle($id, $payload);

            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    case "biddings":
        /*
        * /api/biddings
        * GET
        */
        if ($uri === "/api/$route") {

            if ($method === "GET") getBiddings();
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
        
    case "categories":
        /*
        * /api/categories
        * GET, POST
        */
        if ($uri === "/api/$route") {
            
            if ($method === "GET") getCategories();
            elseif($method === "POST") postCategory($payload);

            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
    
    case "category":
        /*
        * /api/category/{id}
        * PUT
        */
        if($uri === "|api/$route/[0-9]*$|"){
            
            if ($method === "PATCH") updateCategory($payload);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
    
    case "user":
        /*
        * /api/user/{id}
        * GET, PATCH, PUT
        */
        if (preg_match("|api/$route/[0-9]*$|", $uri)){

            if ($method === "GET") getUserDetail($id);
            elseif($method === "PATCH") patchUser($id, $payload);
            elseif ($method === "PUT") updateUser($payload);

            else $responseHandler->notAllowed();
        }
        /*
        * /api/user/{id}/articles
        * GET
        */
        elseif (preg_match("|api/$route/[0-9]*/articles$|", $uri)){

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
            
            if ($method === "POST") handleAuthentication($payload);
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
            
            if ($method === "POST") handleRegister($payload);
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;

    default:
    $responseHandler->invalidRoute();
        break;
}
