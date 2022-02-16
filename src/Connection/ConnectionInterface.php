<?php

declare(strict_types=1);


namespace zhangrui\clickhouse\Connection;


interface ConnectionInterface
{
    public function table($table);

    public function select($query);

    public function insert($query);

    public function getDatabaseName();
}
