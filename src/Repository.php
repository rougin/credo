<?php

namespace Rougin\Credo;

use Doctrine\ORM\EntityRepository;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\ORM\EntityRepository<TEntityClass>
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Repository extends EntityRepository
{
    /**
     * Calls methods from EntityRepository in underscore case.
     *
     * @param string  $method
     * @param mixed[] $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        // Camelize the method name -----------------
        $words = ucwords(strtr($method, '_-', '  '));

        $search = array(' ', '_', '-');

        $method = str_replace($search, '', $words);

        $method = lcfirst((string) $method);
        // ------------------------------------------

        /** @var callable */
        $class = array($this, $method);

        return call_user_func_array($class, $params);
    }
}
