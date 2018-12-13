<?php
namespace Backend\BaseBundle\Form\Type;

use Backend\BaseBundle\Form\Transform\ModelBooleanTransformer;
use Backend\BaseBundle\Form\Transform\ViewBooleanTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ModelBooleanTransformer());
    }
}