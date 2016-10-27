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
        return \Rougin\Credo\Helpers\MagicMethodHelper::call($this, $method, $parameters);
    }
}
