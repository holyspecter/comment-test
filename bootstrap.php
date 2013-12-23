<?php
session_start();

define('CT_ROOT', __DIR__);
define('CT_DB_PATH', CT_ROOT.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'comment_test.db');
define('CT_COMMENTS_PER_PAGE', 5);

// Classes loading
spl_autoload_register(function($class){
	include CT_ROOT.DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';	
});