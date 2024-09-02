<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


define('ROOT' , __DIR__.'/') ;
define('WEB_PATH' , "http://".$_SERVER['SERVER_NAME'].'/events-management/') ;
define('API_ROOT' , __DIR__.'/api/') ;
define('API_PATH' , __DIR__.'/api/controllers') ;
define('API_DOC_ROOT' , $_SERVER['SERVER_NAME'].'/events-management/index.php/api/') ;

include ROOT.'/inc/includes.php';
include ROOT.'/app/routes.php';
include API_ROOT.'/database/database.php';

loadEnv(ROOT.'/.env');


$path = $_SERVER['PATH_INFO'] ?? '/';

$server_obj = new server();
$server_obj->handle($path);







 

