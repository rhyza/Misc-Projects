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

/* Add New User */
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'addUser') {
    if (strlen($_REQUEST['username']) > 3 && strlen($_REQUEST['newpw1']) > 5 && $_REQUEST['newpw1'] == $_REQUEST['newpw2']) {
    	if (empty($_REQUEST['newtype']) || strtolower($_REQUEST['newtype']) != "user" || strtolower($_REQUEST['newtype']) != "admin") {
            sys_error("User type not specified.");
        } else {
            $type = strtolower($_REQUEST['newtype']);
            $userhash = hash('sha256', $_POST['username']);

            $sql = "SELECT * FROM users WHERE username = '".$userhash."'";
            $result = $conn->query($sql);

            if ($result->num_rows <= 0) {
            	$salt = time();
                $passhash = hash('sha256', $_POST['newpw1'].$salt);

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
        } 
    } else {
        sys_error("Invalid username or password.");
    }

/* Modify Existing User */
} else if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'modUser') {
    if (!empty($_REQUEST['username'])) {
        $userhash = hash('sha256', $_POST['username']);

        $sql = "SELECT username, salt FROM users WHERE username = '".$userhash."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        	// change password
            if (!empty($_REQUEST['pw1'])) {
            	if (strlen($_REQUEST['pw1']) > 5 &&  $_REQUEST['pw1'] == $_REQUEST['pw2']) {
            		$passhash = hash('sha256', $_POST['pw1'].$row['salt']);

            		$pwsql = "UPDATE users SET password = '".$passhash."' WHERE username = '".$userhash."';";
            		$pwresult = $conn->query($pwsql);
            	} else {
            		sys_error("Invalid password.");
            	}
            }

            // change type
            if (!empty($_REQUEST['modtype'])) {
            	if (strtolower($_REQUEST['newtype']) == "user" || strtolower($_REQUEST['newtype']) == "admin") {
            		$typesql = "UPDATE users SET type = '".$passhash."' WHERE username = '".$userhash."';";
            		$typeresult = $conn->query($typesql);
            	} else {
            		sys_error("Invalid user type.");
            	}
            }

            // delete user
            if ($_REQUEST['delete'] == "DELETE") {
            	$delsql = "";
            	$delresult = $conn->query($delsql);
            }
        } else {
            sys_error("User ".$_POST['username']." does not exist.");
        }
    } else {
        sys_error("Username is not specified.");
    }
}

?>
