<?php

// init.php already included mylib.php and config.php
require_once 'init.php';

// handles login here
// Currently, only print the informaton submitted.

if (isset($_REQUEST['act']) == 'login') {

    if (empty($_REQUEST['username'])) {
        sys_error("Username is not specified.");
    }

    // Example of setcookie.
    setcookie($cookie_name, $_POST['username'], 0, $cookie_path);

    //You can see the cookie is set when you load the page again.

    sys_error("Not implemented.\nThe information submitted is:\n".
    json_encode(array(
        "_REQUEST" => $_REQUEST,
        "_POST" => $_POST,
        "_GET" => $_GET,
        "_COOKIE" => $_COOKIE,
    )));
}
else {
    include "$template_dir/login.html";
}

?>
