<?php
/**
 * Created by PhpStorm.
 * User: bubble
 * Date: 2018/12/25
 * Time: 下午12:08
 */

namespace Widget\ArticleBundle\Controller\API;


use Backend\BaseBundle\Controller\API\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Widget\ArticleBundle\Model\Article;

/**
 * @Route("/article")
 */
class ArticleController extends BaseController
{
    /**
     * @Route("/{type}")
     * @Method({"GET"})
     */
    public function getArticleAction(Request $request, Article $article)
    {
        return $this->createJsonSerializeResponse($article, array('f_detail'));
    }
}