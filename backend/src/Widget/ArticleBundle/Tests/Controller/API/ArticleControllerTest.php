<?php
namespace Widget\ArticleBundle\Tests\Controller\API;

use Backend\BaseBundle\Tests\Fixture\BaseWebTestCase;
use Widget\ArticleBundle\Model\Article;

class ArticleControllerTest extends BaseWebTestCase
{
    public function test_getArticleAction_bad_type()
    {
        //arrange
        //act
        $this->client->request(
            "GET",
            $this->generateUrl('widget_article_api_article_getarticle', array('type' => 'jdksjlfs'))
        );
        $response = $this->client->getResponse();
        //assert
        $this->assertFalse($response->isOk());
    }

    public function test_getArticleAction()
    {
        //arrange
        $article = new Article();
        $article
            ->setType('test_article')
            ->setTitle('test_title')
            ->setContent('test_content')
            ->save();
        //act
        $this->client->request(
            "GET",
            $this->generateUrl('widget_article_api_article_getarticle', array('type' => $article->getType()))
        );
        $response = $this->client->getResponse();
        $result = json_decode($response->getContent(), true);
        //reset
        $article->reload(true);
        $article->delete();
        //assert
        $this->assertTrue($response->isOk());
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('title', $result);
        $this->assertArrayHasKey('brief', $result);
        $this->assertArrayHasKey('content', $result);
        $this->assertArrayHasKey('created_at', $result);
        $this->assertArrayHasKey('updated_at', $result);
    }
}