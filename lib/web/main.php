<?php
/******* Fonctions en Interface avec le Web ********/

/**
 * Check if a website is online
 *
 * @param      string  $site   Website adress
 *
 * @return     bool  online or not
 */
function siteStatus($site)
{
	$fp = @fsockopen($site, 80, $errno, $errstr, 1);

	return $fp;
}

/**
 * Check if a server is online
 *
 * @param      <type>  $server  server adress
 * @param      <type>  $port    server port
 *
 * @return     bool    online or not
 */
function serverStatus($server,$port)
{
	$fp = @fsockopen($server,$port, $errno, $errstr, 1);

	$online=($fp >= 1)?true:false;
	
	return $online;
}

/**
 * Gets average ping
 *
 * @return     integer  average ping
 */
function averagePing() {
	$hosts = array('google.com', 'wikipedia.org','twitter.com');
	
	$pings = array();
	$aping = 0;
	$i = 0;

	foreach ($hosts as $host) {
   		exec('ping -qc 1 '.$host, $ping);
   		$exploded = explode("=",$ping[3]);
   		$exploded = explode("/",$exploded[1]);
		$aping=$aping+intval($exploded[1]);
		$i++;
	}	
	$aping = ceil($aping/$i);
	
	return $aping;
}

/**
 * Get local and wan ip
 *
 * @return     array  data
 */
function ipConfig()
{
	$ipa = array();
    $ipa['lan']= $_SERVER['SERVER_ADDR'];
    $ipa['wan']= exec('curl http://ipecho.net/plain; echo');
	
	return $ipa;
}

?>