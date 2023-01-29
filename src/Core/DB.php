<?php

namespace App\Core;

class DB
{
    static protected $instance = null;

    protected $connection = null;

    protected function __construct()
    {
        $config = Config::get('database');

        $dsn = "{$config['drive']}:host={$config['hostname']};dbname={$config['dbname']}";

        try {
            $this->connection =  new \PDO(
                $dsn,
                $config['username'],
                $config['password']
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    static public function getInstance()
    {
        if (!(static::$instance instanceof static)) {
            static::$instance = new static();
        }

        return static::$instance->getConnection();
    }
}
