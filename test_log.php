<?php
require_once 'vendor/autoload.php';

$kernel = new App\Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();

try {
    $logger = $container->get('App\Service\ActivityLogger');
    $logger->log('TEST', 'Testing from CLI script');
    echo "✓ Log created successfully\n";
    echo "Check your activitylog table in database\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
