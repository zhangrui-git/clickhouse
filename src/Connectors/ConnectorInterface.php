<?php

namespace zhangrui\clickhouse\Connectors;


interface ConnectorInterface
{
    public function connect(array $config);
}
