<?php

namespace Rougin\Credo;

use CI_DB_query_builder as Builder;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * @method \Doctrine\ORM\EntityRepository             get_repository(string $entityName)
 * @method \Doctrine\ORM\EntityRepository             getRepository(string $entityName)
 * @method \Doctrine\ORM\Mapping\ClassMetadataFactory getMetadataFactory()
 * @method \Doctrine\ORM\Query\QueryBuilder           createQueryBuilder()
 * @method object                                     refresh($entity)
 * @method void                                       flush(object $entity = null)
 * @method void                                       remove(object $entity)
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Credo
{
    /**
     * @var \CI_DB_query_builder|null
     */
    protected $builder = null;

    /**
     * @var array<string, mixed>
     */
    protected $criteria = array();

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Calls methods from the specified object in underscore case.
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
        $class = array($this->manager, $method);

        return call_user_func_array($class, $params);
    }

    /**
     * Initializes EntityManager if Query Builder is defined.
     *
     * @param \CI_DB_query_builder|null $builder
     */
    public function __construct(Builder $builder = null)
    {
        if ($builder)
        {
            $config = $this->getConfig($builder);

            $debug = $builder->db_debug;

            $manager = $this->newManager($config, $debug);

            $this->setManager($manager);
        }
    }

    /**
     * Finds the row from storage based on given identifier.
     *
     * @param class-string $class
     * @param integer      $id
     * @param integer|null $mode
     * @param integer|null $version
     *
     * @return object|null
     */
    public function find($class, $id, $mode = null, $version = null)
    {
        return $this->manager->getRepository($class)->find($id, $mode, $version);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param class-string               $class
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $order
     * @param integer|null               $limit
     * @param integer|null               $offset
     *
     * @return object[]
     */
    public function findBy($class, $criteria = array(), $order = null, $limit = null, $offset = null)
    {
        $repository = $this->manager->getRepository((string) $class);

        return $repository->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * Returns an array of rows from a specified table.
     *
     * @param class-string               $class
     * @param integer|null               $limit
     * @param integer|null               $offset
     * @param array<string, string>|null $order
     *
     * @return object[]
     */
    public function get($class, $limit = null, $offset = null, $order = null)
    {
        $criteria = $this->criteria;

        $this->criteria = array();

        return $this->findBy($class, $criteria, $order, $limit, $offset);
    }

    /**
     * @deprecated since ~0.6, use official implementations from Doctrine instead if using version 3.
     *
     * Returns an EntityManager based on Query Builder.
     * Set $debug to "true" to disable caching during development.
     *
     * @param array<string, string>             $connect
     * @param boolean                           $debug
     * @param \Doctrine\Common\Cache\Cache|null $cache
     * @param boolean                           $simple
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function newManager($connect, $debug = false, Cache $cache = null, $simple = true)
    {
        $proxies = (string) APPPATH . 'models/proxies';

        $folders = array((string) APPPATH . 'models');

        array_push($folders, APPPATH . 'repositories');

        // Set $debug to TRUE to disable caching during development ----------------------------------------
        $config = Setup::createAnnotationMetadataConfiguration($folders, $debug, $proxies, $cache, $simple);
        // -------------------------------------------------------------------------------------------------

        return EntityManager::create($connect, $config);
    }

    /**
     * Sets the EntityManager instance.
     *
     * @param \Doctrine\ORM\EntityManager $manager
     *
     * @return self
     */
    public function setManager(EntityManager $manager)
    {
        $this->manager = $manager;

        return $this;
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
        if (! is_string($key))
        {
            $this->criteria = (array) $key;

            return $this;
        }

        $this->criteria[$key] = $value;

        return $this;
    }

    /**
     * Sets up the database configuration from Codeigniter.
     *
     * @param \CI_DB_query_builder $builder
     *
     * @return array<string, string>
     */
    protected function getConfig(Builder $builder)
    {
        $data = array('dsn' => $builder->dsn);

        $data['driver'] = $builder->dbdriver;

        $data['user'] = $builder->username;

        $data['password'] = $builder->password;

        $data['host'] = $builder->hostname;

        $data['dbname'] = $builder->database;

        $data['charset'] = $builder->char_set;

        $hasDsn = strpos($data['dsn'], ':') !== false;

        if ($data['driver'] === 'pdo' && $hasDsn)
        {
            $keys = explode(':', $data['dsn']);

            $data['driver'] .= '_' . $keys[0];
        }

        if ($data['driver'] === 'pdo_sqlite')
        {
            $data['path'] = str_replace('sqlite:', '', $data['dsn']);
        }

        return $data;
    }
}
