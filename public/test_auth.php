<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

require_once __DIR__.'/../vendor/autoload.php';

$session = new Session(new NativeSessionStorage());
$session->start();

echo "Session ID: " . $session->getId() . "<br>";
echo "All session data: <pre>";
print_r($session->all());
echo "</pre>";

// Check for security token
if ($session->has('_security_main')) {
    echo "Security token FOUND in session!<br>";
    $token = unserialize($session->get('_security_main'));
    echo "User: " . $token->getUserIdentifier() . "<br>";
} else {
    echo "Security token NOT FOUND in session.<br>";
}