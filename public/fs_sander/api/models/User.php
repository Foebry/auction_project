<?php

    namespace models;

    use models\BaseModel;
    use services\handlers\ResponseHandler;
    use services\DbManager;
    use DateTime;
    use TypeError;


    class User extends BaseModel {

        public $usr_id;

        public $usr_name;

        public $usr_lastname;

        public $usr_email;

        public $usr_password;

        public $usr_isAdmin;

        /**
         * @param $usr_id
         * @param $usr_name
         * @param $usr_email
         * @param $usr_password
         */
        public function __construct( array $data ){
            
            try{
                $this->setUsrId($data["usr_id"] ?? null);
                $this->setUsrName($data["usr_name"]);
                $this->setLastName($data["usr_lastname"] ?? '');
                $this->setUsrEmail($data["usr_email"]);
                $this->setUsrPassword($data["usr_password"], !in_array("usr_id", array_keys($data)));
                $this->setUsrAdmin($data["usr_is_admin"] ?? 0);
            }
            catch(TypeError $error){
                $rh = new ResponseHandler();
                $rh->badRequest(new DbManager($rh), ["message"=>$error->getMessage()]);
            }
        }

        /**
         * @return int
         */
        public function getUsrId() {
            return $this->usr_id;
        }

        public function setUsrId(int $usr_id=null) {
            $this->usr_id = $usr_id;
        }

        /**
         * @return string
         */
        public function getUsrName() {
            return $this->usr_name;
        }

        /**
         * @param string $usr_name
         */
        public function setUsrName(string $usr_name) {
            $this->usr_name = $usr_name;
        }

        public function getLastName(): string{
            return $this->usr_lastname;
        }

        public function setLastName(string $lastname=""): void {
            $this->usr_lastname = $lastname;
        }
        
        public function getUsrFullName(): string {
            return $this->getUsrName()." ".$this->getLastName();
        }

        /**
         * @return string
         */
        public function getUsrEmail() {
            return $this->usr_email;
        }

        /**
         * @param string $usr_email
         */
        public function setUsrEmail($usr_email) {
            if (preg_match('/.+\@.+\..+/', $usr_email) || $usr_email === "admin"){
                $this->usr_email = $usr_email;
            }
            else{
                $rh = new ResponseHandler();
                $rh->badRequest(new DbManager($rh), ["usr_email"=>"Wrong format"]);
            }
        }

        /**
         * @return string
         */
        public function getUsrPassword() {
            return $this->usr_password;
        }

        /**
         * @param string $usr_password
         */
        public function setUsrPassword($usr_password, $needsHash=false) {

            if( $needsHash ) $this->usr_password = password_hash($usr_password, 1);
            else $this->usr_password = $usr_password;
        }

        public function setUsrAdmin(int $admin=0){
            $this->usr_isAdmin = $admin;
        }

        /**
         * 
         */
        public function IsAdmin(){
            return $this->usr_isAdmin;
        }

        public static function fetchAuctionsWon(int $usr_id, DbManager $dbm): array {

            $auctions_won = [];

                $now = new DateTime("now");

                $data = $dbm->getSQL(
                    sprintf("
                    select auc_id id, auc_start started, auc_expiration ended,
                    (select max(bid_price) from gw_bidding where bid_auc_id=id) price,
                    art_id, art_name, art_img from gw_auction gau
                    join gw_article gar on gau.auc_art_id = gar.art_id
                    where auc_usr_id = %d
                    and auc_expiration < '%s'", $usr_id, $now->format("Y-m-d H:i:s")));
            
            //embed article data in auction
            foreach($data as $auction){
                $auction["article"] = [
                    "id"=>$auction["art_id"],
                    "image"=>$auction["art_img"],
                    "name"=>$auction["art_name"],
                ];
                //verwijder overbodige keys
                unset($auction["art_id"]);
                unset($auction["art_img"]);
                unset($auction["art_name"]);

                $auctions_won[] = $auction;
            }

            return $auctions_won;
        }

        public static function fetchBiddings(int $usr_id, DbManager $dbm): array {

            $user_biddings = [];

            $data = $dbm->getSQL(
                "select max(bid_id) id, max(bid_price) amount, bid_time time, bid_auc_id, art_name, art_id, art_img
                from gw_bidding
                join gw_auction ga on gw_bidding.bid_auc_id = ga.auc_id
                join gw_article g on ga.auc_art_id = g.art_id
                where ga.auc_usr_id=$usr_id
                group by bid_auc_id"
            );

            // embed auction in bidding
            // embed article in auction
            foreach ($data as $bidding) {

                $bidding["auction"] = [
                    "id"=>$bidding["bid_auc_id"],
                    "article" => [
                        "id"=>$bidding["art_id"],
                        "name"=>$bidding["art_name"],
                        "image"=>$bidding["art_img"]
                    ],
                ];
                // verwijder overbodige keys
                unset(
                    $bidding["bid_auc_id"],
                    $bidding["art_name"],
                    $bidding["art_id"],
                    $bidding["art_img"]
                );

                $user_biddings[] = $bidding;
            }
            return $user_biddings;
        }

        public static function create( array $payload, DbManager $dbm): User{

            $user = new User($payload);

            $usr_id = $dbm->insertSQL(
                sprintf(
                    "INSERT into gw_user (usr_name, usr_lastname, usr_email, usr_password) values('%s', '%s', '%s', '%s')",
                    $user->getUsrName(), $user->getLastName(), $user->getUsrEmail(), $user->getUsrPassword()
                )
            );

            $user->setUsrId($usr_id);

            return $user;
        }
    }