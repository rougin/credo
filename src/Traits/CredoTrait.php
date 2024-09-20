<?php

namespace Rougin\Credo\Traits;

use Rougin\Credo\Credo;

/**
 * @method string table()
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
trait CredoTrait
{
    /**
     * @var \Rougin\Credo\Credo|null
     */
    protected $self = null;

    /**
     * Returns or sets the Credo instance.
     *
     * @param \Rougin\Credo\Credo|null $credo
     *
     * @return \Rougin\Credo\Credo
     */
    public function credo(Credo $credo = null)
    {
        if ($credo)
        {
            $this->self = $credo;
        }

        if (! $this->self)
        {
            $this->self = new Credo($this->db);
        }

        return $this->self;
    }

    /**
     * Finds the row from storage based on given identifier.
     *
     * @param integer      $id
     * @param integer|null $mode
     * @param integer|null $version
     *
     * @return object|null
     */
    public function find($id, $mode = null, $version = null)
    {
        return $this->credo()->find(get_class($this), $id, $mode, $version);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $order
     * @param integer|null               $limit
     * @param integer|null               $offset
     *
     * @return object[]
     */
    public function findBy($criteria = array(), $order = null, $limit = null, $offset = null)
    {
        return $this->credo()->findBy(get_class($this), $criteria, $order, $limit, $offset);
    }

    /**
     * Returns an array of rows from a specified table.
     *
     * @param integer|null               $limit
     * @param integer|null               $offset
     * @param array<string, string>|null $order
     *
     * @return object[]
     */
    public function get($limit = null, $offset = null, $order = null)
    {
        return $this->credo()->get(get_class($this), $limit, $offset, $order);
    }

    /**
     * Sets the "WHERE" criteria.
     *
     * @param mixed|string $key
     * @param mixed|null   $value
     *
     * @return self
     */
    public function where($key, $value = null)
    {
        $this->credo()->where($key, $value);

        return $this;
    }
}
