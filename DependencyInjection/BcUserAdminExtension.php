<?php
/**
 * This file is part of braincrafted/user-admin-bundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * BcUserExtension
 *
 * @package    braincrafted/user-admin-bundle
 * @subpackage DependencyInjection
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class BcUserAdminExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('services') as $basename) {
            $loader->load(sprintf('%s.yml', $basename));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        // Configure AsseticBundle
        if (isset($bundles['AsseticBundle'])) {
            $this->configureAsseticBundle($container);
        }
    }

    /**
     * Configures AsseticBundle.
     *
     * @param ContainerBuilder $container The service container
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    private function configureAsseticBundle(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'assetic':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'assets'    => $this->buildAsseticConfig($config)
                        )
                    );
                    break;
            }
        }
    }

    /**
     * Builds the configuration for AsseticBundle.
     *
     * @param array $config The BcUserAdmin configuration
     *
     * @return array The configuration for AsseticBundle
     */
    private function buildAsseticConfig(array $config)
    {
        $output = array(
            'bc_user_admin_css' => array(
                'inputs'    => array(
                    __DIR__.'/../Resources/sass/user-admin.scss'
                ),
                'filters'   => array('cssrewrite'),
                'output'    => $config['assets']['output_dir'].'/css/user-admin.css'
            )
        );

        return $output;
    }
}
