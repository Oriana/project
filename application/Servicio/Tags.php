<?php

require_once('../models/Tags.php');
	set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "../../../library"));

	require_once("../../library/Zend/Rest/Server.php");
	
	$server = new Zend_Rest_Server();
	$server->setClass('Tags');
	$server->handle();
?>
