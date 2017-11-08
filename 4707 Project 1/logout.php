<?php
// side effect: initializes database and cookies if not set
require_once 'init.php';

setcookie($cookie_name, "", time() - 3600, $cookie_path, $cookie_domain);
unset($_COOKIE[$cookie_name]);
include "$template_dir/pageheader.html";
?>

<div class="alert alert-warning" role="alert"><strong>You have been logged out.</strong></div>
