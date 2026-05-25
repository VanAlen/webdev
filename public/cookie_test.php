<?php
session_start();
echo "Session Name: " . session_name() . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Cookie Parameters: <pre>";
print_r(session_get_cookie_params());
echo "</pre>";

// Test if cookie is being set
if (isset($_COOKIE[session_name()])) {
    echo "Cookie '" . session_name() . "' IS being sent by browser!<br>";
} else {
    echo "Cookie '" . session_name() . "' is NOT being sent by browser.<br>";
}