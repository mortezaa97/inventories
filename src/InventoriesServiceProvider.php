<?php

namespace Mortezaa97\Inventories;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class InventoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Gate::policy(Inventory::class, InventoryPolicy::class); // TODO: Implement inventory policy

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('inventories.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'inventories');

        // Register the main class to use with the facade
        $this->app->singleton('inventories', function () {
            return new Inventories;
        });
    }
}
