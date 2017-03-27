<?php
// side effect: initializes database and cookies if not set
require_once 'init.php';

if (isset($_REQUEST['act']) == 'login') {
    if (!empty($_REQUEST['username'])) {
        $userhash = hash('sha256', $_POST['username']);

        $sql = "SELECT username, password, salt, type, failedlogins FROM users WHERE username = '".$userhash."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $salt = $row['salt'];
                $pwhash = hash('sha256', $_POST['password'].$salt);
                $failedlogins = $row['failedlogins'];
                
                if ($failedlogins >= 5) {
                    $failedlogins = 0;
                    echo "<script type='text/javascript'>alert('Login attemps:".$failedlogins."');</script>";
                    sleep(300);
                }

                if ($pwhash == $row['password']) {
                    setcookie($cookie_name, $userhash, 0, $cookie_path, $cookie_domain);
                    $failedlogins = 0;
                    $setFailures = "UPDATE users SET failedlogins = ".$failedlogins." WHERE username = '".$userhash."'";
                    $noResult = $conn->query($setFailures);
                    header("Location:".$row['type'].".php");
                } else {
                    $failedlogins = $failedlogins + 1;
                    $setFailures = "UPDATE users SET failedlogins = ".$failedlogins." WHERE username = '".$userhash."'";
                    $noResult = $conn->query($setFailures);
                    sys_error("Invalid username or password.");
                }
            }
        } else {
            sys_error("Invalid username or password.");
        }
    } else {
        sys_error("Username is not specified.");
    }
}
else {
    include "$template_dir/login.html";
}

?>
