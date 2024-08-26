<?php

namespace Rougin\Credo;

use CI_DB_query_builder as Builder;
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
     * Initializes the EntityManager instance.
     *
     * @param \CI_DB_query_builder $builder
     */
    public function __construct(Builder $builder)
    {
        $config = $this->connection($builder);

        $driver = $config['driver'];

        $hasDsn = strpos($config['dsn'], ':') !== false;

        if ($driver === 'pdo' && $hasDsn)
        {
            $keys = explode(':', $config['dsn']);

            $config['driver'] .= '_' . $keys[0];
        }

        if ($config['driver'] === 'pdo_sqlite')
        {
            $config['path'] = str_replace('sqlite:', '', $config['dsn']);
        }

        $this->manager = $this->boot($config, $builder->db_debug);
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
        return $this->manager->getRepository($class)->find($id, (int) $mode, $version);
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
     * Bootstraps the EntityManager instance.
     *
     * @param array<string, string> $connect
     * @param boolean               $debug
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function boot($connect, $debug = false)
    {
        $proxies = (string) APPPATH . 'models/proxies';

        $folders = array((string) APPPATH . 'models');

        array_push($folders, APPPATH . 'repositories');

        // Set $debug to TRUE to disable caching during development -----------------------
        $config = Setup::createAnnotationMetadataConfiguration($folders, $debug, $proxies);
        // --------------------------------------------------------------------------------

        return EntityManager::create($connect, $config);
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param \CI_DB_query_builder $builder
     *
     * @return array<string, string>
     */
    protected function connection(Builder $builder)
    {
        $data = array('dsn' => $builder->dsn);

        $data['driver'] = $builder->dbdriver;

        $data['user'] = $builder->username;

        $data['password'] = $builder->password;

        $data['host'] = $builder->hostname;

        $data['dbname'] = $builder->database;

        $data['charset'] = $builder->char_set;

        return (array) $data;
    }
}
