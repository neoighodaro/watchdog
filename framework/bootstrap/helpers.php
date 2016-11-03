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