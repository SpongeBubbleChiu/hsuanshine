<?php
namespace Widget\PostBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ResourceCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $templatingEngines = $container->getParameter('templating.engines');

        if (in_array('twig', $templatingEngines)) {
            $container->setParameter(
                'twig.form.resources',
                array_merge(
                    array(
                        'WidgetPostBundle:Form:_formTheme.html.twig',
                    ),
                    $container->getParameter('twig.form.resources')
                )
            );
        }
    }
}