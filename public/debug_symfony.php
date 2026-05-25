<?php
require_once __DIR__.'/../vendor/autoload.php';

$start = microtime(true);

// 1. Autoload time
echo "Autoload: " . (microtime(true) - $start) . "s<br>";

// 2. Kernel creation
$kernelStart = microtime(true);
$kernel = new App\Kernel('prod', false);
echo "Kernel new: " . (microtime(true) - $kernelStart) . "s<br>";

// 3. Kernel boot
$bootStart = microtime(true);
$kernel->boot();
echo "Kernel boot: " . (microtime(true) - $bootStart) . "s<br>";

// 4. Get container
$containerStart = microtime(true);
$container = $kernel->getContainer();
echo "Get container: " . (microtime(true) - $containerStart) . "s<br>";

echo "<hr>Total time: " . (microtime(true) - $start) . "s";