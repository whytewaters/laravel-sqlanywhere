<?php 

namespace Cagartner\SQLAnywhere;

use Cagartner\SQLAnywhere\Model;
use Cagartner\SQLAnywhere\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class SQLAnywhereServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add a SQLAnywhere extension to the original database manager
        $this->app['db']->extend('sqlanywhere', function($config)
        {
            return new Connection($config);
        });
    }

}
