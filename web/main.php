<?php
/******* Fonctions en Interface avec le Web ********/

/* siteStatus
INPUT : site ( string )
OUTPUT : online ( bool ) */

function siteStatus($site)
{
	$fp = @fsockopen($site, 80, $errno, $errstr, 1);

	return $fp;
}

/* serverStatus
INPUT : server ( string ) , port ( string )
OUTPUT : online ( bool ) */

function serverStatus($server,$port)
{
	$fp = @fsockopen($server,$port, $errno, $errstr, 1);

	$online=($fp >= 1)?true:false;
	
	return $online;
}

/* averagePing
INPUT : -
OUTPUT : average ping ( int ) */

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

/* ipConfig
INPUT: -
OUPUT: ip's ( table ) */

function ipConfig()
{
	$ipa = array();
    $ipa['lan']= $_SERVER['SERVER_ADDR'];
    $ipa['wan']= exec('curl http://ipecho.net/plain; echo');
	
	return $ipa;
}

?>