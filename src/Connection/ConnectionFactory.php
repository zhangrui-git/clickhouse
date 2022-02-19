<?php

namespace zhangrui\clickhouse\Connection;


use Illuminate\Contracts\Container\Container;
use zhangrui\clickhouse\Connectors\ConnectorInterface;
use zhangrui\clickhouse\Connectors\MySqlConnector;

class ConnectionFactory
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $config
     * @return Connection
     * @throws \Exception
     */
    public function make(array $config)
    {
        return $this->createConnection($config);
    }

    /**
     * @param array $config
     * @return Connection
     * @throws \Exception
     */
    protected function createConnection(array $config)
    {
        $pdo = $this->createConnector($config);
        switch ($config['driver']) {
            case 'mysql':
                return new MySqlConnection($pdo, $config['database'], $config['prefix'], $config);
        }

        throw new \Exception("Unsupported driver [{$config['driver']}].");
    }

    /**
     * @param array $config
     * @return ConnectorInterface
     * @throws \Exception
     */
    protected function createConnector(array $config)
    {
        switch ($config['driver']) {
            case 'mysql':
                return new MySqlConnector();
        }

        throw new \Exception("Unsupported driver [{$config['driver']}].");
    }
}
