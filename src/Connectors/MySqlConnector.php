<?php

namespace zhangrui\clickhouse\Connectors;


class MySqlConnector implements ConnectorInterface
{
    /**
     * @param array $config
     * @return \PDO
     */
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);
        /** @var \PDO $connection */
        $connection = $this->createConnection($dsn, $config);

        if (! empty($config['database'])) {
            $connection->exec("use `{$config['database']}`;");
        }

        return $connection;
    }

    protected function createConnection($dsn, $config)
    {
        extract($config, EXTR_SKIP);
        return new \PDO($dsn, $username, $password, null);
    }

    protected function getDsn(array $config): string
    {
        extract($config, EXTR_SKIP);
        return "mysql:host={$host};port={$port};dbname={$database}";
    }
}
