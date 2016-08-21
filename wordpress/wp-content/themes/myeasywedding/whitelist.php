<?php

$whitelist = array('127.0.0.1', "::1");
 
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
include_once($_SERVER['DOCUMENT_ROOT'].'/mew/wordpress/wp-load.php' );
	
} else {
include_once($_SERVER['DOCUMENT_ROOT'].'wp-load.php' );
}

?>