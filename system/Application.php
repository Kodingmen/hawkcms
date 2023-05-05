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

}