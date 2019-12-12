<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
	Definējam lapas konstantes
*/
define('BASE_PATH', dirname(__FILE__));
define('INCLUDES_PATH', BASE_PATH . '/includes/');
define('PAGES_PATH', BASE_PATH . '/pages/');
define('LANGUAGES_PATH', INCLUDES_PATH . 'languages/');
define('PLUGINS_PATH', BASE_PATH . '/plugins/');
define('PANELS_PATH', BASE_PATH . '/panels/');
define('THEME_PATH', BASE_PATH . '/theme/');
define('UPLOADS_PATH', BASE_PATH . '/uploads/');

define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_BASE', '');

define('SITE_URL', (isset($_SERVER['HTTP_HOST']) ? 'https://' . $_SERVER['HTTP_HOST'] : '/'));

define('REF', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']: false );
define('MY_IP', isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''));