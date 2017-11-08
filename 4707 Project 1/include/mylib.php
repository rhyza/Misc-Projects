<?php

// You can put commonly used functions here

require_once 'init.php';

function sys_error($str) {
    include	$GLOBALS['template_dir']."/error.html";
    die("");
}

?>
