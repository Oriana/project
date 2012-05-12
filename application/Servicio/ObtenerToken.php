<?php
 require_once('../models/Token.php');
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "../../../library"));
	require_once("Zend/Rest/Server.php");
	
	$server = new Zend_Rest_Server();
	$server->setClass('Token');
	$server->handle();
?>
