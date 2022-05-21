<?php

  use models\Container;
  use models\Article;
  use models\Response;

    function getArticles(Container $container): Response {

      $articles = $container->getDbManager()->getSQL("Select * from gw_article");

      $container->getDbManager()->closeConnection();

      return new Response($articles, 200);
    }

    function postArticle( string $payload, Container $container ): Response {

      $payload = json_decode($payload, true);

      checkPayloadPOST(["art_name", "art_img", "art_cat_id"], $payload, $container);
      $container->getCategoryHandler()->getCategoryById($payload["art_cat_id"], $container);

      $article = new Article(null, $payload["art_name"], $payload["art_img"], $payload["art_cat_id"]);

      $art_id = $container->getDbManager()->insertSQL(
        sprintf(
          "INSERT into gw_article(art_name, art_img, art_cat_id) values('%s', '%s', %d)",
          $article->getArtName(),
          $article->getArtImg(),
          $article->getArtCatId()
        )
      );

      $article->setArtId($art_id);
      $container->getDbManager()->closeConnection();

      return new Response($article->asAssociativeArray(), 201);
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