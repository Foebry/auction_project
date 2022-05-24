<?php

    namespace services\requests;

    use models\BaseModel;
    use models\Bidding;

    class BiddingRequest extends Request{
        
        public function __construct()
        {
            parent::__construct();
            $this->resolveEndpoint();
        }

        protected function resolveEndpoint() :void{
            $uri = $this->getUri();

            if( $uri === "/api/biddings" ) $this->resolveBiddings();

            else $this->getResponseHandler()->notFound($this->getDbManager());
        }

        /**
         * @Route("/api/biddings", methods=["GET", "POST"])
         */
        private function resolveBiddings():void {

            if( $this->method === "GET" ) $this->getBiddings();
            elseif( $this->method === "POST" ) $this->postBidding();

            else $this->getResponseHandler()->notAllowed();
        }

        private function getBiddings(): void{
            
            $data = $this->getDbManager()->getSQL("SELECT * from gw_bidding");
            
            $this->respond($data);
        }

        private function postBidding(): void {

            $payload = BaseModel::checkPostPayload("gw_bidding", $this->payload, $this->getDbManager());

            $bidding = Bidding::create($payload, $this);

            $this->respond($bidding->asAssociativeArray, 201);
        }
    }