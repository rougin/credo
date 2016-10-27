<?php

namespace Rougin\Credo\Helpers;

/**
 * Magic Method Helper
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MagicMethodHelper
{
    /**
     * Calls methods from the specified object in underscore case.
     *
     * @param  object      $object
     * @param  string      $method
     * @param  mixed       $parameters
     * @param  object|null $anotherObject
     * @return mixed
     */
    public static function call($object, $method, $parameters, $anotherObject = null)
    {
        $method = \Doctrine\Common\Util\Inflector::camelize($method);
        $result = $object;

        if (is_null($anotherObject)) {
            $anotherObject = $object;
        }

        if (method_exists($anotherObject, $method)) {
            $result = call_user_func_array([ $anotherObject, $method ], $parameters);
        }

        return $result;
    }
}
