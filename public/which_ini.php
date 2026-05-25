<?php
echo "Loaded php.ini: " . php_ini_loaded_file() . "<br>";
echo "session.cookie_secure = " . ini_get('session.cookie_secure') . "<br>";
echo "session.cookie_domain = " . ini_get('session.cookie_domain') . "<br>";