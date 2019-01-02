<?php
namespace Widget\PostBundle\Form\Type;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Widget\PostBundle\Form\Transformer\PostPhotoTransformer;

/**
 * @Service
 * @Tag("form.type", attributes = {"alias": "rich_text"})
 */
class RichTextType extends AbstractType
{
    /** @var PostPhotoTransformer  */
    protected $postPhotoTransformer;

    /**
     * @InjectParams({
     *     "postPhotoTransformer" = @Inject("widget_post.post_photo_transformer"),
     * })
     */
    public function injectPhotoTransformer(PostPhotoTransformer $postPhotoTransformer)
    {
        $this->postPhotoTransformer = $postPhotoTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this->postPhotoTransformer);
    }

    public function getParent()
    {
        return BaseType\TextareaType::class;
    }

}