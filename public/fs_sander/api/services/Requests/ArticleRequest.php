<?php
    namespace services\requests;

    use models\BaseModel;
    use models\Article;
    use services\handlers\ArticleHandler;

    class ArticleRequest extends Request{
        
        public function __construct()
        {
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(){

            $uri = $this->getUri();
            
            if( $uri === "/api/articles" ) $this->resolveArticles();

            elseif( preg_match("|api/article/[0-9]+$|", $uri)) {
                $art_id = explode("/", $uri)[3];
                $this->resolveArticle($art_id);
            }
            else $this->getResponseHandler()->notFound($this->getDbManager());

            
        }

        /**
         * @Route("/api/articles" methods=["GET", "POST"])
         */
        private function resolveArticles(){

            if( $this->method === "GET" ) $this->getArticles();
            elseif( $this->method === "POST" ) $this->postArticle($this->payload);

            else $this->getResponseHandler()->notAllowed($this->getDbManager());
        }
        /**
         * @Route("/api/article/:id" methods=["GET", "PATCH", "DELETE"])
         */
        private function resolveArticle(int $art_id){

            if( $this->method === "GET" ) $this->getArticle($art_id);
            elseif( $this->method === "PATCH" ) $this->updateArticle($art_id);
            elseif( $this->method === "DELETE" ) $this->deleteArticle($art_id);
        }

        private function getArticles(){

            $data = $this->getDbManager()->getSQL(
                "SELECT * from gw_article"
            );

            $this->respond($data);
        }

        private function postArticle(array $payload){

            $payload = BaseModel::checkPostPayload("gw_article", $payload, $this->getDbManager());

            $article = Article::create($payload, $this);

            $this->respond($article->asAssociativeArray(), 201);
        }

        private function getArticle(int $art_id){

            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());

        }

        private function updateArticle(int $art_id) {

            $payload = $this->payload;
            $update = BaseModel::checkPatchPayload("gw_article", $payload, $this->getDbManager());

            // nagaan of article met art_id bestaat.
            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->getDbManager()->getSQL("UPDATE gw_article set $update where art_id = $art_id");

            // nieuwe data article ophalen
            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());
        }

        private function deleteArticle(int $art_id) {
            
            $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());
            $this->getDbManager()->getSQL("DELETE from gw_article where art_id = $art_id");

            $this->respond([], 204);
        }  
    }