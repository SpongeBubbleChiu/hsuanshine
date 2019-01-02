<?php
namespace Widget\PostBundle\Form\Transformer;

use Backend\BaseBundle\Model\SiteQuery;
use Backend\BaseBundle\Service\RequestSiteFinder;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Widget\PhotoBundle\File\PhotoUploadFile;
use Widget\PhotoBundle\Image\Resizer;
use Widget\PhotoBundle\Image\Resolver;
use Widget\PhotoBundle\Model;

/**
 * @Service("widget_post.post_photo_transformer")
 */
class PostPhotoTransformer implements DataTransformerInterface
{
    /** @var  Resizer */
    protected $resizer;

    /** @var  Resolver */
    protected $resolver;

    /** @var  AssetsHelper */
    protected $helper;

    /** @var  Model\PhotoConfig */
    protected $photoConfig;

    /**
     * @InjectParams({
     *    "helper" = @Inject("templating.helper.assets"),
     * })
     */
    public function injectAssetsHelper(AssetsHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @InjectParams({
     *    "resolver" = @Inject("widget_photo.image.resolver"),
     * })
     */
    public function injectResolver(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @InjectParams({
     *     "resizer" = @Inject("widget_photo.image.resizer"),
     * })
     */
    public function injectResizer(Resizer $resizer)
    {
        $this->resizer = $resizer;
    }

    /**
     * @InjectParams({
     *     "config" = @Inject("%widget_post_photo_config%"),
     * })
     */
    public function injectConfig($config)
    {
        $this->photoConfig = new Model\PhotoConfig();
        $this->photoConfig->setConfig($config);
    }

    protected function prepareDefaultPhotoConfig()
    {
        $photoConfig = Model\PhotoConfigQuery::create()
            ->filterByName('defualt-post-photo')
            ->findOne();
        if($photoConfig){
            $this->photoConfig = $photoConfig;
        }
    }
    public function transform($value)
    {
        if(!preg_match_all('/(<template data-type="img".*?\/?>)/i', $value, $matchall)){
            return $value;
        }

        foreach($matchall[0] as $node){
            if($photoPath = $this->renderImg($node)) {
                $value = str_replace($node, '<img class="img-responsive" src="'.$photoPath.'" />', $value);
            }
        }
        return $value;
    }

    public function reverseTransform($value)
    {
        if(!preg_match_all('/<img.*?\/?>/i', $value, $matchall)){
            return $value;
        }

        $this->prepareDefaultPhotoConfig();

        foreach($matchall[0] as $node) {
            if($photo = $this->filterImg($node)){
                $value = str_replace($node, '<template data-type="img" data-uid="'.$photo->getUid().'" data-suffix="'.$photo->getInfo()['large']['suffix'].'" data-ext="'.$photo->getInfo()['large']['ext'].'" />', $value);
            }
        }
        return $value;
    }


    protected function renderImg($node)
    {
        $crawler = new Crawler($node);
        if($uid = $crawler->filter('template')->attr('data-uid')) {
            $suffix = $crawler->filter('template')->attr('data-suffix');
            $ext = $crawler->filter('template')->attr('data-ext');
            return $this->helper->getUrl($this->resolver->resolveWebPathFromUid($uid, $suffix, $ext), 'photo');
        }
        return null;
    }

    /**
     * @param $node
     * @return null|Model\Photo
     * @throws \Exception
     * @throws \PropelException
     */
    protected function filterImg($node)
    {
        $crawler = new Crawler($node);

        if(!preg_match('/^data:(.*?);(.*),(.*)/i', $crawler->filter('img')->attr('src'), $match)){
            return null;
        }
        $uploadPhotoFile = $this->createTempPhotoFile(base64_decode($match[3]));
        $photo = $uploadPhotoFile->makePhoto();
        $photo->save();
        $this->removeFile($uploadPhotoFile);
        return $photo;
    }

    /**
     * @param $photoContent
     * @return PhotoUploadFile
     */
    protected function createTempPhotoFile($photoContent)
    {
        $file = new File(tempnam(sys_get_temp_dir(), 'widget_post_photo'));
        $file->openFile('w')->fwrite($photoContent);
        $uploadPhotoFile = PhotoUploadFile::createFromUploadFile($file, $this->resizer, $this->photoConfig);
        return $uploadPhotoFile;
    }

    protected function removeFile(File $file)
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove($file);
    }
}