<?php
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "Session save path: " . session_save_path() . "<br>";
echo "Is writable: " . (is_writable(session_save_path()) ? 'YES' : 'NO') . "<br>";

// Test writing to session
$_SESSION['test'] = 'Hello World';
session_write_close();

// Test reading
session_start();
echo "Session test value: " . ($_SESSION['test'] ?? 'NOT SET') . "<br>";