<?php
/**
 * Created by PhpStorm.
 * User: bubble
 * Date: 2019/1/2
 * Time: 上午11:25
 */

namespace Widget\ArticleBundle\Controller\BackendAPI;


use Backend\BaseBundle\Controller\BackendAPI\BaseBackendAPIController;
use Backend\BaseBundle\Form\Type\APIFormTypeItem;
use Backend\BaseBundle\Propel\I18n;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Widget\ArticleBundle\Model\Article;
use Widget\ArticleBundle\Model\ArticlePeer;
use Widget\ArticleBundle\Model\ArticleQuery;

class ArticleController extends BaseBackendAPIController
{

    /**
     * @return APIFormTypeItem[]
     */
    protected function getFormConfig()
    {
        return array(
            (new APIFormTypeItem('type'))->setOptions(array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'error.missing_field',
                    )),
                    new Assert\Regex(array(
                        'pattern' => '/^[0-9a-z]+$/',
                        'message' => 'error.article.type.format_incorrect_field'
                    )),
                    new Assert\Callback(function($value, ExecutionContextInterface $context){
                        $object = $context->getRoot()->getData();
                        $article = ArticleQuery::create()
                            ->filterByType($value)
                            ->findOne();
                        if($article && $article->getId() != $object->getId()){
                            $context->addViolation('error.article.type.duplicate');
                        }
                    })
                )
            )),
            (new APIFormTypeItem('title'))->setOptions(array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'error.article.title.missing_field',
                    )),
                )
            )),
            (new APIFormTypeItem('brief'))->setOptions(array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'error.article.brief.missing_field',
                    )),
                )
            )),
            (new APIFormTypeItem('content'))->setOptions(array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'error.article.content.missing_field',
                    )),
                ),
            )),
        );
    }

    /**
     * @Route("s")
     * @Method({"POST"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_WRITE')")
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        if ($article instanceof I18n){
            $locale = $request->query->get('_locale');
            $article->setLocale($locale);
        }
        return $this->doProcessForm($article, $request->getContent());
    }

    /**
     * @Route("s")
     * @Method({"GET"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_READ')")
     */
    public function searchAction(Request $request)
    {
        $query = ArticleQuery::create();
        if ($query instanceof I18n){
            $locale = $request->query->get('_locale');
            $query->joinArticleI18n($locale);
        }
        return $this->doSearch($request->query->all(), $query->distinct(), ArticlePeer::class);
    }

    /**
     * @Route("/{id}")
     * @Method({"GET"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_READ')")
     */
    public function readAction(Request $request, Article $article)
    {
        if ($article instanceof I18n){
            $locale = $request->query->get('_locale');
            $article->setLocale($locale);
        }
        return $this->createJsonSerializeResponse($article, array('detail'));
    }

    /**
     * @Route("/{id}")
     * @Method({"PUT"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_WRITE')")
     */
    public function updateAction(Request $request, Article $article)
    {
        if ($article instanceof I18n){
            $locale = $request->query->get('_locale');
            $article->setLocale($locale);
        }
        return $this->doProcessForm($article, $request->getContent());
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_WRITE')")
     */
    public function deleteAction(Article $article)
    {
        $this->deleteObject($article);
        return $this->createJsonResponse();
    }

    /**
     * @Route("s")
     * @Method({"PUT"})
     * @Security("has_role_or_superadmin('ROLE_ARTICLE_WRITE')")
     */
    public function batchAction(Request $request)
    {
        return parent::batchAction($request);
    }

    /**
     * @param $ids
     * @param $column
     * @param \PropelPDO $con
     * @return \Symfony\Component\HttpFoundation\JsonResponse|void
     * @throws \PropelException
     */
    protected function batchSwitch($ids, $column, \PropelPDO $con)
    {
        $articles = ArticleQuery::create()->findPks($ids, $con);
        foreach ($articles as $article) {
            $value = $article->getByName($column, \BasePeer::TYPE_FIELDNAME);
            $article->setByName($column, !$value, \BasePeer::TYPE_FIELDNAME);
            $article->save($con);
        }
    }

    /**
     * @param $ids
     * @param \PropelPDO $con
     * @return \Symfony\Component\HttpFoundation\JsonResponse|void
     * @throws \PropelException
     */
    protected function batchDelete($ids, \PropelPDO $con)
    {
        ArticleQuery::create()->findPks($ids, $con)->delete($con);
    }
}