<?php
namespace Widget\PostBundle;

use Backend\BaseBundle\CM4\CM4WidgetInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Widget\PostBundle\Model;

class WidgetPostBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependencyInjection\Compiler\ResourceCompilerPass());
    }

    public function boot()
    {
        if(class_exists(Model\om\BasePost::class)){
            Model\Post::setContainer($this->container);
        }
    }

}
