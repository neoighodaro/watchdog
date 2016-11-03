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
        $path = plugin_path();

        // ---------------------------------------------------------------
        // Attempt to load the Service Provider attached to each plugin.
        // ---------------------------------------------------------------

        foreach (glob($path.'/*/*ServiceProvider.php') as $file) {
            $filePath = str_replace($path.'/', '', $file);

            $class = classname_from_path($filePath, "App\\Plugin\\");

            $this->app->register($class);
        }
    }
}
