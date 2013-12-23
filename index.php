<?php
include 'bootstrap.php';

try {
	$controller = new Controller_Main();
	$action = (isset($_REQUEST['action']) && null !== $_REQUEST['action']) ? $_REQUEST['action'] : 'list';
	$controller->{$action.'Action'}();
	
} catch(Exception $e) {
	header('HTTP/1.0 404 Not Found');
	die;
}