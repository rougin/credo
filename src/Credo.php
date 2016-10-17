<?php

namespace Rougin\Credo;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Credo
 *
 * Integrates Doctrine to CodeIgniter with ease.
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Credo
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @param CI_DB $database
     */
    public function __construct($database = null)
    {
        $ci = null;

        // Loads the database configuration from CodeIgniter
        if (empty($database)) {
            $ci = \Rougin\SparkPlug\Instance::create();

            $ci->load->database();

            $database = $ci->db;
        }

        $connection     = $this->setDatabaseConnection($database);
        $directories    = [ APPPATH . 'models', APPPATH . 'repositories' ];
        $proxyDirectory = APPPATH . 'models/proxies';

        // Set $ci->db->db_debug to TRUE to disable caching while you develop
        $isDevMode = ($ci) ? $ci->db->db_debug : $database->db_debug;

        $config = Setup::createAnnotationMetadataConfiguration($directories, $isDevMode, $proxyDirectory);

        $this->entityManager = EntityManager::create($connection, $config);
    }

    /**
     * Sets up the database configuration from CodeIgniter.
     *
     * @param  CI_DB $database
     * @return array
     */
    private function setDatabaseConnection($database)
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
        $method = \Doctrine\Common\Util\Inflector::camelize($method);
        $result = $this;

        if (method_exists($this->entityManager, $method)) {
            $class = [$this->entityManager, $method];
            
            $result = call_user_func_array($class, $parameters);
        }

        return $result;
    }
}
