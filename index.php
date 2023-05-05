<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';

const ROOT = __DIR__ . DIRECTORY_SEPARATOR;
const LIBRARIES = ROOT  . "libraries";

$app = $app = require_once __DIR__.'/libraries/bootstrap.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
