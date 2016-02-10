<?php

function create_link($text, $url) {
	return "<a href=\"{$url}\">{$text}</a>";
}

function connect_database() {
	$hostname = 'localhost';
	$username = 'php';
	$password = '';
	$database = 'saw';

	$conn = new mysqli($hostname, $username, $password, $database);

	if ($conn->connect_error) {
		die("Connection Error: " . $conn->connect_error);
	}

	return $conn;
}

function endswith($string, $test) {
	$strlen = strlen($string);
	$testlen = strlen($test);
	if ($testlen > $strlen) return false;
	
	return substr_compare($string, $test, $strlen-$testlen, $testlen) === 0;
} 

function strip_end_slash($string) {
	if (endswith($string, "/")) {
		return substr($string, 0, strlen($string)-1);
	}
	else return $string;
}

?>
