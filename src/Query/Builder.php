<?php

declare(strict_types=1);


namespace zhangrui\clickhouse\Query;


use zhangrui\clickhouse\Connection\ConnectionInterface;

class Builder
{
    public $connection;
    public $from;
    public $columns = [];
    public $where = [];
    public $group = [];
    public $having;
    public $order = [];
    public $limit;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function select(array $columns = ['*'])
    {
        $this->columns = $columns;
        return $this;
    }

    public function from($table)
    {
        $this->from = $table;
        return $this;
    }

    public function where(string $where)
    {
        $this->where[] = ['', $where];
    }

    public function andWhere(string $where)
    {
        $this->where[] = ['AND', $where];
    }

    public function orWhere(string $where)
    {
        $this->where[] = ['OR', $where];
    }

    public function groupBy(array $columns)
    {
        $this->group = $columns;
        return $this;
    }

    public function having(string $having)
    {
        $this->having = $having;
    }

    public function limit(string $limit)
    {
        $this->limit = "$limit";
        return $this;
    }

    public function limitBy(string $limit, string $by)
    {
        $this->limit = "$limit BY $by";
        return $this;
    }

    public function descOrderBy(string $column)
    {
        $this->order[] = "$column DESC";
        return $this;
    }

    public function ascOrderBy(string $column)
    {
        $this->order[] = "$column ASC";
        return $this;
    }

    public function toSql()
    {
        $columnString = 'SELECT '. implode(',', $this->columns);

        $formString = 'FROM '. $this->from;

        $whereString = '';
        if (! empty($this->where)) {
            $s = [];
            foreach ($this->where as $w) {
                $s[] = implode(' ', $w);
            }
            $whereString = 'WHERE '. implode(' ', $s);
        }

        $groupString = '';
        if (! empty($this->group)) {
            $groupString = 'GROUP BY '. implode(',', $this->group);
        }

        $havingString = $this->having ? 'HAVING '. $this->having : '';

        $orderString = '';
        if (! empty($this->order)) {
            $orderString = 'ORDER BY '. implode(',', $this->order);
        }

        $limitString = $this->limit ? 'LIMIT '. $this->limit : '';

        return rtrim("$columnString $formString $whereString $groupString $havingString $orderString $limitString").';';
    }
}