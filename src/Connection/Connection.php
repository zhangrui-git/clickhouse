<?php

namespace zhangrui\clickhouse\Connection;


use zhangrui\clickhouse\Connectors\ConnectorInterface;
use zhangrui\clickhouse\Builder;

class Connection implements ConnectionInterface
{
    protected $connector;
    protected $connections = [];
    protected $database;
    protected $tablePrefix = '';
    protected $config = [];

    public function __construct(ConnectorInterface $connector, $database = '', $tablePrefix = '', array $config = [])
    {
        $this->connector = $connector;
        $this->database = $database;
        $this->tablePrefix = $tablePrefix;
        $this->config = $config;
    }

    public function table($table)
    {
        return $this->query()->from($this->tablePrefix . $table);
    }

    public function query()
    {
        return new Builder($this);
    }

    public function select($query)
    {
        // TODO: Implement select() method.
    }

    public function insert($query)
    {
        // TODO: Implement insert() method.
    }

    public function getDatabaseName()
    {
        return $this->database;
    }

    public function connection(string $name = 'default')
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        } else {
            return $this->connections[$name] = $this->connector->connect($this->config);
        }
    }
}
