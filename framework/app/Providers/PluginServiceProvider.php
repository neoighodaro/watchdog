<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Plugins list
     * @var array
     */
    protected $plugins = [];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../../content/plugins');

        // ---------------------------------------------------------------
        // Attempt to load the Service Provider attached to each plugin.
        // ---------------------------------------------------------------

        foreach (glob($path.'/*/*ServiceProvider.php') as $file) {
            $namespace = str_replace($path.'/', '', str_replace('.php', '', $file));

            list($namespace, $className) = explode('/', $namespace, 2);

            $this->app->register("App\\Plugin\\{$namespace}\\{$className}");
        }
    }
}
