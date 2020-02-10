<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= lang('default.00001'); ?></title>
	<?php
	if (isset($meta) && !empty($meta)) {
		foreach ($meta as $name => $content) {
			?>
			<meta name="<?= $name ?>" content="<?= $content; ?>">
			<?php
		}
	}
	?>
	<meta charset="utf-8">
	<?php
	$css_array = [
		'assets/vendor/twbs/bootstrap/dist/css/bootstrap.min.css',
		'assets/vendor/components/font-awesome/css/fontawesome-all.min.css',
		'assets/vendor/components/jqueryui/themes/base/jquery-ui.min.css',
		'assets/vendor/sweetalert2/sweetalert2/dist/sweetalert2.min.css',
		'assets/css/default.css',
	];
	foreach ($css_array as $css_file) {
		if (file_exists($css_file)) {
			?>
			<link href="<?php echo base_url($css_file) . '?v=' . filemtime($css_file); ?>" rel="stylesheet"
				  type="text/css">
			<?php
		}
	}
	?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
		  integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<?php
	$js_array = [
		'assets/vendor/components/jquery/jquery.min.js',
		'assets/vendor/twbs/bootstrap/site/docs/4.1/assets/js/vendor/popper.min.js',
		'assets/vendor/components/jqueryui/jquery-ui.min.js',
		'assets/vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
		'assets/vendor/sweetalert2/sweetalert2/dist/sweetalert2.all.min.js',
		'assets/js/fireflies.js',
	];
	foreach ($js_array as $js_file) {
		if (file_exists($js_file)) {
			?>
			<script src="<?php echo base_url($js_file) . '?v=' . filemtime($js_file); ?>"></script>
			<?php
		}
	}
	?>
	<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>
	<meta name="csrf-name" content="<?= get_instance()->security->get_csrf_token_name() ?>"/>
	<meta name="csrf-token" content="<?= get_instance()->security->get_csrf_hash() ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<header>
</header>
<main id="main-container">
	<?php
	if (isset($view)) {
		$this->load->view($view);
	}
	?>
</main>
</body>
</html>
