<?php
namespace System;

class Application extends \Illuminate\Foundation\Application{

    public function getNamespace()
    {
        return $this->namespace = "App\\";
    }

    public function __construct($basePath = null)
    {
        parent::__construct($basePath);

        $this->singleton(
            Illuminate\Contracts\Http\Kernel::class,
            \System\Kernel\Http::class
        );

        $this->singleton(
            Illuminate\Contracts\Console\Kernel::class,
            \System\Kernel\Console::class
        );

        $this->singleton(
            Illuminate\Contracts\Debug\ExceptionHandler::class,
            \System\Kernel\Exception::class
        );
    }

    public function storagePath($path = '')
    {
        return $this->joinPaths($this->storagePath ?: $this->basePath('storage'), $path);
    }

    public function configPath($path = '')
    {
        return $this->joinPaths($this->configPath ?: $this->basePath('libraries/config'), $path);
    }

    public function databasePath($path = '')
    {
        return $this->joinPaths($this->databasePath ?: $this->basePath('libraries/database'), $path);
    }

    public function publicPath($path = '')
    {
        return $this->joinPaths($this->publicPath ?: $this->basePath('public_html'), $path);
    }

    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.storage', $this->storagePath());

        $this->useBootstrapPath(value(function () {
            return is_dir($directory = $this->basePath('.laravel'))
                ? $directory
                : $this->basePath('bootstrap');
        }));

        $this->useLangPath(value(function () {
            return is_dir($directory = $this->resourcePath('lang'))
                ? $directory
                : $this->basePath('lang');
        }));
    }
}