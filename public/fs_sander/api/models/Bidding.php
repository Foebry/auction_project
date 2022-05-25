<?php

    namespace models;

    use models\BaseModel;
    use \DateTime;
    use services\handlers\ResponseHandler;
    use services\requests\Request;
    use TypeError;

    class Bidding extends BaseModel {

        public $bid_id;

        public $bid_user_id;

        public $bid_auc_id;

        public $bid_price;

        /**
         * @param $bid_id
         * @param $bid_user_id
         * @param $bid_auc_id
         * @param $bid_price
         */
        public function __construct($data) {
            try{
                $this->setBidId($data["bid_id"] ?? null);
                $this->setBidAucId($data["bid_auc_id"]);
                $this->setBidUserId($data["bid_usr_id"]);
                $this->setBidPrice($data["bid_price"]);
            }
            catch(TypeError $error){
                $rh = new ResponseHandler();
                $rh->badRequest(null, ["message"=>$error->getMessage()]);
            }
        }

        /**
         * @return int
         */
        public function getBidId() {
            return $this->bid_id;
        }

        public function setBidId(int $bid_id=null) {
            $this->bid_id = $bid_id;
        }

        /**
         * @return int
         */
        public function getBidUserId() {
            return $this->bid_user_id;
        }

        /**
         * @param int $bid_user_id
         */
        public function setBidUserId(int $bid_user_id) {
            $this->bid_user_id = $bid_user_id;
        }

        /**
         * @return int
         */
        public function getBidAucId() {
            return $this->bid_auc_id;
        }

        /**
         * @param int $bid_auc_id
         */
        public function setBidAucId(int $bid_auc_id) {
            $this->bid_auc_id = $bid_auc_id;
        }

        /**
         * @return float
         */
        public function getBidPrice() {
            return $this->bid_price;
        }

        /**
         * @param float $bid_price
         */
        public function setBidPrice(float $bid_price) {
            $this->bid_price = $bid_price;
        }


        public static function create(array $payload, Request $request): Bidding {

            $bidding = new Bidding($payload);

            Bidding::validateBidPrice($payload, $request);

            $now = new DateTime();

            $bidding_id = $request->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_bidding (bid_usr_id, bid_auc_id, bid_price, bid_time) values(%d, %d, %f, %d)",
                    $bidding->getBidUserId(),
                    $bidding->getBidAucId(),
                    $bidding->getBidPrice(),
                    $now->format("Y-m-d H:i:s")
                )
            );

            $bidding->setBidId($bidding_id);

            return $bidding;
        }

        /**
         * validateBidPrice
         *
         * @param  array $payload
         * @param  Container $container
         * @return void
         */
        public static function validateBidPrice(array $payload, Request $request): void {
            
            $dbm = $request->getDbManager();
            $auction = $request->getAuctionHandler()->getAuctionById($payload["bid_auc_id"], $dbm);
            
            // valideer of bid hoger is dan hoogste bod op auction
            if ($payload["bid_price"] <= $auction->getHighestBidValue($dbm)){
                $request->getResponseHandler()->badRequest($dbm, ["bid_price"=>"Bid too low"]);
            }
        }

    }


