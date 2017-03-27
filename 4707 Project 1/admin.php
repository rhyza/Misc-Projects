<?php
// side effect: initializes database and cookies if not set
require_once 'init.php';

if (isset($_COOKIE[$cookie_name])) {
    $sql = "SELECT type FROM users WHERE username = '".$_COOKIE[$cookie_name]."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $type = $row['type'];
            if ($type == "admin") {
                if (!isset($_REQUEST['act']) == 'addUser' and !isset($_REQUEST['act']) == 'findUser') {
                    include "$template_dir/admin.html";
                }
            } else {
                sys_error("You are not authorized to view this page.");
            }
        }
    } else {
        sys_error("You are not authorized to view this page.");
    }
    echo "<p>".$_COOKIE[$cookie_name]."</p>";
} else {
    sys_error("You are not authorized to view this page.");
}

if (isset($_REQUEST['act']) == 'addUser') {
    if (strlen($_REQUEST['username']) > 3 && strlen($_REQUEST['password1']) > 5 && $_REQUEST['password1'] == $_REQUEST['password2']) {
        $userhash = hash('sha256', $_POST['username']);
        $sql = "SELECT * FROM users WHERE username = '".$userhash."'";
        $result = $conn->query($sql);
        if ($result->num_rows <= 0) {
            $passhash = hash('sha256', $_POST['password1']);
            if (empty($_REQUEST['type'])) {
                $type = "user";
            } else {
                $type = $_REQUEST['type'];
            }

            $sql2 = "INSERT INTO users (username, password, salt, type, failedlogins) VALUES ('".$userhash."', '".$passhash."', ".time().", '".$type."', 0);";
            $result2 = $conn->query($sql2);
            // Success
            if ($result2) {
            	include "$template_dir/pageheader.html";
                echo "<div class='alert alert-success' role='alert'><strong>New ".$type." successfully created.</strong></div>";
            }
        } else {
            sys_error("User already exists.");
        }
    } else {
        sys_error("Invalid username or password.");
    }
} else {
    if (isset($_COOKIE[$cookie_name])) {
        echo "<p>".$_COOKIE[$cookie_name]."</p>";
    }
}

if (isset($_REQUEST['act']) == 'findUser') {
    if (!empty($_REQUEST['username'])) {
        $userhash = hash('sha256', $_POST['username']);
        $sql = "SELECT username FROM users WHERE username = '".$userhash."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            include "$template_dir/pageheader.html";
            echo "<h3>Modifying info for user ".$_POST['username']."</h3>";
            include "$template_dir/accountadmin.html";
        } else {
            sys_error("User ".$_POST['username']." does not exist.");
        }
    } else {
        sys_error("Username is not specified.");
    }
} else {
    if (isset($_COOKIE[$cookie_name])) {
        echo "<p>".$_COOKIE[$cookie_name]."</p>";
    }
}
?>
