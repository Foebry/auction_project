<?php

    namespace models;

    use models\BaseModel;
    use DateTime;
    use services\handlers\ResponseHandler;
    use \services\DbManager;
    use \services\requests\Request;
    use TypeError;

    class Auction extends BaseModel {

        public $auc_id;

        public $auc_art_id;

        public $auc_expiration;

        public $auc_start;

        public $auc_usr_id;

        /**
         * @param $auc_id
         * @param $auc_art_id
         * @param $auc_expiration
         */
        public function __construct( $data ){
            
            try{
                $this->setAucId($data["auc_id"] ?? null);
                $this->setAucArtId($data["auc_art_id"]);
                $this->setAucExpiration($data["auc_expiration"] ?? "", !in_array("auc_expiration", array_keys($data)));
                $this->setAucStart($data["auc_start"] ?? "", !in_array("auc_start", array_keys($data)));
                $this->setAucUsrId($data["auc_usr_id"] ?? -1);
            }
            catch(TypeError $error){
                $rh = new ResponseHandler();
                $rh->badRequest(null, ["message"=>$error->getMessage()]);
            }
        }

        public function setAucId(int $auc_id=null): void{
            $this->auc_id = $auc_id;
        }

        /**
         * @return int
         */
        public function getAucId(): int {
            return $this->auc_id;
        }

        /**
         * @return int
         */
        public function getAucArtId(): int {
            return $this->auc_art_id;
        }

        /**
         * @param int $auc_art_id
         */
        public function setAucArtId(int $auc_art_id): void {
            $this->auc_art_id = $auc_art_id;
        }

        /**
         * @return string
         */
        public function getAucExpiration(): string {
            return $this->auc_expiration;
        }

        /**
         * @param string $auc_expiration
         */
        public function setAucExpiration(string $auc_expiration, $default): void {

            if( $default ){
                $dt = new Datetime("now + 10min");
                $this->auc_expiration = $dt->format("Y-m-d H:i:s");
            }
            else $this->auc_expiration = $auc_expiration;
        }

        public function setAucStart(string $auc_start, $default): void {

            if( $default ){
                $dt = new DateTime("now");
                $this->auc_start = $dt->format("Y-m-d H:i:s");
            }
            else $this->auc_start = $auc_start;
        }

        public function getAucStart(): string {
            return $this->auc_start;
        }

        public function setAucUsrId(int $usr_id): void{
            $this->auc_usr_id = $usr_id;
        }

        public function getAucUsrId(): int{
            return $this->auc_usr_id;
        }


        /**
         * getHighestBidValue
         *
         * @param  DbManager $dbm
         * @return int
         */
        public function getHighestBidValue(DbManager $dbm): float {

            $auction_id = $this->getAucId();
            $data = $dbm->getSQL("SELECT bid_price from gw_bidding where bid_auc_id = $auction_id order by bid_price desc limit 1");

            $highest_bid = $data[0]["bid_price"] ?? 0;

            return $highest_bid;
        }

        /**
         * validateBidTiming
         *
         * @param  Auction $auction
         * @param  Container $container
         * @return void
         */
        public static function validateBidTiming(Auction $auction, Request $request): void{

            $now = new DateTime("now");
            $currentTimestamp = $now->getTimestamp()*1000;

            $auction_expired = $currentTimestamp > $auction->getAucExpiration();
            // $auction_not_started = $currentTimestamp < $auction->getAucStart();

            if ($auction_expired /*or $auction_not_started */)
                $request->getResponseHandler()->unprocessableEntity($request->getDbManager(), ["message"=>"You cannot bid on this auction at this time"]);

        }

        public static function create( array $payload, Request $request): Auction {

            //check of Article met id bestaat
            $article = $request->getArticleHandler()->getArticleById($payload["auc_art_id"], $request->getDbManager());

            $auction = new Auction($payload);
            
            $auction_id = $request->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_auction(auc_art_id, auc_expiration, auc_start, auc_usr_id) values(%d, '%s', '%s', %d);",
                    $article->getArtId(),
                    $auction->getAucExpiration(),
                    $auction->getAucStart(),
                    $auction->getAucUsrId()
                )
            );

            $auction->setAucId($auction_id);

            return $auction;
        }

        /**
         * @return Auction[]
         */
        public static function getAllExpiredNotSold(DbManager $dbm): array {

            $time = new DateTime("now");
            $now = $time->format("Y-m-d H:i:s");

            $query = sprintf("SELECT * from gw_auction where auc_expiration < '%s' and auc_usr_id = -1", $now);
            $data = $dbm->getSQL($query);

            $auctions = [];

            foreach($data as $row){
                $auctions[] = new Auction($row);
            }

            return $auctions;
        }
    }