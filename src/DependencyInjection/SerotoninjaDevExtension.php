<?php

namespace Serotoninja\DevBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class SerotoninjaDevExtension
 *
 * @package Serotoninja\DevBundle\DependencyInjection
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-13
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class SerotoninjaDevExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config as $key => $value) {
            $container->setParameter($this->getAlias().'.'.$key, $value);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        # $loader->load('email.xml');
        $loader->load('makers.xml');
    }
}
