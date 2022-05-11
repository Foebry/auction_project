<?php

use models\Article;
use models\Container;

    class ArticleHandler {

        public function getById(int $art_id, Container $container): Article {

            $data = $container->getDbManager()->getSQL("
                SELECT *
                FROM gw_article
                WHERE art_id = $art_id
            ")[0];

            if (!$data) {
                $container->getDbManager()->closeConnection();
                $container->getResponseHandler()->badRequest();
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

