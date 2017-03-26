<?php
// side effect: sets database and path configurations
require_once 'config.php';
require_once 'include/mylib.php';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_COOKIE[$cookie_name])) {
	setcookie($cookie_name, "unregistered", 0, $cookie_path, $cookie_domain);
}

?>
