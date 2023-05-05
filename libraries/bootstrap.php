<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
const LIBRARIES = ROOT  . "libraries";

$app = new \System\Application(LIBRARIES);


$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    \System\Kernel\Http::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    \System\Kernel\Console::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    \System\Kernel\Exception::class
);

\Illuminate\Support\Facades\Facade::setFacadeApplication($app);

$app->usePublicPath(ROOT);
$app->useEnvironmentPath(ROOT);
$app->useStoragePath(ROOT . "/storage");
$app->useBootstrapPath(storage_path("bootstrap"));
$app->useAppPath(ROOT . "app");
$app->useDatabasePath(LIBRARIES . "database");
return $app;