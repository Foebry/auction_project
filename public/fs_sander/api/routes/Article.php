<?php

  use models\Container;
  use models\Article;
  use models\Response;

    function getArticles(Container $container): Response {

      $articles = $container->getDbManager()->getSQL("Select * from gw_article");

      $container->getDbManager()->closeConnection();

      return new Response($articles, 200);
    }

    function postArticle() {
        print("POST article logic");
      /**
       * @todo Create Insert Article
       */
    }

    function getArticleDetail() {
        print("GET article detail logic");
      /**
       * @todo Create Select ArticleDetail
       */
    }

    function updateArticle() {
        print("PUT article detail logic");
      /**
       * @todo Create Update Article
       */
    }

    function patchArticle($articleId) {
        print("PATCH article detail logic");
      /**
       * @todo Create ??? ArticleDetail
       */
    }