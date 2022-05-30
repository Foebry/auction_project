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
            
            if( preg_match("|api/articles\??.*|", $uri) ) $this->resolveArticles( AdminRoute( $this ) );

            elseif( preg_match("|api/article/[0-9]+$|", $uri)) {
                $art_id = explode("/", $uri)[3];
                $this->resolveArticle($art_id, AdminRoute( $this ));
            }
            elseif( $uri === "/api/upload") $this->uploadFile( AdminRoute( $this ) );

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

            $baseQuery = "Select * from gw_article\n";

            [$query, $total, $total_pages, $page, $next_page, $prev_page, $page_count, $start, $end] = createQuery($baseQuery, $this, "articles", [], 20);

            $articles = $this->getDbManager()->getSQL($query);

            $this->respond([
                "page"=>$page,
                "total"=>$total,
                "nextPage"=>$next_page,
                "prevPage"=>$prev_page,
                "start"=>$start,
                "end"=>$end,
                "articles"=>$articles
            ]);

            // $data = $this->getDbManager()->getSQL(
            //     "SELECT * from gw_article"
            // );

            // $this->respond($data);
        }

        private function postArticle(array $payload){
            
            $payload = BaseModel::checkPostPayload("gw_article", $payload, $this->getDbManager());

            $article = Article::create($payload, $this);

            $this->respond($article->asAssociativeArray(), 201, false, "http://localhost:3000/admin/articles");
        }

        private function getArticle(int $art_id){

            $article = $this->getArticleHandler()->getArticleById($art_id, $this->getDbManager());

            $this->respond($article->asAssociativeArray());

        }

        private function updateArticle(int $art_id) {

            $payload = $this->getPayload();
            $update = BaseModel::checkPatchPayload("gw_article", $payload, $this);

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

        private function uploadFile() {

            if( $this->getMethod() !== "POST" ) $this->getResponseHandler()->notAllowed();

            $type = $_FILES["image"]["type"];
            $file_name = $_FILES["image"]["name"];
            $file_tmp_name = $_FILES["image"]["tmp_name"];

            if( !in_array($type, ["image/png", "image/jpg", "image/jpeg"])) $this->getResponseHandler()->badRequest(null, ["art_img"=>"File upload only supports png, jpg, jpeg"]);

            //upload locally
            move_uploaded_file($file_tmp_name, env("FILE_UPLOAD")."/$file_name");

            //upload filezilla
            // $ftp_connection = ftp_connect(env("FTPHOST")) or $this->getResponseHandler()->internalServerError($this->getDbManager(), ["message"=>"failed to connect to ftp server"], false, "http://localhost:3000/admin/articles");
            // ftp_login($ftp_connection, env("FTPUSER"), env("FTPPASSWORD")) or $this->getResponseHandler()->internalServerError($this->getDbManager(), ["message"=>"failed to login to ftp server"], false, "http://localhost:3000/admin/articles");

            // $files_on_server = ftp_nlist($ftp_connection, env("FTPDIR"));

            // move_uploaded_file($file_tmp_name, env("FILEFOLDER")."/$file_name") or $this->getResponseHandler()->internalServerError($this->getDbManager(), ["message"=>"File not found"], false, "http://localhost:3000/admin/articles");

            // if(in_array($file_name, $files_on_server)) $this->getResponseHandler()->internalServerError($this->getDbManager(), ["art_name"=>"Filename already exists"], false, "http://localhost:3000/admin/articles");
            // if(!ftp_put($ftp_connection, env("FTPDIR")."/$file_name", env("FILEFOLDER")."/$file_name")) $this->getResponseHandler()->internalServerError($this->getDbManager(), ["message"=>"Failed to upload file"], false, "http://localhost:3000/admin/articles");
        }
    }