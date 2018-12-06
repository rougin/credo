<?php

namespace Rougin\Credo;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityRepository;

/**
 * Entity Repository
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Repository extends EntityRepository
{
    /**
     * Calls methods from EntityRepository in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $instance = array($this, Inflector::camelize($method));

        return call_user_func_array($instance, $parameters);
    }
}
