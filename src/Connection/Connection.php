<?php

namespace zhangrui\clickhouse\Connection;


use zhangrui\clickhouse\Connectors\ConnectorInterface;
use zhangrui\clickhouse\Builder;

abstract class Connection implements ConnectionInterface
{
    protected $connector;
    protected $connection;
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

    abstract public function select($query);

    public function getDatabaseName()
    {
        return $this->database;
    }

    /**
     * @return mixed
     */
    public function connection()
    {
        if (is_null($this->connection)) {
            $this->connection = $this->connector->connect($this->config);
        }
        return $this->connection;
    }
}
