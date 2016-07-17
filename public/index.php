<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
//$kernel = new AppKernel('prod', false);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);