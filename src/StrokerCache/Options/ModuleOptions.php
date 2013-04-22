<?php
/**
 * @author Bram Gerritsen bgerritsen@gmail.com
 * @copyright (c) Bram Gerritsen 2013
 * @license http://opensource.org/licenses/mit-license.php
 */

namespace StrokerCache\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    private $strategies;

    /**
     * @var array
     */
    private $captureOptions;

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
    public function setStrategies(array $strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @return array
     */
    public function getCaptureOptions()
    {
        return $this->captureOptions;
    }

    /**
     * @param array $captureOptions
     */
    public function setCaptureOptions(array $captureOptions)
    {
        $this->captureOptions = $captureOptions;
    }
}
