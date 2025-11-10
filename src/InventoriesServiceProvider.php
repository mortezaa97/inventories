<?php

namespace Mortezaa97\Inventories;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Mortezaa97\Inventories\Models\Inventory;
use Mortezaa97\Inventories\Models\InventoryLog;
use Mortezaa97\Inventories\Policies\InventoryPolicy;
use Mortezaa97\Inventories\Policies\InventoryLogPolicy;

class InventoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Load migrations from package
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        
        // Load routes from package
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Register policies
        Gate::policy(Inventory::class, InventoryPolicy::class);
        Gate::policy(InventoryLog::class, InventoryLogPolicy::class);

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

