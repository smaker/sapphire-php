<!DOCTYPE html>
<html>
<head>
<title>{{ $title }}</title>
<!-- META -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<!-- CSS -->
<?php foreach(Core\Frontend::getCssFiles() as $file => $fileInfo) { ?>
<link rel="stylesheet" href="{{ $file }}" media="all">
<?php } ?>
<!-- JS -->
<?php foreach(Core\Frontend::getJsFiles() as $file => $fileInfo) { ?>
<script src="{{ $file }}"></script>
<?php } ?>
<script>
//<![CDATA[
ST.url = "<?php echo Core\Request::getRequestUri(); ?>";
ST.defaultUrl = "<?php echo (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/";
ST.requestURI = "<?php echo Core\Request::getRequestUri(); ?>";
//]]>
</script>
</head>
<body>
	{{ $content }}
</body>
</html>