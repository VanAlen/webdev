<?php
// Step 1: Checking current domain
echo "Step 1: Checking current domain<br>";
echo "Your current URL is: " . ($_SERVER['HTTP_HOST'] ?? 'UNKNOWN') . "<br>";
echo "Is HTTPS? " . (isset($_SERVER['HTTPS']) ? 'Yes' : 'No') . "<br><hr>";

// Step 2: Fix cookie domain to match your current access
ini_set('session.cookie_domain', '127.0.0.1');

// Step 3: Test session variable
session_start();

// Set a test value
$_SESSION['test_login'] = 'working_' . time();

echo "<h2>Session Settings BEFORE Symfony</h2>";
echo "session.cookie_secure = " . ini_get('session.cookie_secure') . "<br>";
echo "session.cookie_domain = " . ini_get('session.cookie_domain') . "<br>";
echo "session.name = " . ini_get('session.name') . "<br><br>";

echo "<h2>Current Session Data</h2>";
echo "Session ID: " . session_id() . "<br>";
echo "Test value in session: " . ($_SESSION['test_login'] ?? 'NOT SET') . "<br><br>";

echo "<h2>Cookie Parameters</h2>";
$params = session_get_cookie_params();
echo "<pre>";
print_r($params);
echo "</pre>";

// Check headers
echo "<h2>Response Headers</h2>";
header('Content-Type: text/html');
ob_start();
session_write_close();
$headers = headers_list();
echo "<pre>";
foreach ($headers as $header) {
    if (strpos($header, 'Set-Cookie') !== false) {
        echo htmlspecialchars($header) . "\n";
    }
}
echo "</pre>";

// Check if cookie was sent in request
echo "<h2>Cookies Sent by Browser</h2>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";