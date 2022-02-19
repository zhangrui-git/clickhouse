<?php

namespace zhangrui\clickhouse\ServiceProvider;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use zhangrui\clickhouse\Connection\ConnectionFactory;

class ClickHouseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('clickhouse.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->app->singleton('clickhouse.connection', function ($app) {
            /** @var Container $app */
            $config = $app->make('config')->get('database.clickhouse');
            var_dump($config);
            /** @var ConnectionFactory $factory */
            $factory = $app['clickhouse.factory'];
            return $factory->make($config);
        });
    }
}
