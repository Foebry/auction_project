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
 * @param  mixed $container
 * @param  mixed $id
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

function getAuctionBiddings() {
    print("GET auction biddings logic");
  /**
   * @todo Create Select AuctionBidding
   */
    exit();
}
