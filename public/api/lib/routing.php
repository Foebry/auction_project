<?php

$method = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$route = explode("/", $uri)[2];

switch ($route) {
    case "auctions":
        if ($uri === "/api/$route") {

            if ($method === "GET") getAuctions();
            elseif ($method === "POST") postAuction($payload);
            else ResponseHandler->notAllowed();

        }
        else ResponseHandler->invalidRoute();

        break;
    
    case "auction":
        if ($uri === "|api/$route/[0-9]*$|") {
            if ($method === "GET") getAuctionDetail($id);
            else ResponseHandler->notAllowed();
        }
        elseif ($uri === "|api/$route/[0-9]*/biddings$|"){

            if ($method === "GET") getAuctionBiddings($id);
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

    case "articles":
        if ($uri === "/api/$route") {
            
            if ($method === "GET") getArticles();
            elseif ($method === "POST") postArticle($payload);
            else ResponseHandler->notAllowed();
        }

        else ResponseHandler->invalidRoute();

        break;
    
    case "article":
        if($uri === "|api/$route/[0-9]*$|"){

            if ($method === "GET") getArticleDetail($id);
            elseif ($method === "PUT") updateArticle($payload);
            elseif ($method === "PATCH") patchArticle($id, $payload);

            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;

    case "biddings":
        if ($uri === "/api/$route") {

            if ($method === "GET") getBiddings();
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;
    
    case "categories":
        if ($uri === "/api/$route") {
            
            if ($method === "GET") getCategories();
            elseif($method === "POST") postCategory($payload);

            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;
    
    case "category":
        if($uri === "|api/$route/[0-9]*$|"){
            
            if ($method === "PATCH") patchCategory($id, $payload);
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;
    
    case "user":
        if (preg_match("|api/$route/[0-9]*$|", $uri)){

            if ($method === "GET") getUserDetail($id);
            elseif($method === "PATCH") patchUser($id, $payload);
            elseif ($method === "PUT") updateUser($payload);

            else ResponseHandler->notAllowed();
        }
        elseif (preg_match("|api/$route/[0-9]*/articles$|", $uri)){

            if ($method === "GET") getUserArticles($id);
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;

    case "login":
        if ($uri === "/api/$route") {
            
            if ($method === "POST") handleAuthentication($payload);
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;

    case "register":
        if ($uri === "/api/$route") {
            
            if ($method === "POST") handleRegister($payload);
            else ResponseHandler->notAllowed();
        }
        else ResponseHandler->invalidRoute();

        break;

    default:
        ResponseHandler->invalidRoute();
        break;
}
