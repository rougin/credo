<?php

namespace Rougin\Credo;

use Rougin\Credo\Helpers\InstanceHelper;
use Rougin\Credo\Helpers\MethodHelper;

/**
 * Model
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 *
 * @property \CI_DB_query_builder $db
 */
class Model extends \CI_Model
{
    /**
     * @var array
     */
    protected $criteria = array();

    /**
     * Initializes the model instance.
     */
    public function __construct()
    {
        InstanceHelper::create($this->db);
    }

    /**
     * Returns all of the models from the database.
     *
     * @return array
     */
    public function all()
    {
        return $this->findBy(array());
    }

    /**
     * Returns a total rows from the specified table.
     *
     * @return integer
     */
    public function countAll()
    {
        $primary = (string) $this->primary();

        $table = $this->table();

        $builder = InstanceHelper::get()->createQueryBuilder();

        $builder->select($builder->expr()->count($table . '.' . $primary));

        $builder->from((string) get_class($this), $table);

        return $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * Deletes the specified ID of the model from the database.
     *
     * @param  integer $id
     * @return void
     */
    public function delete($id)
    {
        $item = $this->find((integer) $id);

        InstanceHelper::get()->remove($item);

        InstanceHelper::get()->flush();
    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param  mixed        $id
     * @param  integer|null $mode
     * @param  integer|null $version
     * @return mixed
     */
    public function find($id, $mode = null, $version = null)
    {
        $repository = InstanceHelper::get()->getRepository(get_class($this));

        return $repository->find($id, $mode, $version);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param  array        $criteria
     * @param  array|null   $order
     * @param  integer|null $limit
     * @param  integer|null $offset
     * @return array
     */
    public function findBy(array $criteria, array $order = null, $limit = null, $offset = null)
    {
        return $this->where($criteria)->get($limit, $offset, $order);
    }

    /**
     * Returns an array of rows from a specified entity.
     *
     * @param  integer|null $limit
     * @param  integer|null $page
     * @param  array|null   $order
     * @return array
     */
    public function get($limit = null, $page = null, array $order = null)
    {
        $repository = InstanceHelper::get()->getRepository(get_class($this));

        ($criteria = $this->criteria) && $this->criteria = array();

        return $repository->findBy($criteria, $order, $limit, $page);
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
        if (is_array($key) === true) {
            $this->criteria = (array) $key;
        } else {
            $this->criteria[$key] = $value;
        }

        return $this;
    }

    /**
     * Inserts a new row into the table.
     *
     * @param  array $data
     * @return integer
     */
    public function insert(array $data)
    {
        $this->db->insert($this->table(), $data);

        $lastId = $this->db->insert_id();

        InstanceHelper::get()->refresh($this->find($lastId));

        return $lastId;
    }

    /**
     * Updates the selected row from the table.
     *
     * @param  integer $id
     * @param  array   $data
     * @return boolean
     */
    public function update($id, array $data)
    {
        $this->db->where($this->primary(), $id);

        $this->db->set((array) $data);

        $result = $this->db->update($this->table());

        $item = $this->find((integer) $id);

        InstanceHelper::get()->refresh($item);

        return $result;
    }

    /**
     * Returns the primary key.
     *
     * @return string
     */
    public function primary()
    {
        return $this->metadata()->getSingleIdentifierColumnName();
    }

    /**
     * Returns the name of the table.
     *
     * @return string
     */
    public function table()
    {
        return $this->metadata()->getTableName();
    }

    /**
     * Returns the metadata of an entity.
     *
     * @return \Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    protected function metadata()
    {
        $class = (string) get_class($this);

        $manager = InstanceHelper::get();

        $factory = $manager->getMetadataFactory();

        return $factory->getMetadataFor($class);
    }

    /**
     * Calls methods in underscore case.
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
