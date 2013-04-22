<?php
/**
 * @author Bram Gerritsen bgerritsen@gmail.com
 * @copyright (c) Bram Gerritsen 2013
 * @license http://opensource.org/licenses/mit-license.php
 */

namespace StrokerCache\Listener;

use StrokerCache\Service\CacheService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Mvc\MvcEvent;

class CacheListener implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @var CacheService
     */
    protected $cacheService;

    /**
     * Default constructor
     *
     * @param CacheService $cacheService
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('finish', array($this, 'onFinish'), -100);
    }

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }


    /**
     * Save page contents to the cache
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function onFinish(MvcEvent $e)
    {
        if (!$e->getRequest() instanceof HttpRequest) {
            return;
        }

        $this->getCacheService()->save($e);
    }

    /**
     * @return CacheService
     */
    public function getCacheService()
    {
        return $this->cacheService;
    }
}
