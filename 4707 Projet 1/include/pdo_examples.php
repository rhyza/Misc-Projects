<?php

if (! defined('PDO::ATTR_DRIVER_NAME')) {
    die ('PDO unavailable');
}

if (1) {
    echo '<html> <head> <meta charset="UTF-8"> </head> <body> <PRE>';
}

require "../config.php";
$db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

$table_name = "users";

// use the connection here

$sql =  "SELECT * FROM $table_name LIMIT 5";

// two ways to get all the rows from a table
if (1) {
    $res = $db->query($sql);
    while ($row = $res->fetch()) {
	print_r($row);
    }
}
else {

    // another way to get all rows   
    foreach ($db->query($sql) as $row) {
	var_dump($row);
    }
}
echo "</PRE></BODY></HTML>";

$db = null;

// You can use $db->query to perform 'DELETE', 'UPDATE', 'INSERT'. 
// You may create $db in init.php and implement some functions in mylib.php
// (or in another file, or add another layer of abstraction by implmenting your own class)
// to perform different operations. If you decide to change anything related
// to database, you can just change your libarary functions, instead of 
// everywhere you have database operation.

?>
