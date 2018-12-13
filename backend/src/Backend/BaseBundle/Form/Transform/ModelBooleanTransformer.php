<?php
namespace Backend\BaseBundle\Form\Transform;

use Symfony\Component\Form\DataTransformerInterface;

class ModelBooleanTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return (bool) $value;
    }

    public function reverseTransform($value)
    {
        return (bool) $value;
    }
}
