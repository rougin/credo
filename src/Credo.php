<?php

namespace Rougin\Credo;

use CI_DB_query_builder as Builder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Credo\Helpers\MethodHelper;

/**
 * Credo
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 *
 * @method \Doctrine\ORM\EntityRepository             getRepository(string $entityName)
 * @method \Doctrine\ORM\Mapping\ClassMetadataFactory getMetadataFactory()
 * @method \Doctrine\ORM\Query\QueryBuilder           createQueryBuilder()
 * @method object                                     refresh($entity)
 * @method void                                       flush(object|array $entity = null)
 * @method void                                       remove(object $entity)
 */
class Credo
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Initializes the EntityManager instance.
     *
     * @param \CI_DB_query_builder $builder
     */
    public function __construct(Builder $builder)
    {
        $connection = $this->connection($builder);

        if ($connection['driver'] == 'pdo' && strpos($connection['dsn'], ':') !== false) {
            $keys = explode(':', $connection['dsn']);

            $connection['driver'] .= '_' . $keys[0];
        }

        if ($connection['driver'] == 'pdo_sqlite') {
            $connection['path'] = str_replace('sqlite:', '', $connection['dsn']);
        }

        $directories = array(APPPATH . 'models', APPPATH . 'repositories');

        // Set $ci->db->db_debug to TRUE to disable caching while you develop
        $config = Setup::createAnnotationMetadataConfiguration($directories, $builder->db_debug, APPPATH . 'models/proxies');

        $this->manager = EntityManager::create($connection, $config);
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param  \CI_DB_query_builder $builder
     * @return array
     */
    protected function connection(Builder $builder)
    {
        $connection = [
            'dsn'      => $builder->dsn,
            'driver'   => $builder->dbdriver,
            'user'     => $builder->username,
            'password' => $builder->password,
            'host'     => $builder->hostname,
            'dbname'   => $builder->database,
            'charset'  => $builder->char_set,
        ];

        return $connection;
    }

    /**
     * Calls methods from EntityManager in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return MethodHelper::call($this->manager, $method, $parameters);
    }
}
