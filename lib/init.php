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
	global $currentpage;

	/* Detect current page, used for cache and some modules */
		$currentpage = explode("?",$_SERVER['REQUEST_URI'])[0];
		// Strtolower
		$currentpage = strtolower($currentpage);
		// Strip .* et /
		$currentpage = str_replace(".php", "", $currentpage);
		$currentpage = str_replace(".html", "", $currentpage);
		$currentpage = str_replace(".htm", "", $currentpage);
		$currentpage = str_replace("/", "", $currentpage);
		// Index verif
		if($currentpage=="") {
		    $currentpage = "index";
		}
		
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

	if(isset($config['website_custom_name'][$currentpage])) {
		echo "<title>".$config['website_custom_name'][$currentpage]."</title>";
	} else {
		echo "<title>".$config['website_name']."</title>";
	}

	if(!isset($config['website_css']) || $config['website_css']=="") {
		$config['website_css'] = "./lib/css/style.css";
	}

	if(!isset($config['website_favicon']) || $config['website_favicon']=="") {
		$config['website_favicon'] = "./img/favicon.png";
	}

	if(isset($config['website_theme_color']) && (strlen($config['website_theme_color'])==7 || strlen($config['website_theme_color'])==4)) {
		echo '<meta name="theme-color" content="'.$config['website_theme_color'].'">';
	}

	if(isset($config['website_custom_keywords'][$currentpage])) {
		$keywords = $config['website_custom_keywords'][$currentpage];
	} else {
		$keywords = META_KEYS;
	}

	if(isset($config['website_custom_desc'][$currentpage])) {
		$description = $config['website_custom_desc'][$currentpage];
	} else {
		$description = META_DESC;
	}
?>
<meta charset="UTF-8">
<!-- On prepare le charset , les mots clés , le fichier css et l'icone du site -->
<meta name="keywords" content="<?php echo $keywords; ?>">
<meta name="description" content="<?php echo $description; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" type="image/png" href="<?php echo $config['website_favicon']; ?>"/>
<?php if(!$config['website_css_disabled']) { ?>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo $config['website_css']; ?>"/>
<?php
}
echo $config['website_custom_head'];

if(!isset($config['website_disable_head_end']) || $config['website_disable_head_end'] == false) {
?>
</head>
<body>
<?php
}
	/* Cookies prevention panel */
	if($config['module_cookies']) {
		drawCookiePreventionPanel();
	}
}

LoadIt();