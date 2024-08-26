<?php

namespace Rougin\Credo;

/**
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Loader extends \CI_Loader
{
    /**
     * Loads and instantiates Doctrine-based repositories.
     *
     * @param string|string[] $name
     *
     * @return self
     */
    public function repository($name)
    {
        $items = (array) $name;

        $path = APPPATH . 'repositories/';

        foreach ($items as $item)
        {
            require $path . ucfirst($item) . '_repository.php';
        }

        return $this;
    }
}
