<?php

namespace Rougin\Credo;

use Rougin\Credo\Helpers\InstanceHelper;

/**
 * Codeigniter Model
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 *
 * @property \CI_DB_query_builder $db
 */
class CodeigniterModel extends \CI_Model
{
    public function __construct()
    {
        parent::__construct();

        InstanceHelper::create($this->db);
    }

    /**
     * Returns all of the models from the database.
     *
     * @return array
     */
    public function all()
    {
        return $this->findBy([]);
    }

    /**
     * Returns a total rows from the specified table.
     *
     * @return integer
     */
    public function countAll()
    {
        list($tableName, $primaryKey) = $this->getTableNameAndPrimaryKey();

        $queryBuilder = InstanceHelper::get()->createQueryBuilder();

        $queryBuilder->select($queryBuilder->expr()->count($tableName . '.' . $primaryKey));
        $queryBuilder->from(get_class($this), $tableName);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * Deletes the specified ID of the model from the database.
     *
     * @param  integer $id
     * @return void
     */
    public function delete($id)
    {
        $item = $this->find($id);

        if (! is_null($item)) {
            InstanceHelper::get()->remove($item);
            InstanceHelper::get()->flush();
        }
    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param  mixed    $id
     * @param  int|null $lockMode
     * @param  int|null $lockVersion
     * @return object|null
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $repository = InstanceHelper::get()->getRepository(get_class($this));

        return $repository->find($id, $lockMode, $lockVersion);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param  array        $criteria
     * @param  array|null   $orderBy
     * @param  integer|null $limit
     * @param  integer|null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repository = InstanceHelper::get()->getRepository(get_class($this));

        return $repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Inserts a new row into the table.
     *
     * @param  array $data
     * @return integer
     */
    public function insert(array $data)
    {
        list($tableName) = $this->getTableNameAndPrimaryKey();

        $this->db->insert($tableName, $data);

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
        list($tableName, $primaryKey) = $this->getTableNameAndPrimaryKey();

        $this->db->where($primaryKey, $id);
        $this->db->set($data);

        $result = $this->db->update($tableName);

        InstanceHelper::get()->refresh($this->find($id));

        return $result;
    }

    /**
     * Returns the table name and the corresponding primary key.
     *
     * @return array
     */
    protected function getTableNameAndPrimaryKey()
    {
        $factory  = InstanceHelper::get()->getMetadataFactory();
        $metadata = $factory->getMetadataFor(get_class($this));

        return [ $metadata->getTableName(), $metadata->getSingleIdentifierColumnName() ];
    }

    /**
     * Calls methods from CodeigniterModel in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return \Rougin\Credo\Helpers\MagicMethodHelper::call($this, $method, $parameters);
    }
}
