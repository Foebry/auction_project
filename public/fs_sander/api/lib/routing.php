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

            if ( $method === "GET" ) getAuctions( $dbm ) ;
            elseif ( $method === "POST" ) postAuction( $container, $payload, AdminRoute($container) );
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

            if ( $method === "GET" ) getAuctionDetail( $container, $id, ProtectedRoute($container) );
            else $responseHandler->notAllowed();
        }
        /*
        * /api/auction/{id}/biddings
        * GET
        */
        elseif ( preg_match("|api/$route/[0-9]+/biddings$|", $uri) ){
            
            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getAuctionBiddings($container, $id, ProtectedRoute($container));
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

    case "articles":
        /*
        * /api/articles
        * GET, POST
        */
        if ( $uri === "/api/$route" ) {
            
            if ( $method === "GET" ) getArticles(AdminRoute($container));
            elseif ( $method === "POST" ) postArticle($payload, AdminRoute($container));
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

            if ( $method === "GET" ) getArticleDetail($id, AdminRoute($container));
            elseif ( $method === "PUT" ) updateArticle($payload, AdminRoute($container));
            elseif ( $method === "PATCH" ) patchArticle($id, $payload, AdminRoute($container));

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

            if ( $method === "GET" ) getBiddings(AdminRoute($container));
            elseif ( $method === "POST" ) postBidding($container, $payload, ProtectedRoute($container));
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
            
            if ( $method === "GET" ) getCategories(AdminRoute($container));
            elseif( $method === "POST" ) postCategory($payload, AdminRoute($container));

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
            
            if ( $method === "GET" ) getCategory($id, AdminRoute($container));
            elseif ( $method === "PATCH" ) updateCategory($payload, AdminRoute($container));
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();

        break;
    
    case "user":
        /*
        * /api/user/{id}
        * GET, PATCH, PUT
        */
        if( $uri === "/api/$route" ){
            if( $method === "GET" ) getUserDetailSelf( $container, ProtectedRoute( $container ) );
            if ($method === "PATCH" ) PatchUserSelf( $payload, $container, ProtectedRoute( $container ) );
            else $responseHandler->notAllowed();
        }

        elseif ( preg_match("|api/$route/[0-9]+$|", $uri) ){

            $id = explode("/", $uri)[3];

            if ( $method === "GET" ) getUserDetail($id, $container, AdminRoute($container));
            elseif( $method === "PATCH" ) updateUser($id, $payload, $container, AdminRoute($container));
            elseif ( $method === "DELETE" ) deleteUser($id, $container, AdminRoute($container));

            else $responseHandler->notAllowed();
        }
        elseif( $uri === "/api/$route/auctions"){
            if( $method === "GET" ) getUserAuctionsSelf( $container, ProtectedRoute( $container ) );
            else $container->notAllowed();
        }
        /*
        * /api/user/{id}/articles
        * GET
        */
        elseif (preg_match("|api/$route/[0-9]*/auctions$|", $uri)){
            
            $id = explode("/", $uri)[3];

            if ($method === "GET") getUserAuctions($id, $container, AdminRoute($container));
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

    case "logout":
        if( $uri === "/api/$route"){
            if( $method === "DELETE" ) handleLogout();
            else $responseHandler->notAllowed();
        }
        else $responseHandler->invalidRoute();
        break;

    default:
        $responseHandler->invalidRoute();
        break;
}
