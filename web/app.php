<?php

use Symfony\Component\HttpFoundation\Request;

//phpinfo();
require __DIR__.'/../vendor/autoload.php';
date_default_timezone_set( 'Europe/Paris' );

if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$kernel = new AppKernel('prod', true);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
