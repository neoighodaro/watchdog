<?php

if ( ! function_exists('plugin_path')) {
    /**
     * Gets the full path to the plugin directory.
     *
     * @return string
     */
    function plugin_path()
    {
        return realpath(__DIR__.'/../../content/plugins');
    }
}

if ( ! function_exists('classname_from_path')) {
    /**
     * Get a class name from a path.
     *
     * @param  string  $path
     * @param  string  $namespace
     * @return string
     */
    function classname_from_path($path, $namespace = null)
    {
        $class = str_replace('/', '\\', str_replace('.php', '', $path));

        return trim($namespace, '\\').'\\'.$class;
    }
}