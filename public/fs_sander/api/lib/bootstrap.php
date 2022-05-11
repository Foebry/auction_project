<?php

use models\Container;

require_once "access_control.php";
require_once "validation.php";
//services
require_once "services/ArticleHandler.php";
require_once "services/AuctionHandler.php";
require_once "services/BiddingHandler.php";
require_once "services/CategoryHandler.php";
require_once "services/DbManager.php";
require_once "services/ResponseHandler.php";
require_once "services/UserHandler.php";
// models
require_once "models/Container.php";
require_once "models/BaseModel.php";
require_once "models/Article.php";
require_once "models/Auction.php";
require_once "models/Bidding.php";
require_once "models/Category.php";
require_once "models/Response.php";
require_once "models/User.php";

if ( !isset($_SESSION ) ) session_start();
// create Container id needed;
if ( !isset( $_SESSION["container"] ) ) $_SESSION["container"] = new Container();

//routes
require_once "routes/Article.php";
require_once "routes/Auction.php";
require_once "routes/Authentication.php";
require_once "routes/Bidding.php";
require_once "routes/Category.php";
require_once "routes/User.php";

//router
require_once "routing.php";
