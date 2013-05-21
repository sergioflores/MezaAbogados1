<?php
	require_once '../Meza/library/Zend/Loader.php';
	require_once '../Meza/library/Zend/Gdata.php';
	
	echo "Service initializing...";
	$service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
	$user = "gader.services@gmail.com";
	$pass = "pwd12345";
	echo "Creating credentials";
	// Create an authenticated HTTP client
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
 
	// Create an instance of the Calendar service
	$service = new Zend_Gdata_Calendar($client);
	echo $service;
