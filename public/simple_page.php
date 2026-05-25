<?php
require_once __DIR__.'/../vendor/autoload.php';

$kernel = new App\Kernel('prod', false);
$kernel->boot();
$container = $kernel->getContainer();

// Simple response without database
$response = new Symfony\Component\HttpFoundation\Response(
    '<h1>Simple page</h1><p>No database, no forms</p>'
);

$response->send();