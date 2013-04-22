<?php
/**
 * @author Bram Gerritsen bgerritsen@gmail.com
 * @copyright (c) Bram Gerritsen 2013
 * @license http://opensource.org/licenses/mit-license.php
 */

namespace StrokerCache\Service;

use Zend\Cache\Pattern\CaptureCache;
use Zend\Mvc\MvcEvent;
use StrokerCache\Options\ModuleOptions;
use StrokerCache\Strategy\StrategyInterface;

class CacheService
{
    /**
     * @var CaptureCache
     */
    private $captureCache;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var array
     */
    protected $strategies = array();


    /**
     * Default constructor
     *
     * @param \Zend\Cache\Pattern\CaptureCache $captureCache
     * @param \StrokerCache\Options\ModuleOptions $options
     */
    public function __construct(CaptureCache $captureCache, ModuleOptions $options)
    {
        $this->setCaptureCache($captureCache);
        $this->setOptions($options);
    }

    /**
     * Save the page contents to the cache storage.
     */
    public function save(MvcEvent $e)
    {
        /** @var $strategy \StrokerCache\Strategy\StrategyInterface */
        foreach ($this->getStrategies() as $strategy) {
            if ($strategy->shouldCache($e)) {
                $content = $e->getResponse()->getContent();
                $this->getCaptureCache()->set($content);
            }
        }
    }

    /**
     * @param string $pattern
     * @return bool
     */
    public function clearByGlob($pattern)
    {
        try {
            $this->getCaptureCache()->clearByGlob($pattern);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getStrategies()
    {
        return $this->strategies;
    }

    /**
     * @param array $strategies
     */
    public function setStrategies($strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @param \StrokerCache\Strategy\StrategyInterface $strategy
     */
    public function addStrategy(StrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @return \Zend\Cache\Pattern\CaptureCache
     */
    public function getCaptureCache()
    {
        return $this->captureCache;
    }

    /**
     * @param \Zend\Cache\Pattern\CaptureCache $captureCache
     */
    public function setCaptureCache(CaptureCache $captureCache)
    {
        $this->captureCache = $captureCache;
    }

    /**
     * @return \StrokerCache\Options\ModuleOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param \StrokerCache\Options\ModuleOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
