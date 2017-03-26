<?php

require_once 'init.php';

if (isset($_REQUEST['act']) == 'login') {

    if (empty($_REQUEST['username'])) {
        sys_error("Username is not specified.");
    } else {
      $userhash = hash('sha256', $_POST['username']);
      $pwhash = hash('sha256', $_POST['password']);
      echo "Username: ".$userhash;
      echo "Password: ".$pwhash;
      setcookie($cookie_name, $_POST['username'], 0, $cookie_path);
    }

    /*sys_error("Not implemented.\nThe information submitted is:\n".
    json_encode(array(
        "_REQUEST" => $_REQUEST,
        "_POST" => $_POST,
        "_GET" => $_GET,
        "_COOKIE" => $_COOKIE,
    )));*/
}
else {
    include "$template_dir/login.html";
}

?>
