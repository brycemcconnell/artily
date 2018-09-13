<?php
	include('svg.php'); 
	$SVG = new SVGFactory();
	header('Content-Type: text/html');
	if (!isset($_GET["redirect"])) {
		$redirect = "redirect=//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	} else {
		$redirect = "redirect=".$_GET["redirect"];
	}
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="/favicon.ico">

		<title>artily</title>


		<link href="/assets/css/main.css" rel="stylesheet" type="text/css">
		<noscript>
	    	<link href="/assets/css/no-js.css" type="text/css" rel="stylesheet" />
		</noscript>
	</head>
	