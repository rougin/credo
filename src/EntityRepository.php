<?php

namespace Rougin\Credo;

use Rougin\Credo\Helpers\MethodHelper;
use Doctrine\ORM\EntityRepository as BaseRepository;

/**
 * Entity Repository
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EntityRepository extends BaseRepository
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
        return MethodHelper::call($this, $method, $parameters);
    }
}
