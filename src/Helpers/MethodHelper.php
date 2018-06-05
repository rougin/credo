<?php

namespace Rougin\Credo\Helpers;

use Doctrine\Common\Util\Inflector;

/**
 * Method Helper
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MethodHelper
{
    /**
     * Calls methods from the specified object in underscore case.
     *
     * @param  object $object
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public static function call($object, $method, $parameters)
    {
        $method = Inflector::camelize((string) $method);

        $instance = (array) array($object, (string) $method);

        return call_user_func_array($instance, $parameters);
    }
}
