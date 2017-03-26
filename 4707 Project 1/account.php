<?php

require_once 'init.php';

if (isset($_COOKIE[$cookie_name])) {
    echo "<p>".$_COOKIE[$cookie_name]."</p>";
    $sql = "SELECT type FROM users WHERE username = '".$_COOKIE[$cookie_name]."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $type = $row['type'];
            if ($type == "user") {
                include "$template_dir/account.html";
            } else {
                sys_error("You are not authorized to view this page.");
            }
        }
    } else {
        sys_error("You are not authorized to view this page.");
    }
} else {
    sys_error("You are not authorized to view this page.");
}

/*TODO: FIX*/
if (isset($_REQUEST['act']) == 'changePassword') {
    if (empty($_REQUEST['oldpassword']) || empty($_REQUEST['newpassword'])) {
        sys_error("Password is not specified.");
    }

    sys_error("Not implemented.\nThe information submitted is:\n".
    json_encode(array(
        "_REQUEST" => $_REQUEST,
        "_POST" => $_POST,
        "_GET" => $_GET,
        "_COOKIE" => $_COOKIE,
    )));
}

?>
