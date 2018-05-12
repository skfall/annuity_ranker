<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

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
	<link rel="shortcut icon" href="{{ RS.'android-icon-48x48.png'}}">

	<?php /* STYLES */ ?>
	<link rel="stylesheet" type="text/css" href="{{ CSS.'app.css' }}">

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
	
	<div class="main_wrapper por">
		@yield("content")
	</div>

	

	<?php /* SCRIPTS */ ?>
	<script type="text/javascript" src="{{ JS.'jquery-2.2.4.min.js' }}"></script>
	<script type="text/javascript" src="{{ JS.'app.js' }}"></script>	
    
	@if ($config->bot_script)
		<script type="text/javascript">
			<?= $config->bot_script; ?>
		</script>
	@endif
</body>
</html>