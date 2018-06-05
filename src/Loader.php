<?php

namespace Rougin\Credo;

/**
 * Loader
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Loader extends \CI_Loader
{
    /**
     * Loads and instantiates Doctrine-based repositories.
     *
     * @param  string|array $repository
     * @return self
     */
    public function repository($repository)
    {
        $repositories = (array) $repository;

        $path = APPPATH . 'repositories/';

        foreach ($repositories as $repository) {
            $file = ucfirst($repository);

            $suffix = '_repository.php';

            require $path . $file . $suffix;
        }

        return $this;
    }
}
