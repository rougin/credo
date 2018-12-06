<?php

namespace Rougin\Credo;

use CI_DB_query_builder as Builder;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Credo
 *
 * @method \Doctrine\ORM\EntityRepository             getRepository(string $entityName)
 * @method \Doctrine\ORM\Mapping\ClassMetadataFactory getMetadataFactory()
 * @method \Doctrine\ORM\Query\QueryBuilder           createQueryBuilder()
 * @method object                                     refresh($entity)
 * @method void                                       flush(object|array $entity = null)
 * @method void                                       remove(object $entity)
 *
 * @package Credo
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Credo
{
    /**
     * @var array
     */
    protected $criteria = array();

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Calls methods from the specified object in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $method = (string) Inflector::camelize($method);

        $instance = array($this->manager, (string) $method);

        return call_user_func_array($instance, $parameters);
    }

    /**
     * Initializes the EntityManager instance.
     *
     * @param \CI_DB_query_builder $builder
     */
    public function __construct(Builder $builder)
    {
        $connection = (array) $this->connection($builder);

        $dsn = strpos($connection['dsn'], ':');

        $driver = (string) $connection['driver'];

        if ($driver === 'pdo' && $dsn !== false) {
            $keys = (array) explode(':', $connection['dsn']);

            $connection['driver'] .= (string) '_' . $keys[0];
        }

        if ($connection['driver'] === 'pdo_sqlite') {
            $connection['path'] = str_replace('sqlite:', '', $connection['dsn']);
        }

        $this->manager = $this->boot($connection, $builder->db_debug);
    }

    /**
     * Finds the row from storage based on given identifier.
     *
     * @param  string  $class
     * @param  integer $id
     * @param  integer|null $mode
     * @param  integer|null $version
     * @return mixed
     */
    public function find($class, $id, $mode = null, $version = null)
    {
        return $this->manager->getRepository($class)->find($id, $mode, $version);
    }

    /**
     * Finds models by a set of criteria.
     *
     * @param  string       $class
     * @param  array        $criteria
     * @param  integer|null $offset
     * @param  array|null   $order
     * @param  integer|null $limit
     * @return array
     */
    public function findBy($class, array $criteria = array(), array $order = null, $limit = null, $offset = null)
    {
        $repository = $this->manager->getRepository((string) $class);

        return $repository->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * Returns an array of rows from a specified class.
     *
     * @param  string       $class
     * @param  integer|null $limit
     * @param  integer|null $offset
     * @param  array|null   $order
     * @return mixed
     */
    public function get($class, $limit = null, $offset = null, array $order = null)
    {
        ($criteria = (array) $this->criteria) && $this->criteria = array();

        return $this->findBy($class, $criteria, $order, $limit, $offset);
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
     * Bootstraps the EntityManager instance.
     *
     * @param  array   $connection
     * @param  boolean $debug
     * @return \Doctrine\ORM\EntityManager
     */
    protected function boot(array $connection, $debug = false)
    {
        $proxies = (string) APPPATH . 'models/proxies';

        $folders = array((string) APPPATH . 'models');

        array_push($folders, APPPATH . 'repositories');

        // Set $debug to TRUE to disable caching while you develop
        $config = Setup::createAnnotationMetadataConfiguration($folders, $debug, $proxies);

        return EntityManager::create($connection, $config);
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param  \CI_DB_query_builder $builder
     * @return array
     */
    protected function connection(Builder $builder)
    {
        $connection = array('dsn' => $builder->dsn);

        $connection['driver'] = $builder->dbdriver;

        $connection['user'] = $builder->username;

        $connection['password'] = $builder->password;

        $connection['host'] = $builder->hostname;

        $connection['dbname'] = $builder->database;

        $connection['charset'] = $builder->char_set;

        return $connection;
    }
}
