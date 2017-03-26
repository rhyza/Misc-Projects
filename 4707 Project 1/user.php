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
	        	include "$template_dir/user.html";
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
?>
