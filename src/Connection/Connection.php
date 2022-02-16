<?php

namespace zhangrui\clickhouse\Connection;


use zhangrui\clickhouse\Connectors\ConnectorInterface;
use zhangrui\clickhouse\Query\Builder;

class Connection implements ConnectionInterface
{
    protected $pdo;
    protected $connections = [];
    protected $database;
    protected $tablePrefix = '';
    protected $config = [];

    public function __construct(ConnectorInterface $pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        $this->pdo = $pdo;
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

    public function connection($name = null)
    {

    }
}
