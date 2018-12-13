<?php
namespace Backend\BaseBundle\Tests\Form\Type;


use Backend\BaseBundle\Form\Type\BooleanType;
use Backend\BaseBundle\Tests\Fixture\BaseKernelTestCase;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class BooleanTypeTest extends BaseKernelTestCase
{
    /**
     * @dataProvider dataProvider_test_form
     */
    public function test_form($modelData, $formData, $result)
    {
        //arrange
        $object = new \stdClass();
        $object->col1 = $modelData;

        $data = array(
            'col1' => $formData
        );

        $form = $this->container->get('form.factory')->createBuilder(FormType::class, $object, array('csrf_protection' => false))
            ->add('col1', BooleanType::class, array(
                'constraints' => array(
                    new Choice(array(
                        'multiple' => false,
                        'choices' => array(true, false),
                    ))
                ),
            ))
            ->getForm()
        ;

        //act
        $form->submit($data);

        //assert
        $this->assertTrue($form->isValid());
        $this->assertEquals($result, $object->col1);
    }

    public function dataProvider_test_form()
    {
        return array(
            array(
                'modelData' => null,
                'formData' => null,
                'result' => false,
            ),
            array(
                'modelData' => true,
                'formData' => null,
                'result' => false,
            ),
            array(
                'modelData' => false,
                'formData' => null,
                'result' => false,
            ),
            array(
                'modelData' => null,
                'formData' => null,
                'result' => false,
            ),
            array(
                'modelData' => null,
                'formData' => false,
                'result' => false,
            ),
            array(
                'modelData' => null,
                'formData' => true,
                'result' => true,
            ),
            array(
                'modelData' => true,
                'formData' => null,
                'result' => false,
            ),
            array(
                'modelData' => true,
                'formData' => false,
                'result' => false,
            ),
            array(
                'modelData' => true,
                'formData' => true,
                'result' => true,
            ),
        );
    }
}
