<?php
session_start();
require_once('../models/Persona.php');
	set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "../../../library"));

	require_once("../../library/Zend/Rest/Server.php");
	 session_start();
	$server = new Zend_Rest_Server();
	$server->setClass('Persona');
	$server->handle();
        session_start();
        
?>
