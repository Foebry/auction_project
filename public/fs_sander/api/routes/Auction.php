<?php

use models\Container;
use services\DbManager;
use models\Response;
use models\Auction;

function getAuctions( DbManager $dbm ): Response
{
	$now = new DateTime("now");
	$now = $now->getTimestamp()*1000;
	
	$data = $dbm->getSQL(
		"SELECT 
			auc_id id, art_name name, auc_expiration expiration, 
			(select max(bid_price) from gw_bidding where bid_auc_id = auc_id) as highest_bid, art_img image
		FROM gw_auction JOIN gw_article
			on auc_art_id = art_id
		WHERE auc_expiration > $now"
	);

	$dbm->closeConnection();

	return new Response($data);
}

function postAuction(Container $container, string $payload) {

	$payload = json_decode($payload, true);

	checkPayloadPOST(["auc_art_id", "auc_expiration"], $payload, $container);
	$article = $container->getArticleHandler()->getById($payload["auc_art_id"], $container);

	$auction = new Auction(null, $article->getArtId(), $payload["auc_expiration"]);

	$auction_id = $container->getDbManager()->insertSQL(
		sprintf(
			"INSERT into gw_auction(auc_art_id, auc_expiration) values(%d, %d)",
			$article->getArtCatId(),
			$payload["auc_expiration"]
		)
	);
	$container->getDbManager()->closeConnection();

	return new Response([
		"auc_id" => $auction_id,
		"auc_art_id"=>$auction->getAucArtId(),
		"auc_expiration"=>$auction->getAucExpiration()
	]);

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
		$bidding["user"] = $dbm->getSQL("SELECT usr_name name, usr_lastname lastname from gw_user where usr_id = $user_id")[0];
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
