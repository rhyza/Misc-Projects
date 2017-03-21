<?php

// You can put commonly used functions here

function sys_error($str) {
    include	$GLOBALS['template_dir']."/error.html";
    die("");
}

?>
