<?php
// side effect: initializes database and cookies if not set
require_once 'init.php';

if (isset($_COOKIE[$cookie_name])) {
    $sql = "SELECT type FROM users WHERE username = '".$_COOKIE[$cookie_name]."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $type = $row['type'];
            if ($type == "user") {
                if (!isset($_REQUEST['act']) == 'changePassword') {
                    include "$template_dir/account.html";
                }
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
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'changePassword') {
    if (!empty($_REQUEST['oldpassword']) && strlen($_REQUEST['newpassword1']) > 5 && $_REQUEST['newpassword1'] == $_REQUEST['newpassword2']) {
        $userhash = $_COOKIE[$cookie_name];

        $sql = "SELECT username, password, salt FROM users WHERE username = '".$userhash."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $salt = $row['salt'];
                $oldpasshash = hash('sha256', $_REQUEST['oldpassword'].$salt);

                if ($oldpasshash == $row['password']) {
                    $newpasshash = hash('sha256', $_REQUEST['newpassword1'].$salt);

                    $pwsql = "UPDATE users SET password = '".$newpasshash."' WHERE username = '".$userhash."';";
                    $pwresult = $conn->query($pwsql);
                } else {
                    sys_error("Invalid password.");
                }
            }
            include "$template_dir/pageheader.html";
            echo "<div class='alert alert-success' role='alert'><strong>Your password has been updated.</strong></div>";
        }
    } else {
        sys_error("Invalid password.");
    }
}

?>
