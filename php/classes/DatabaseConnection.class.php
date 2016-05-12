<?php

require_once dirname(__DIR__) . '/DoctrineClassLoader.php';

class DatabaseConnection {
    protected $connectionParams;
    protected $config;
    protected $handle;

    /**
     * DatabaseConnection constructor.
     * @param $type
     * @param $host
     * @param $port
     * @param $user
     * @param $password
     * @param $database
     */
    public function __construct($type, $host, $port, $user, $password, $database)
    {
        $this->connectionParams = array(
            'driver' => self::getDBDriverName($type),
            'host' => $host,
            'port' => $port,
            'dbname' => $database,
            'user' => $user,
            'password' => $password,
        );

        $this->config = new \Doctrine\DBAL\Configuration();
    }

    public function connect() {
        if (!$this->handle) {
            $this->handle = \Doctrine\DBAL\DriverManager::getConnection(
                    $this->connectionParams, $this->config);
        }
        return $this->handle;
    }

    protected static function getDBDriverName($type) {
        switch ($type) {
            case 'postgresql':
                return 'pdo_pgsql';
            case 'mssql':
                return 'sqlsrv';
            case 'mysql':
                return 'pdo_mysql';
            case 'oracle':
                return 'oci8';
        }
    }
}