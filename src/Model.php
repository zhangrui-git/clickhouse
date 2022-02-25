<?php

declare(strict_types=1);


namespace zhangrui\clickhouse\Model;


abstract class Model
{
    protected $tableName;

    protected $collection;

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
}
