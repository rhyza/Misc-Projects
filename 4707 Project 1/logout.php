<?php

require_once 'init.php';

setcookie($cookie_name, "", time() - 3600, $cookie_path, $cookie_domain);
unset($_COOKIE[$cookie_name]);
sys_error("You have been logged out.");
?>

<div class="alert alert-warning" role="alert"><strong>You have been logged out.</strong></div>
