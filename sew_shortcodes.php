<?php

require_once __DIR__ . "/sew_defines.php";

function sew_contact_form() { 
	$form = file_get_contents(__DIR__."/contact_form.html");
	return $form;
}
add_shortcode(CONTACT_SHORTCODE, 'sew_contact_form');

function sew_costumer_area_form() { 
	$form = file_get_contents(__DIR__."/saltos_login_form.html");
	$saltos = get_option(PLUGIN_OPTIONS)[SALTOS_URL_OPTION];
	return str_replace("%SALTOS_HOST%", $saltos, $form);
}
add_shortcode(LOGIN_SHORTCODE, 'sew_costumer_area_form');

function sew_tracking_form() { 
	$form = file_get_contents(__DIR__."/tracking_form.html");
	return $form;
}
add_shortcode(TRACKING_SHORTCODE, 'sew_tracking_form');

?>
