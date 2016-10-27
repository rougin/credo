<?php

namespace Rougin\Credo;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

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
        $connection  = $this->setDatabaseConnection($database);
        $directories = [ APPPATH . 'models', APPPATH . 'repositories' ];
        $proxies     = APPPATH . 'models/proxies';

        // Set $ci->db->db_debug to TRUE to disable caching while you develop
        $isDevMode = $database->db_debug;

        $config = Setup::createAnnotationMetadataConfiguration($directories, $isDevMode, $proxies);

        $this->entityManager = EntityManager::create($connection, $config);
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param  \CI_DB_query_builder $database
     * @return array
     */
    private function setDatabaseConnection(\CI_DB_query_builder $database)
    {
        $driver = $database->dbdriver;
        $dsn    = $database->dsn;

        if ($driver == 'pdo' && strpos($dsn, ':') !== false) {
            $keys = explode(':', $dsn);
            $driver .= '_' . $keys[0];
        }

        $connection = [
            'driver'   => $driver,
            'user'     => $database->username,
            'password' => $database->password,
            'host'     => $database->hostname,
            'dbname'   => $database->database,
            'charset'  => $database->char_set,
        ];

        if ($driver == 'pdo_sqlite') {
            $connection['path'] = str_replace('sqlite:', '', $database->dsn);
        }

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
        return MagicMethodHelper::call($this, $method, $parameters, $this->entityManager);
    }
}
