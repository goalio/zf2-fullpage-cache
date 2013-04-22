<?php
/**
 * @author Bram Gerritsen bgerritsen@gmail.com
 * @copyright (c) Bram Gerritsen 2013
 * @license http://opensource.org/licenses/mit-license.php
 */

namespace StrokerCache\Factory;

use Zend\Cache\PatternFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CaptureCaheFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \StrokerCache\Options\ModuleOptions */
        $options = $serviceLocator->get('StrokerCache\Options\ModuleOptions');
        $captureOptions = array('capture' => $options->getCaptureOptions());

        return PatternFactory::factory('capture', $captureOptions);

    }
}
