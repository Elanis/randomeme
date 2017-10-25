<?php
function encrypt($data) {
	$token = md5("***REMOVED***");
	$part1 = sha1($data);
	$part2 = $token."42".$part1;
	$part3 = hash('ripemd160', $part2);
	$part4 = hash('whirlpool', $part3."69");

	return $part4;
}
?>