<?php

namespace Rougin\Credo;

use Doctrine\ORM\EntityRepository;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\ORM\EntityRepository<TEntityClass>
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Repository extends EntityRepository
{
    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    /**
     * Creates a new row of data to the database.
     *
     * @param array<string, mixed> $data
     * @param object               $entity
     *
     * @return void
     */
    public function create($data, $entity)
    {
        $entity = $this->set($data, $entity);

        // Perform "set_created_at" if it exists in the model ---
        $method = 'set_' . static::CREATED_AT;

        if (method_exists($entity, $method))
        {
            /** @var callable */
            $class = array($entity, $method);

            $params = array(new \DateTime);

            /** @var object */
            $entity = call_user_func_array($class, $params);
        }
        // ------------------------------------------------------

        $this->_em->persist($entity);
    }

    /**
     * Deletes the specified item from the database.
     *
     * @param object $entity
     *
     * @return void
     */
    public function delete($entity)
    {
        $this->_em->remove($entity);
    }

    /**
     * Returns an array of entities in dropdown format.
     *
     * @param string $column
     * @param string $id
     *
     * @return string[]
     */
    public function dropdown($column, $id = 'get_id')
    {
        $data = array();

        foreach ($this->get() as $item)
        {
            // Return the value from the primary key ----
            /** @var callable */
            $class = array($item, $id);

            /** @var integer */
            $key = call_user_func_array($class, array());
            // ------------------------------------------

            // Return the value from the defined column ---
            /** @var callable */
            $class = array($item, 'get_' . $column);

            /** @var string */
            $text = call_user_func_array($class, array());
            // --------------------------------------------

            $data[$key] = $text;
        }

        return $data;
    }

    /**
     * @codeCoverageIgnore
     *
     * Checks if the specified data exists in the database.
     *
     * @param array<string, mixed> $data
     * @param integer|null         $id
     *
     * @return boolean
     */
    public function exists($data, $id = null)
    {
        // Specify logic here if applicable ---
        // ------------------------------------

        return false;
    }

    /**
     * Flushes all changes in objects to the database.
     *
     * @return void
     */
    public function flush()
    {
        $this->_em->flush();
    }

    /**
     * Returns an array of rows from the entity.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     *
     * @return object[]
     */
    public function get($limit = null, $offset = null)
    {
        return $this->findBy(array(), null, $limit, $offset);
    }

    /**
     * @codeCoverageIgnore
     *
     * Updates the payload to be passed to the entity.
     *
     * @param array<string, mixed> $data
     * @param object               $entity
     * @param integer|null         $id
     *
     * @return object
     */
    public function set($data, $entity, $id = null)
    {
        // List editable fields from table ---
        // -----------------------------------

        return $entity;
    }

    /**
     * Returns the total rows from the specified table.
     *
     * @return integer
     */
    public function total()
    {
        return $this->count(array());
    }

    /**
     * Updates the specified data to the database.
     *
     * @param object               $entity
     * @param array<string, mixed> $data
     *
     * @return void
     */
    public function update($entity, $data)
    {
        $entity = $this->set($data, $entity);

        // Perform "set_updated_at" if it exists in the model ---
        $method = 'set_' . static::UPDATED_AT;

        if (method_exists($entity, $method))
        {
            /** @var callable */
            $class = array($entity, $method);

            $params = array(new \DateTime);

            $entity = call_user_func_array($class, $params);
        }
        // ------------------------------------------------------
    }
}
