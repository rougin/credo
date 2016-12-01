<?php

namespace Rougin\Credo;

use Doctrine\ORM\Tools\Setup;

use Rougin\Credo\Helpers\MagicMethodHelper;

/**
 * Credo
 *
 * Integrates Doctrine to CodeIgniter with ease.
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
    protected $entityManager;

    /**
     * @param \CI_DB_query_builder $database
     */
    public function __construct(\CI_DB_query_builder $database)
    {
        $connection  = $this->prepareDatabase($database);
        $directories = [ APPPATH . 'models', APPPATH . 'repositories' ];
        $proxies     = APPPATH . 'models/proxies';

        // Set $ci->db->db_debug to TRUE to disable caching while you develop
        $isDevMode = $database->db_debug;

        $config = Setup::createAnnotationMetadataConfiguration($directories, $isDevMode, $proxies);

        $this->entityManager = \Doctrine\ORM\EntityManager::create($connection, $config);
    }

    /**
     * Gets the database configuration for specific database drivers.
     *
     * @param  array $config
     * @return array
     */
    private function getDatabaseConfiguration(array $config)
    {
        if ($config['driver'] == 'pdo' && strpos($config['dsn'], ':') !== false) {
            $keys = explode(':', $config['dsn']);

            $config['driver'] .= '_' . $keys[0];
        }

        if ($config['driver'] == 'pdo_sqlite') {
            $config['path'] = str_replace('sqlite:', '', $config['dsn']);
        }

        return $config;
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param  \CI_DB_query_builder $database
     * @return array
     */
    private function prepareDatabase(\CI_DB_query_builder $database)
    {
        $connection = [
            'dsn'      => $database->dsn,
            'driver'   => $database->dbdriver,
            'user'     => $database->username,
            'password' => $database->password,
            'host'     => $database->hostname,
            'dbname'   => $database->database,
            'charset'  => $database->char_set,
        ];

        return $this->getDatabaseConfiguration($connection);
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
        return MagicMethodHelper::call($this, $method, $parameters, $this->entityManager);
    }
}
