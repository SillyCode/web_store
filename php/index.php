<?php

require_once('../utils/template.php');

function tabs() {
	$filenames = glob('*.php');
	return array_map(function($filename) {
		$filename = str_replace(' ','_', pathinfo ($filename,  PATHINFO_FILENAME));
		return array('url' => urlencode($filename) . '.php', 'text' => ucwords($filename));
	}, array_filter($filenames, function($filename) {
		return ($filename != 'index.php');
	}));
}

function content() {
	$requested_url = ($_SERVER['REQUEST_URI']);
	$class = str_replace('_','+', strtolower($requested_url));
// 	var_dump($class);
	ob_start();
// 	$class::render();
	return ob_get_clean();
}

$tpl = new template('index.tpl');
$tpl->tabs = tabs();
$tpl->content = content();
$tpl->render();

?>
