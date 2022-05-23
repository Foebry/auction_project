<?php
    namespace services\requests;

    use models\Article;

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
            else $this->getResponseHandler()->invalidRoute();

            
        }

        /**
         * @Route("/api/articles" methods=["GET", "POST"])
         */
        private function resolveArticles(){

            if( $this->method === "GET" ) $this->getArticles();
            elseif( $this->method === "POST" ) $this->postArticle($this->payload);
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

            $payload = Article::checkPostPayload($payload, $this->getDbManager());

            $this->getCategoryHandler()->getCategoryById($payload["art_cat_id"], $this->getDbManager());

            $article = new Article($payload);

            $art_id = $this->getDbManager()->insertSQL(
                sprintf(
                    "INSERT into gw_article(art_name, art_img, art_cat_id) values('%s', '%s', %d)",
                    $article->getArtName(),
                    $article->getArtImg(),
                    $article->getArtCatId()
                  )
                );
            
            $article->setArtId($art_id);

            $this->respond($article->asAssociativeArray(), 201);
        }

        private function getArticle(int $art_id){

            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());

        }

        private function updateArticle(int $art_id) {

            $payload = $this->payload;
            $update = Article::checkPatchPayload($payload, $this->getDbManager());

            $this->getDbManager("UPDATE gw_article set $update where art_id = $art_id");

            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());
        }

        private function deleteArticle(int $art_id) {
            
            $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());
            $this->getDbManager()->getSQL("DELETE from gw_article where art_id = $art_id");

            $this->respond([], 204);
        }  
    }