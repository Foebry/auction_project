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
            // if( $uri === "/api/auctions") $this->resolveAuctions();

            elseif( preg_match("|api/auction/[0-9]+$|", $uri ) ) {
                $auction_id = explode("/", $uri)[3];
                $this->getAuctionDetail($auction_id);
            }
            elseif( preg_match("|api/auction/[0-9]+/biddings$|", $uri ) ) {
                $auction_id = explode("/", $uri)[3];
                $this->getAuctionBiddings($auction_id, ProtectedRoute( $this ) );
            }
            else $this->getResponseHandler()->notFound($this->getDbManager());
        }

        /**
         * @Route("/api/auctions" methods=["GET", "POST"])
         * @RouteType public ("GET")
         * @RouteType Admin ("POST")
         */
        private function resolveAuctions(){

            if( $this->method === "GET") $this->getAuctions();
            elseif( $this->method === "POST" ) $this->postAuction($this->getPayload(), AdminRoute( $this ) );

            else $this->getResponseHandler()->notAllowed($this->getDbManager());
        }
        /**
         * @Route("/api/auction/:id" method="GET")
         * @RouteType public
         */
        private function getAuctionDetail(int $id) {

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
         * @Route("/api/auction/:id/biddings" method="GET")
         * @RouteType protected
         */
        private function getAuctionBiddings($auction_id){

            if( $this->getMethod() !== "GET" ) $this->getResponseHandler()->notAllowed();

            $biddings = $this->getDbManager()
                             ->getSQL("SELECT * from gw_bidding where bid_auc_id = $auction_id");


            $this->respond($biddings);
        }
        
        private function postAuction(array $payload){

            BaseModel::checkPostPayload("gw_auction", $payload, $this->getDbManager());
            
            $auction = Auction::create($payload, $this);
            
            $this->respond($auction->asAssociativeArray(), 201);
        }
        
        private function getAuctions(){
            
            $select = "SELECT auc_id id, art_name name, auc_expiration expiration,"."\n". 
"(select max(bid_price) from gw_bidding where bid_auc_id = auc_id) as highest_bid, art_img image
    FROM gw_auction\n";

            $params = getParamList($this->getQueryString());

            [$join, $where, $sort] = processParams("auctions", $this->getQueryString(), ["gw_article"=>["art_id", "auc_art_id"]]);

            $total = $this->getDbManager()->getSQL("select count(*) total from ($select $join $where $sort) as temp")[0]["total"];
            $total_pages = intval(ceil(intval($total) / ($params["page_count"] ?? 10)));

            $limit = getPageLimit($this->getQueryString());

            [$offset, $page] = getOffset($this->getQueryString(), $total);

            $next_page = $page < $total_pages ? $page + 1 : null;
            $prev_page = $page > 1 ? $page -1 : null;

            $query = "$select $join $where $sort $limit $offset";

            $auctions = $this->getDbManager()->getSQL($query);

            // $this->respond($data);
            $this->respond([
                "page"=>$page,
                "total"=>$total,
                "total_pages"=>$total_pages,
                "next_page"=>$next_page,
                "prev_page"=>$prev_page,
                "auctions"=>$auctions
            ]);
        }
        
    }