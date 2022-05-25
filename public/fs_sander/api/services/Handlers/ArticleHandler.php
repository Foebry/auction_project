<?php

    namespace services\handlers;

    use models\Article;
    use services\DbManager;

    class ArticleHandler {

        public function getArticleById(int $art_id, DbManager $dbm): Article {

            $data = $dbm->getSQL("
                SELECT *
                FROM gw_article
                WHERE art_id = $art_id
            ");

            if (!$data) {
                $dbm->closeConnection();
                $dbm->getResponseHandler()->notFound($dbm, ["art_id"=>"No article with id $art_id", "auc_art_id"=>"No article with id $art_id"]);
            }

            $article = new Article($data[0]);

            return $article;
        }
    }

