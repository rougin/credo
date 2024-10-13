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
    /**
     * Calls methods from EntityRepository in underscore case.
     *
     * @param string  $method
     * @param mixed[] $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        // Camelize the method name -----------------
        $words = ucwords(strtr($method, '_-', '  '));

        $search = array(' ', '_', '-');

        $method = str_replace($search, '', $words);

        $method = lcfirst((string) $method);
        // ------------------------------------------

        /** @var callable */
        $class = array($this, $method);

        return call_user_func_array($class, $params);
    }

    /**
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
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

        $this->_em->persist($entity);

        $this->_em->flush();
    }

    /**
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
     * Deletes the specified item from the database.
     *
     * @param object $entity
     *
     * @return void
     */
    public function delete($entity)
    {
        $this->_em->remove($entity);

        $this->_em->flush();
    }

    /**
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
     * Returns an array of entities in dropdown format.
     *
     * @param string $column
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

            /** @var integer */
            $text = call_user_func_array($class, array());
            // --------------------------------------------

            $data[$key] = ucwords($text);
        }

        return $data;
    }

    /**
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
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
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
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
     * TODO: Create unit test for this method.
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
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
     * Returns the total rows from the specified table.
     *
     * @return integer
     */
    public function total()
    {
        return $this->count(array());
    }

    /**
     * @codeCoverageIgnore
     * TODO: Create unit test for this method.
     *
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

        $this->_em->flush();
    }
}
