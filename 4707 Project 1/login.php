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
                if ($pwhash == $row['password']) {
                    setcookie($cookie_name, $userhash, 0, $cookie_path, $cookie_domain);
                    header("Location:".$row['type'].".php");
                } else { /************************ TODO: FIX ************************/
                    /*$failedlogins = $row['failedlogins'] + 1;
                    echo "<script type='text/javascript'>alert('Login attemps:".$failedlogins."');</script>";
                    if ($failedlogins >= 5) {
                        sys_error("You have exceeded the allowed number of login attempts. Please wait 5 minutes before trying again.");                        
                        $failedlogins = 0;
                        sleep(20);
                        header("Location:login.php");
                    }
                    $setFailures = "UPDATE users SET failedlogins = ".$failedlogins." WHERE username = '".$userhash."'";
                    $noResult = $conn->query($setFailures);
                    include "$template_dir/login.html";*/
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
    if (isset($_COOKIE[$cookie_name])) {
        echo "<p>".$_COOKIE[$cookie_name]."</p>";
    }
}

?>
