<?php

namespace Rougin\Credo;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;

/**
 * Entity Repository
 * 
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EntityRepository extends BaseEntityRepository
{
    /**
     * Calls methods from EntityRepository in underscore case.
     * 
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters) {
        $method = Inflector::camelize($method);

        if (method_exists($this, $method)) {
            $class = [$this, $method];
            
            return call_user_func_array($class, $parameters);
        }

        return $this;
    }
}
