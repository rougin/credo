<?php

namespace Rougin\Credo\Helpers;

use Rougin\Credo\Credo;

/**
 * Instance Helper
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class InstanceHelper
{
    /**
     * @var \Rougin\Credo\Credo|null
     */
    protected static $credo = null;

    /**
     * Factory method to create the Credo instance.
     *
     * @param  \CI_DB_query_builder $builder
     * @return void
     */
    public static function create($builder)
    {
        empty(self::$credo) && self::$credo = new Credo($builder);
    }

    /**
     * Returns the Credo instance.
     *
     * @return \Rougin\Credo\Credo
     */
    public static function get()
    {
        return self::$credo;
    }
}
