<?php

use services\DbManager;
use models\Response;

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

function postAuction() {
    print("POST auction logic");
  /**
   * @todo Create Insert Auction
   */
}

function getAuctionDetail( $id ) {

    print("GET auctionDetail logic for id $id");
  /**
   * @todo Create select AuctionDetail
   */
    exit();
}

function getAuctionBiddings() {
    print("GET auction biddings logic");
  /**
   * @todo Create Select AuctionBidding
   */
    exit();
}
