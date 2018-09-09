<?php
	include('svg.php'); 
	$SVG = new SVGFactory();
	header('Content-Type: text/html');
	$redirect = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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


		<!-- Development styles for this template -->
		<link href="/assets/css/root.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/theme.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/header.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/sidebar.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/footer.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/login.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/error.css" rel="stylesheet" type="text/css">
		<!-- Compiled styles -->
		<link href="/assets/css/styles.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/grid.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/post.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/comments.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/artbar.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/debug.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/reply.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/grid--list.css" rel="stylesheet" type="text/css">
		<link href="/assets/css/board_sorter.css" rel="stylesheet" type="text/css">
		<noscript>
	    	<link href="/assets/css/no-js.css" type="text/css" rel="stylesheet" />
		</noscript>
	</head>
	