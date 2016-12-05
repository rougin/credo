<?php

namespace Rougin\Credo\Helpers;

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
     * Factory method to create Credo instance.
     *
     * @param  \CI_DB_query_builder $database
     * @return void
     */
    public static function create($database)
    {
        if (empty(self::$credo)) {
            self::$credo = new \Rougin\Credo\Credo($database);
        }
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
