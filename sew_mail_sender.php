<?php
/*
 *THIS FUNCTION ALLOWS TO RECEIVE AJAX REQUEST USING WP-API TO SEND A CONTACT FORM VIA MAIL
 */

add_action('rest_api_init', function () {
  register_rest_route('contact-form', '/send-email', array(
    'methods' => 'POST',
    'callback' => 'send_contact_form_email'
  ));
});
add_action('wp_ajax_send_contact_form_email', 'send_contact_form_email');
add_action('wp_ajax_nopriv_send_contact_form_email', 'send_contact_form_email');

function send_contact_form_email() {
	// Get form data
	$json = file_get_contents('php://input');
	
	// Decode the JSON data into a PHP array
	$data = json_decode($json, true);
	
	// Access the data using the keys in the array
	$name = $data['name'];
	$email = $data['email'];
	$subject = $data['subject'];
	$message = $data['message'];
	$order_number = $data['order_number'];

	// Set email recipient
	$to = get_option(PLUGIN_OPTIONS)[CF_MAIL_OPTION];
	$sub_pref = get_option(PLUGIN_OPTIONS)[CF_SUBJECT_OPTION];

	// Build email message
	$subject = '['.$sub_pref.']['.$order_number.'] '.$subject;
	$body =  '<h1>Name</h1>';
	$body .= '<p>'.$name.'</p>';
	$body .= '<h1>Email</h1>';
	$body .= '<p>'.$email.'</p>';
	$body .= '<h1>Order Number</h1>';
	$body .= '<p>'.$order_number.'</p>';
	$body .= '<h1>Message</h1>';
	$body .= '<p>'.$message.'</p>';

	// Send email
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$result = wp_mail($to, $subject, $body, $headers);

	// Send response
	if ($result) {
		echo json_encode(array('success' => true));
	} else {
		echo json_encode(array('error' => 'Sorry, there was an error sending your message. Please try again later.'));
	}

}

?>
