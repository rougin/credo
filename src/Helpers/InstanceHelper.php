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
     * @var \Rougin\Credo\Credo
     */
    protected static $credo;

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
        if (! empty(self::$credo)) {
            return self::$credo;
        }

        return null;
    }
}
