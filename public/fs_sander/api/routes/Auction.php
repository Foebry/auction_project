<?php

use \models\Response;
use \models\Container;

function getAuctions()
{
    print("GET auctions logic");
  /**
   * @todo Create Select Auction
   */
}

function postAuction() {
    print("POST auction logic");
  /**
   * @todo Create Insert Auction
   */
}

/**
 * getAuctionDetail
 *
 * @param  Container $container
 * @param  int $id
 * @return Response
 */
function getAuctionDetail( Container $container, int $id ): Response {

	$dbm = $container->getDbManager();

	$auction = $container->getAuctionHandler()->getById($id, $container);
	$biddings = $dbm->getSQL("
		SELECT bid_id id, bid_usr_id, bid_price bid from gw_bidding where bid_auc_id = $id order by bid_time desc
	");

	// name en lastname toevoegen aan een bieding onder de key "user"
	// key bid_usr_id verwijderen
	foreach($biddings as &$bidding) {
		$user_id = $bidding["bid_usr_id"];
		$bidding["user"] = $dbm->getSQL("SELECT usr_name name, usr_lastname lastname from gw_user where usr_id = $user_id");
		unset($bidding["bid_usr_id"]);
	}

	$article = $container->getArticleHandler()->getById($auction->getAucArtId(), $container);

	$data = [
		"id" => $auction->getAucId(),
		"image" => $article->getArtImg(),
		"name" => $article->getArtName(),
		"expiration" => $auction->getAucExpiration(),
		"biddings" => $biddings,
	];

	$dbm->closeConnection();
	return new Response($data);
}

/**
 * getAuctionBiddings
 *
 * @param  Container $container
 * @param  int $auction_id
 * @return Response
 */
function getAuctionBiddings(Container $container, int $auction_id): Response {

	$dbm = $container->getDbManager();

	$biddings = $dbm->getSQL("SELECT * from gw_bidding where bid_auc_id = $auction_id");

	$dbm->closeConnection();

	return new Response($biddings);
}
