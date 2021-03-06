<?php

declare(strict_types=1);


namespace zhangrui\clickhouse;


use zhangrui\clickhouse\Connection\ConnectionInterface;

class Builder
{
    protected $connection;
    protected $from;
    protected $columns = [];
    protected $where = [];
    protected $group = [];
    protected $having;
    protected $order = [];
    protected $limit;

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

    public function get()
    {
        return $result = $this->runSelect();
    }

    public function value(string $column)
    {
        $this->select([$column]);
        $this->limit("1");
        return $this->runSelect();
    }

    public function sum(string $column)
    {
        $this->select(["SUM($column)"]);
        return $this->runSelect();
    }

    public function avg(string $column)
    {
        $this->select(["AVG($column)"]);
        return $this->runSelect();
    }

    public function count()
    {
        $this->select(['count(*)']);
        return $this->runSelect();
    }

    public function min(string $column)
    {
        $this->select(["MIN($column)"]);
        return $this->runSelect();
    }

    public function max(string $column)
    {
        $this->select(["MAX($column)"]);
        return $this->runSelect();
    }

    public function getConnection()
    {
        return $this->connection;
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

        $sql = [$columnString, $formString];
        if ($whereString) {
            array_push($sql, $whereString);
        }
        if ($groupString) {
            array_push($sql, $groupString);
        }
        if ($havingString) {
            array_push($sql, $havingString);
        }
        if ($orderString) {
            array_push($sql, $orderString);
        }
        if ($limitString) {
            array_push($sql, $limitString);
        }

        return implode(' ', $sql) . ';';
    }
}
