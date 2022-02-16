<?php

namespace zhangrui\clickhouse\Connection;


class MySqlConnection extends Connection
{
    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);
    }
}
