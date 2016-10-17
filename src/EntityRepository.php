<?php

namespace Rougin\Credo;

/**
 * Entity Repository
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EntityRepository extends \Doctrine\ORM\EntityRepository
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
        $method = \Doctrine\Common\Util\Inflector::camelize($method);
        $result = $this;

        if (method_exists($this, $method)) {
            $class = [ $this, $method ];
            
            $result = call_user_func_array($class, $parameters);
        }

        return $result;
    }
}
