<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0"/>
	<meta name="format-detection" content="telephone=no">
	
	<title>{{ $meta->get('meta_title') }}</title>
	<meta name="keywords" content="{{ $meta->get('meta_keys') }}" />
	<meta name="description" content="{{ $meta->get('meta_desc') }}" />
	<meta name="_token" content="{{ csrf_token() }}">

	@if($config->site_index)
		<meta name="robots" content="index, follow" />
	@else
		<meta name="robots" content="noindex, nofollow" />
	@endif


	
	<meta name="author" content="Positive Business" />
	<!-- favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="{{ IMG.'favicon/apple-icon-57x57.png' }}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{ IMG.'favicon/apple-icon-60x60.png' }}">
	<link rel="apple-touch-icon" sizes="72x72" href=" {{ IMG.'favicon/apple-icon-72x72.png' }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ IMG.'favicon/apple-icon-76x76.png' }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ IMG.'favicon/apple-icon-114x114.png' }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ IMG.'favicon/apple-icon-120x120.png' }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ IMG.'favicon/apple-icon-144x144.png' }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ IMG.'favicon/apple-icon-152x152.png' }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ IMG.'favicon/apple-icon-180x180.png' }}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{{ IMG.'favicon/android-icon-192x192.png' }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ IMG.'favicon/favicon-32x32.png' }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ IMG.'favicon/favicon-96x96.png' }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ IMG.'favicon/favicon-16x16.png' }}">
	<link rel="manifest" href="{{ IMG.'favicon/manifest.json' }}">
    <meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{ IMG.'favicon/ms-icon-144x144.png' }}">
    <meta name="theme-color" content="#ffffff">

	<?php /* STYLES */ ?>
	<link rel="stylesheet" type="text/css" href="{{ CSS.'app.css' }}">
	<link rel="stylesheet" type="text/css" href="{{ CSS.'styles.min.css' }}">

	@if ($config->top_script)
		<script type="text/javascript">
			<?= $config->top_script; ?>
		</script>
	@endif
</head>
<body class="{{ $body_class }}">
	<script type="text/javascript">
		var RS = '<?= RS; ?>';
		var LANG = '<?= LANG; ?>';
		var PAGE = '<?= PAGE; ?>';
	</script>
	

	@include('elements.header')
	<main class="main_wrapper por page-content">
		@yield("content")
	</main>
	@include('elements.footer')
	
	

	<?php /* SCRIPTS */ ?>
	<script type="text/javascript" src="{{ JS.'scripts.min.js' }}"></script>	
	<script type="text/javascript" src="{{ JS.'app.js' }}"></script>	
    
	@if ($config->bot_script)
		<script type="text/javascript">
			<?= $config->bot_script; ?>
		</script>
	@endif
</body>
</html>