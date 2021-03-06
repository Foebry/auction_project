<?php

    namespace services\requests;

    use models\BaseModel;
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
            if( preg_match("|api/auctions\??.*|", $uri) ) $this->resolveAuctions();

            elseif( preg_match("|api/auction/[0-9]+$|", $uri ) ) $this->resolveAuction();

            elseif( preg_match("|api/auction/[0-9]+/biddings$|", $uri ) ) {
                $auction_id = explode("/", $uri)[3];
                $this->getAuctionBiddings($auction_id, ProtectedRoute( $this ) );
            }
            else $this->getResponseHandler()->notFound($this->getDbManager());
        }

        /**
         * @Route("/api/auctions" methods=["GET", "POST", "PATCH"])
         * @RouteType public ("GET")
         * @RouteType Admin ("POST")
         * @RouteType Admin ("PATCH")
         */
        private function resolveAuctions(): void{

            if( $this->method === "GET") $this->getAuctions();
            elseif( $this->method === "PATCH" ) $this->updateAuctions( AdminRoute( $this ) );
            elseif( $this->method === "POST" ) $this->postAuction($this->getPayload(), AdminRoute( $this ) );

            else $this->getResponseHandler()->notAllowed($this->getDbManager());
        }
        /**
         * @Route("/api/auction/:id" methods=["GET", "PATCH"])
         * @RouteType public ("GET")
         * @RouteType Admin ("PATCH")
         */
        private function resolveAuction(): void{

            $method = $this->getMethod();
            $auction_id = explode("auction/", $this->getUri())[1];
            $payload = $this->getPayload();

            if( $method === "GET" ) $this->getAuctionDetail($auction_id);
            elseif( $method === "PATCH" ) $this->updateAuction($auction_id, $payload, AdminRoute( $this ) );

            else $this->getResponseHandler()->notAllowed();
        }
        /**
         * @Route("/api/auction/:id" method="GET")
         * @RouteType public
         */
        private function getAuctionDetail(int $id): void {

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed($this->getDbManager());

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
                
                $bidding["user"] = [
                                    "usr_id"=>$user["usr_id"],
                                    "name"=>$user["usr_name"],
                                    "lastname"=>$user["usr_lastname"]
                                ];
                unset($bidding["bid_usr_id"]);
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
         * @Route("/api/auction/:id/biddings" method="GET")
         * @RouteType protected
         */
        private function getAuctionBiddings($auction_id): void{

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $biddings = $this->getDbManager()
                             ->getSQL("SELECT * from gw_bidding where bid_auc_id = $auction_id");


            $this->respond($biddings);
        }
        
        private function postAuction(array $payload): void{

            validateCsrf($payload, $this);

            BaseModel::checkPostPayload("gw_auction", $payload, $this->getDbManager());

            $auction = Auction::create($payload, $this);
            
            $this->respond($auction->asAssociativeArray(), 201);
        }
        
        private function getAuctions(): void{
            
            $baseQuery = "SELECT auc_id id, art_name name, auc_expiration expiration,"."\n". 
            "(select max(bid_price) from gw_bidding where bid_auc_id = auc_id) as highest_bid, art_img image
                FROM gw_auction\n";

            [$query, $total, $total_pages, $page, $next_page, $prev_page, $page_count, $start, $end] = createQuery($baseQuery, $this, "auctions", ["gw_article"=>["art_id", "auc_art_id"]], 10);

            $auctions = $this->getDbManager()->getSQL($query);

            foreach($auctions as &$auction){
               if( !$auction["highest_bid"] ) $auction["highest_bid"] = 0;
            }

            $this->respond([
                "page"=>$page,
                "total"=>$total,
                "nextPage"=>$next_page,
                "prevPage"=>$prev_page,
                "start"=>$start,
                "end"=>$end,
                "auctions"=>$auctions
            ]);
        }

        private function updateAuction(int $auc_id, array $payload, $batch=false): Auction{

            validateCsrf($payload, $this);

            $update = BaseModel::checkPatchPayload("gw_auction", $payload, $this);

            $this->getAuctionHandler()->getAuctionById($auc_id, $this->getDbManager());

            if( in_array("auc_art_id", array_keys($payload)) ){
                $art_id = $payload["auc_art_id"];
                $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());
            }

            $this->getDbManager()->getSQL("UPDATE gw_auction set $update where auc_id=$auc_id");

            //nieuwe data ophalen
            $auction = $this->getAuctionHandler()->getAuctionById($auc_id, $this->getDbManager());

            if( $batch ) return $auction;

            $this->respond($auction->asAssociativeArray());

        }

        private function updateAuctions(): void {

            $payload = $this->getPayload();

            validateCsrf($payload, $this);

            $expired_auctions_not_sold = Auction::getAllExpiredNotSold($this->getDbManager());

            $auctions = [];

            foreach($expired_auctions_not_sold as $auction){

                $now = new DateTime("now + 10min");
                $time = $now->format("Y-m-d H:i:s");

                $auc_id = $auction->getAucId();
                $payload = ["auc_expiration" => $time];

                $auctions[] = $this->updateAuction($auc_id, $payload, true);

            }

            $this->respond($auctions);
        }
        
    }