<?php

namespace Rougin\Credo;

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
    /**
     * @var \Rougin\Credo\Credo
     */
    protected $credo;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct()
    {
        parent::__construct();

        $this->credo      = new Credo($this->db);
        $this->repository = $this->credo->getRepository(get_class($this));
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

        $queryBuilder = $this->credo->createQueryBuilder();

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
            $this->credo->remove($item);
            $this->credo->flush();
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
        return $this->repository->find($id, $lockMode, $lockVersion);
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
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
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

        $this->credo->refresh($this->find($lastId));

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

        $this->credo->refresh($this->find($id));

        return $result;
    }

    /**
     * Returns the table name and the corresponding primary key.
     *
     * @return array
     */
    protected function getTableNameAndPrimaryKey()
    {
        $factory  = $this->credo->getMetadataFactory();
        $metadata = $factory->getMetadataFor(get_class($this));

        return [ $metadata->getTableName(), $metadata->getSingleIdentifierColumnName() ];
    }
}
