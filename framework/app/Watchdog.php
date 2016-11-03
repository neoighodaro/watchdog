<?php
namespace App;

use Illuminate\Foundation\Application as IlluminateApplication;

class Watchdog extends IlluminateApplication {

    /**
     * Watchdog version.
     */
    const VERSION = "1.0.0";

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents(base_path('../composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath(app_path()) == realpath(base_path().'/../'.$pathChoice)) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }
}