<?php

namespace zhangrui\clickhouse;


use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder table(string $table)
 * @method static array select(string $query)
 * @method static bool insert(string $query)
 * Class ClickHouse
 * @package zhangrui\clickhouse
 */
class ClickHouse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'clickhouse.connection';
    }
}
