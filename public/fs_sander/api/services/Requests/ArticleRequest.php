<?php
    namespace services\requests;

    use models\BaseModel;
    use models\Article;

    class ArticleRequest extends Request{
        
        public function __construct()
        {
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(){

            $uri = $this->getUri();
            
            if( $uri === "/api/articles" ) $this->resolveArticles( AdminRoute( $this ) );

            elseif( preg_match("|api/article/[0-9]+$|", $uri)) {
                $art_id = explode("/", $uri)[3];
                $this->resolveArticle($art_id, AdminRoute( $this ));
            }
            else $this->getResponseHandler()->notFound($this->getDbManager());

            
        }

        /**
         * @Route("/api/articles" methods=["GET", "POST"])
         * @RouteType AdminRoute
         */
        private function resolveArticles(){

            if( $this->method === "GET" ) $this->getArticles();
            elseif( $this->method === "POST" ) $this->postArticle($this->getPayload());

            else $this->getResponseHandler()->notAllowed($this->getDbManager());
        }
        /**
         * @Route("/api/article/:id" methods=["GET", "PATCH", "DELETE"])
         * @RouteType Admin
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
            // exit(print(json_encode(["file" => $_FILES, "payload"=>$payload, "post"=>$_POST])));
            // move_uploaded_file($_FILES["art_img"]["tmp_name"], "c://users/rain_/desktop/test.png");
            // exit();
            $type = $_FILES["art_img"]["type"];
            $file_name = $_FILES["art_img"]["name"];
            $file_tmp_name = $_FILES["art_img"]["tmp_name"];

            $payload = [
                "art_name"=>$_POST["art_name"],
                "art_cat_id"=>$_POST["art_cat_id"],
                "art_img"=>$_FILES["art_img"]["name"]
            ];

            if( !in_array($type, ["image/png", "image/jpg", "image.jpeg"])) $this->getResponseHandler()->badRequest(null, ["art_img"=>"File upload only supports png, jpg, jpeg"]);
            
            move_uploaded_file($file_tmp_name, env("FILE_UPLOAD")."/$file_name");

            $payload = BaseModel::checkPostPayload("gw_article", $payload, $this->getDbManager());

            $article = Article::create($payload, $this);

            $this->respond($article->asAssociativeArray(), 201);
        }

        private function getArticle(int $art_id){

            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());

        }

        private function updateArticle(int $art_id) {

            $payload = $this->getPayload();
            $update = BaseModel::checkPatchPayload("gw_article", $payload, $this->getDbManager());

            // nagaan of article met art_id bestaat.
            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            //indien art_cat_id meegegeven, nagaan of category met cat_id bestaat
            if( in_array("art_cat_id", array_keys($payload)) ){
                $cat_id = $payload["art_cat_id"];
                $this->getCategoryHandler()->getCategoryById($cat_id, $this->getDbManager());
            }
           
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