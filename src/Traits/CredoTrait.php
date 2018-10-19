<?php

namespace Rougin\Credo\Traits;

use Rougin\Credo\Credo;

/**
 * Credo Trait
 *
 * @method string table()
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
trait CredoTrait
{
    /**
     * @var \Rougin\Credo\Credo
     */
    protected $credo;

    /**
     * Sets the Credo instance.
     *
     * @param  \Rougin\Credo\Credo $credo
     * @return self
     */
    public function credo(Credo $credo)
    {
        $this->credo = $credo;

        return $this;
    }

    /**
     * Finds the row from storage based on given identifier.
     *
     * @param  mixed        $id
     * @param  integer|null $mode
     * @param  integer|null $version
     * @return mixed
     */
    public function find($id, $mode = null, $version = null)
    {
        return $this->credo->find(get_class($this), $id, $mode, $version);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param  array        $criteria
     * @param  integer|null $limit
     * @param  integer|null $offset
     * @param  array|null   $order
     * @return array
     */
    public function findBy(array $criteria = array(), $limit = null, $offset = null, array $order = null)
    {
        return $this->credo->findBy(get_class($this), $criteria, $limit, $offset, $order);
    }

    /**
     * Returns an array of rows from a specified table.
     *
     * @param  string       $table
     * @param  integer|null $limit
     * @param  integer|null $offset
     * @param  array|null   $order
     * @return mixed
     */
    public function get($limit = null, $offset = null, array $order = null)
    {
        return $this->credo->get(get_class($this), $limit, $offset, $order);
    }

    /**
     * Sets the "WHERE" criteria.
     *
     * @param  array|string $key
     * @param  mixed|null   $value
     * @return self
     */
    public function where($key, $value = null)
    {
        $this->credo->where($key, $value);

        return $this;
    }
}
