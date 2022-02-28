<?php

namespace zhangrui\clickhouse\Connection;


class MySqlConnection extends Connection
{
    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);
    }

    public function select($query)
    {
        /** @var \PDO $conn */
        $conn = $this->connection();
        $statement = $conn->query($query);
        if ($statement === false) {
            return $statement;
        } else {
            return $statement->fetchAll();
        }
    }
}
