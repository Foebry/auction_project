<?php

    namespace services\requests;
    
    use DateTime;
    use models\Auction;

    class AuctionRequest extends Request{

        public function __construct()
        {
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(): void {
            $uri = $this->getUri();

            if( $uri === "/api/auctions") $this->resolveAuctions();

            elseif( preg_match("|api/auction/[0-9]+$|", $uri ) ) {
                $auction_id = explode("/", $uri)[3];
                $this->getAuctionDetail($auction_id);
            }
            elseif( preg_match("|api/auction/[0-9]+/biddings$|", $uri ) ) {
                $auction_id = explode("/", $uri)[3];
                $this->getAuctionBiddings($auction_id);
            }
            else $this->getResponseHandler()->invalidRoute();
        }

        /**
         * @Route("/api/auctions" methods=["GET", "POST"])
         */
        private function resolveAuctions(){

            if( $this->method === "GET") $this->getAuctions();
            elseif( $this->method === "POST" ) $this->postAuction($this->payload);

            else $this->getResponseHandler()->notAllowed();
        }
        /**
         * @Route("/api/auction/:id" method="GET")
         */
        private function getAuctionDetail(int $id) {

            $auction = $this->getAuctionHandler()->getAuctionById($id, $this->getDbManager());

            $biddings = $this->getDbManager()->getSQL("
                SELECT bid_id id, bid_usr_id, bid_price bid 
                from gw_bidding 
                where bid_auc_id = $id 
                order by bid_time desc
            ");

            // name en lastname toevoegen aan een bieding onder de key "user"
	        // key bid_usr_id verwijderen
            foreach( $biddings as &$bidding){

                $user_id = $bidding["bid_usr_id"];
                $user = $this->getUserHandler()
                             ->getUserById($user_id, $this->getDbManager())
                             ->asAssociativeArray();
                
                $bidding["user"] = ["usr_id"=>$user["usr_id"]];
            }

            $article = $this->getArticleHandler()
                            ->getArticleById($auction->getAucArtId(), $this->getDbManager());

            $data = [
                "id" => $auction->getAucId(),
                "image" => $article->getArtImg(),
                "name" => $article->getArtName(),
                "expiration" => $auction->getAucExpiration(),
                "biddings" => $biddings,
            ];

            $this->respond($data);
        }
        /**
         * @Route("/api/auction/:id/biddings" method="POST")
         */
        private function getAuctionBiddings($auction_id){

            $biddings = $this->getDbManager()
                             ->getSQL("SELECT * from gw_bidding where bid_auc_id = $auction_id");


            $this->respond($biddings);
        }
        
        private function postAuction(array $payload){

            checkPayloadPOST(["auc_art_id", "auc_expiration"], $payload, $this->getDbManager());
            $article = $this->getArticleHandler()
                            ->getArticleById($payload["auc_art_id"], $this->getDbManager());
            
            $auction = new Auction(null, $article->getArtId(), $payload["auc_expiration"]);
            $auction_id = $this->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_auction(auc_art_id, auc_expiration) values(%d, %d)",
                    $article->getArtCatId(),
                    $payload["auc_expiration"]
                )
            );
            $auction->setAucId($auction_id);

            $this->respond($auction->asAssociativeArray(), 201);
        }
        
        private function getAuctions(){

            $now = new DateTime("now");
            $now = $now->getTimestamp();
            
            $data = $this->getDbManager()->getSQL(
                "SELECT 
                    auc_id id, art_name name, auc_expiration expiration, 
                    (select max(bid_price) from gw_bidding where bid_auc_id = auc_id) as highest_bid, art_img image
                FROM gw_auction JOIN gw_article
                    on auc_art_id = art_id
                WHERE auc_expiration > $now"
            );

            $this->respond($data);
        }
        
    }