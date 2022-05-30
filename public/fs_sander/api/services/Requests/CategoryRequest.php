<?php

    namespace services\requests;

    use models\BaseModel;
    use models\Category;

    class CategoryRequest extends Request {
        
        public function __construct()
        {
            parent::__construct();
            $this->resolveEndpoint();
        }

        private function resolveEndpoint(): void {

            $uri = $this->getUri();

            if( $uri === "/api/categories" ) $this->resolveCategories( AdminRoute( $this ) );

            elseif( preg_match("|api/category/[0-9]+$|", $uri) ){
                
                $cat_id = explode("/", $uri)[3];
                $this->resolveCategory($cat_id, AdminRoute( $this ));
            }
            else $this->getResponseHandler()->notFound();
        }

        /**
         * @Route("/api/categories", methods=["GET", "POST"])
         * @RouteType admin
         */
        private function resolveCategories(): void {

            if( $this->method === "GET" ) $this->getCategories();
            elseif( $this->method === "POST" ) $this->postCategory($this->getPayload());

            else $this->getResponseHandler()->notAllowed();
        }
        /**
         * @Route("/api/category/:id", methods=["GET", "PATCH", "DELETE"])
         * @RouteType admin
         */
        private function resolveCategory(int $cat_id): void {

            if( $this->getMethod() === "GET" ) $this->getCategory($cat_id);
            elseif( $this->getMethod() === "PATCH" ) $this->updateCategory($cat_id);
            elseif( $this->getMethod() === "DELETE" ) $this->deleteCategory($cat_id);

            else $this->getResponseHandler()->notAllowed();
        }

        private function getCategories(): void {

            $data = $this->getDbManager()->getSQL("SELECT * from gw_category");

            $this->respond($data);
        }

        private function postCategory(array $payload): void {

            validateCsrf($payload, $this);

            $payload = BaseModel::checkPostPayload("gw_category", $payload, $this->getDbManager());

            $category = Category::create($payload, $this);

            $this->respond($category->asAssociativeArray(), 201);
        }

        private function getCategory(int $cat_id): void {
            
            $category = $this->getCategoryHandler()->getCategoryById($cat_id, $this->getDbManager());

            $this->respond($category->asAssociativeArray());
        }

        private function updateCategory(int $cat_id): void {

            $payload = $this->getPayload();

            validateCsrf($payload, $this);

            $update = BaseModel::checkPatchPayload("gw_category", $payload, $this);

            $category = $this->getCategoryHandler()->getCategoryById($cat_id, $this->getDbManager());

            $this->getDbManager()->getSQL("UPDATE gw_category set $update where cat_id=$cat_id");

            $category = $this->getCategoryHandler()->getCategoryById($cat_id, $this->getDbManager());

            $this->respond($category->asAssociativeArray());
            
        }

        private function deleteCategory(int $cat_id): void {

            $payload = $this->getPayload();

            validateCsrf($payload, $this);

            $this->getCategoryHandler()->getCategoryById($cat_id, $this->getDbManager());
            $this->getDbManager()->getSQL("DELETE from gw_category where cat_id = $cat_id");

            $this->respond([], 204);
        }
    }