<?php
namespace Widget\PostBundle\Tests\Form;

use Backend\BaseBundle\Tests\Fixture\BaseKernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Widget\PhotoBundle\Image\Resizer;
use Widget\PhotoBundle\Model\Photo;
use Widget\PhotoBundle\Model\PhotoConfig;
use Widget\PostBundle\Form\Transformer\PostPhotoTransformer;

/**
 * @group unit
 */
class PostPhotoTransformerTest extends BaseKernelTestCase
{

    public function test_createTempPhotoFile()
    {
        //arrange
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods()
            ->getMock();

        $imagePath = realpath(__DIR__.'/../Fixture/image.jpg');
        $resizer = $this->getMockBuilder(Resizer::class)
            ->setMethods(array('generateUid'))
            ->disableOriginalConstructor()
            ->getMock();
        $resizer
            ->expects($this->once())
            ->method('generateUid')
            ->willReturn('some_uid');
        $photoConfig = new PhotoConfig();
        $this->setObjectAttribute($transformer, 'resizer', $resizer);
        $this->setObjectAttribute($transformer, 'photoConfig', $photoConfig);

        //act
        $file = $this->callObjectMethod($transformer, 'createTempPhotoFile', file_get_contents($imagePath));

        //assert
        $this->assertFileEquals($imagePath, $file->getPathname());
        unlink($file->getPathname());
    }

    public function test_removeFile()
    {
        //arrange
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods()
            ->getMock();
        $pathname = tempnam(sys_get_temp_dir(), 'test_tmp_file_');
        $fileSystem = new Filesystem();
        $fileSystem->touch($pathname);
        $file = new File($pathname);

        //act
        $this->callObjectMethod($transformer, 'removeFile', $file);

        //assert
        $this->assertFalse($file->isFile());
    }

    public function test_reverseTransform_no_img()
    {
        //arrange
        $html = '<div><a href="http://example.com/">test</a></div>';
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods(array('filterImg'))
            ->getMock();
        $transformer
            ->expects($this->never())
            ->method('filterImg')
            ->willReturnCallback(function(){
            });

        //act
        $result = $transformer->reverseTransform($html);

        //assert
        $this->assertEquals($html, $result);
    }

    public function test_reverseTransform_no_inline_img()
    {
        //arrange
        $imgTag = '<img class="some-class" src="some_pic" /><img src="some_pic" />';
        $resultImgTag = '';
        $html = '<div><a href="http://example.com/">'.$imgTag.'</a></div>';
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods(array('filterImg'))
            ->getMock();
        $transformer
            ->expects($this->atLeastOnce())
            ->method('filterImg')
            ->willReturnCallback(function($imgTag) use(&$resultImgTag){
                $resultImgTag .= $imgTag;
                return null;
            });

        //act
        $result = $transformer->reverseTransform($html);

        //assert
        $this->assertEquals($html, $result);
        $this->assertEquals($imgTag, $resultImgTag);
    }

    public function test_reverseTransform_inline_img()
    {
        //arrange
        $html = '<div><a href="http://example.com/"><img class="some-class" src="some_pic" /></a></div>';
        $resulthtml = '<div><a href="http://example.com/"><template data-type="img" data-uid="123" data-suffix="large" data-ext="jpg" /></a></div>';
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods(array('filterImg'))
            ->getMock();
        $transformer
            ->expects($this->atLeastOnce())
            ->method('filterImg')
            ->willReturnCallback(function($imgTag) {
                $photo = new Photo();
                return $photo
                    ->setUid('123')
                    ->setInfo(array(
                        'large' => array(
                            'suffix' => 'large',
                            'ext' => 'jpg',
                            'filesize' => 12345,
                        ),
                    ))
                    ;
            });

        //act
        $result = $transformer->reverseTransform($html);

        //assert
        $this->assertEquals($resulthtml, $result);
    }

    public function test_transform_no_template()
    {
        //arrange
        $html = '<div><a href="http://example.com/">test</a></div>';
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods(array('renderImg'))
            ->getMock();
        $transformer
            ->expects($this->never())
            ->method('renderImg')
            ->willReturn(null);

        //act
        $result = $transformer->transform($html);

        //assert
        $this->assertEquals($html, $result);
    }

    public function test_transform_template()
    {
        //arrange
        $templates = '<template data-type="img" data-uid="123" /><template data-type="img" data-uid="456" />';
        $resultTemplates = '';
        $html = '<div><a href="http://example.com/">'.$templates.'</a></div>';
        $resultHtml = '<div><a href="http://example.com/"><img class="img-responsive" src="/photo/path/test.jpg" /><img class="img-responsive" src="/photo/path/test.jpg" /></a></div>';
        $transformer = $this->getMockBuilder(PostPhotoTransformer::class)
            ->setMethods(array('renderImg'))
            ->getMock();
        $transformer
            ->expects($this->atLeastOnce())
            ->method('renderImg')
            ->willReturnCallback(function($template) use(&$resultTemplates){
                $resultTemplates.=$template;
                return '/photo/path/test.jpg';
            });

        //act
        $result = $transformer->transform($html);

        //assert
        $this->assertEquals($resultHtml, $result);
    }
}