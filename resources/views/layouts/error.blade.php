<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>404</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="_token" content="{{ csrf_token() }}">

	<meta name="robots" content="noindex, nofollow" />
	
	<meta name="author" content="Positive Business" />
	
	<?php /* STYLES */ ?>
	<link rel="stylesheet" type="text/css" href="{{ '/css/materialize.min.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ '/css/jquery.fancybox.min.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ '/css/aos.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ '/css/animate.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ '/css/app.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ '/css/fonts.css' }}">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ '/css/flag-icon.min.css' }}">
	
</head>
<body class="">



	<div class="main_wrapper por">
		@include('elements.preloader')
		@yield("content")
	</div>

	<?php /* SCRIPTS */ ?>
	<script type="text/javascript" src="{{ '/js/jquery-2.2.4.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/js/materialize.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/js/jquery.fancybox.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/js/jquery.maskedinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/js/aos.js' }}"></script>
	<script type="text/javascript" src="{{ '/js/app.js' }}"></script>

</body>
</html>