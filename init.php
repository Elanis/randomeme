<?php 
$debut = round(microtime(true) * 1000);

$config = parse_ini_file('config.ini'); ?>
<!DOCTYPE html>
<!-- 
	Code by Elanis
	Copyright <?php echo $config['website_creation'].'-'.date('Y'); ?> 
	Don't copy this without permission
	I hope this code is readable.
-->
<html>
<head>
<?php
session_start();

/* JUST LOAD IT ! */
function LoadIt() {
	/* Get Vars from Config */
	global $config;
	
	/* Create global vars */
	global $sqlDB;
	global $mongoDB;
	global $lang;
	global $user;

	/* Include all modules */
	foreach ($config as $config_key => $config_value) {
		if(strpos($config_key, 'module_') !== false && $config_value==true) {
			require_once(str_replace("module_","",$config_key).'/main.php');
		}
	}
	/* SQL Launch */
	$sqlDB = ($config['module_sql'])?new sqlInterface($config['sql_host'],$config['sql_database'],$config['sql_username'],$config['sql_password'],$config['sql_port']):null;

	/* Mongo Launch */
	$mongoDB = ($config['module_mongodb'])?new mongoInterface($config['mongo_host']):null;

	/* Translate */
	$lang = ($config['module_lang'])?new Language():null;

	/* If not translation, we force some constants */
	if(!$config['module_lang']) {
		define('META_KEYS',$config['website_keywords']);
		define('META_DESC',$config['website_desc']);
	}

	/* Utilisateurs */
	$user = ($config['module_users'])?new User($_SESSION):null;

	/* Dev - Errors */
	if($config['website_dev']) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}
	if(!isset($_SESSION['website_default-maxperpage'])) {
		$_SESSION['default-maxperpage'] = $config['website_default-maxperpage'];
	}

	echo "<title>".$config['website_name']."</title>";

	if(!isset($config['website_css']) || $config['website_css']=="") {
		$config['website_css'] = "./lib/css/style.css";
	}

	if(!isset($config['website_favicon']) || $config['website_favicon']=="") {
		$config['website_favicon'] = "./img/favicon.png";
	}

	if(isset($config['website_theme_color']) && (strlen($config['website_theme_color'])==7 || strlen($config['website_theme_color'])==4)) {
		echo '<meta name="theme-color" content="'.$config['website_theme_color'].'">';
	}
?>
<meta charset="UTF-8">
<!-- On prepare le charset , les mots clés , le fichier css et l'icone du site -->
<meta name="keywords" content="<?php echo META_KEYS; ?>">
<meta name="description" content="<?php echo META_DESC; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" type="image/png" href="<?php echo $config['website_favicon']; ?>"/>
<?php if(!$config['website_css_disabled']) { ?>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo $config['website_css']; ?>"/>
<?php
}
echo $config['website_custom_head'];
?>
</head>
<body>
<?php
	/* Cookies prevention panel */
	if($config['module_cookies']) {
		drawCookiePreventionPanel();
	}
}

LoadIt();