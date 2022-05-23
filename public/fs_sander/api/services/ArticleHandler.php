<?php

use models\Article;
use services\DbManager;
use services\requests\Request;

    class ArticleHandler {

        public function getArticleById(int $art_id, DbManager $dbm): Article {

            $data = $dbm->getSQL("
                SELECT *
                FROM gw_article
                WHERE art_id = $art_id
            ")[0];

            if (!$data) {
                $dbm->closeConnection();
                $dbm->getResponseHandler()->notFound($dbm, ["art_id"=>"No article with id $art_id", "auc_art_id"=>"No article with id $art_id"]);
            }

            $article = new Article(
                $data["art_id"],
                $data["art_name"],
                $data["art_img"],
                $data["art_cat_id"]
            );

            return $article;
        }
    }

