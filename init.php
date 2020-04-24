<?php
define('IN_WEB', true);
defined('IN_WEB') or die();

// laika uzņemšanas funkcija
function start_loading(){
	$starttime = microtime();
	$startarray = explode(" ", $starttime);
	return $startarray[1] + $startarray[0];
}

$start_time = start_loading();
require 'config.php';
require INCLUDES_PATH . 'functions.php';
require INCLUDES_PATH . 'page.php';

if(!session_id()) {
    session_start();
}

if(count($_POST)){
	if(isset($_SESSION['dup_post']) && $_SESSION['dup_post'] > time()){
		foreach($_POST as $key => $index){
			unset($_POST[$key]);
		}
	}else{
		$_SESSION['dup_post'] = time()+1;
	}
}

if(DB_HOST && DB_USER && DB_BASE){
	$db = new db(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
}

$page = new page();

define('SITE_TITLE', 'New site');
define('DEFAULT_PAGE', 'index');

/*
	Lai lapa darbotos no jebkuras mapītes
*/
$segments = explode('/', 'https://' . $_SERVER['HTTP_HOST']);
$segments_real = count($segments);
$segments_del  = $segments_real - 2;
$segments = explode('/', $_SERVER['REQUEST_URI']);
for($i=1;$i<=$segments_del;$i++){
	array_shift($segments);
}

$_SERVER['REQUEST_URI'] = '/' . implode('/', $segments);
$segments = split_to_segments($_SERVER['REQUEST_URI']);
segments_to_get($segments);

$page->set_theme(THEME_PATH . 'index.php');

ob_start();
if(get_get('act') && file_exists(PAGES_PATH . '/' . get_get('act') . '.php')){
	require PAGES_PATH . get_get('act') . '.php';
}else{
	
	require PAGES_PATH . DEFAULT_PAGE . '.php';
}

$page->set_page_content(ob_get_contents());
ob_end_clean();
