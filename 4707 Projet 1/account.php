<?php

require_once 'init.php';

if (isset($_REQUEST['act']) == 'changePassword') {

    if (empty($_REQUEST['oldpassword']) | empty($_REQUEST['newpassword'])) {
        sys_error("Password is not specified.");
    }

    // Example of setcookie.
    // setcookie($cookie_name, $_POST['username'], 0, $cookie_path);

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
    include "$template_dir/account.html";
}

?>
