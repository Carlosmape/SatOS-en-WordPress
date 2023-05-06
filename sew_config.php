<?php 

require_once __DIR__ . "/sew_defines.php";

function saltos_admin_init() {
	// Register a new setting for "saltos_wp" page.
	register_setting( PLUGIN_NAME, PLUGIN_OPTIONS );
	
	// Register a new section in the "saltos_wp" page.
	add_settings_section(
		PLUGIN_SECTION_DB,
		__( 'Configure SaltOS instance', PLUGIN_NAME ),
	   	'saltos_settings_section',
		PLUGIN_NAME
	);

	// ADD FIELDS FOR DB CONNECTION //
	add_settings_field(
		SALTOS_URL_OPTION,
		__( 'SaltOS URL', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME, PLUGIN_SECTION_DB,
		array(
			'type'	=> 'text',
			'name'	=> SALTOS_URL_OPTION,
			'desc'	=> 'The URL where your SaltOS platform runs. Where you connect to the platform'
		)
	);

	add_settings_field(
		DB_HOST_OPTION,
		__( 'DB Host', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME, PLUGIN_SECTION_DB,
		array(
			'type'	=> 'text',
			'name'	=> DB_HOST_OPTION,
			'desc'	=> 'Indicates the IP or URL where your SaltOS DB platform runs'
		)
	);

	add_settings_field(
		DB_PORT_OPTION,
		__( 'Port', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME,
		PLUGIN_SECTION_DB,
		array(
			'type'	=> 'number',
			'name'  => DB_PORT_OPTION,
			'desc'	=> 'Port'
		)
	);

	add_settings_field(
		DB_USR_OPTION,
		__( 'User', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME,
		PLUGIN_SECTION_DB,
		array(
			'type'	=> 'text',
			'name'  => DB_USR_OPTION,
			'desc'	=> 'User'
		)
	);

	add_settings_field(
		DB_PWD_OPTION,
		__( 'Password', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME,
		PLUGIN_SECTION_DB,
		array(
			'type'	=> 'password',
			'name'  => DB_PWD_OPTION,
			'desc'	=> 'DB Password'
		)
	);
	
	// Register a new section in the "saltos_wp" page.
	add_settings_section(
		PLUGIN_SECTION_CF,
		__( 'Configure Contact Form'), 'saltos_settings_section',
		PLUGIN_NAME
	);
	add_settings_field(
		CF_MAIL_OPTION,
		__( 'Contact form e-mail', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME, PLUGIN_SECTION_CF,
		array(
			'type'	=> 'email',
			'name'	=> CF_MAIL_OPTION,
			'desc'	=> 'Indicates the e-mail of the company Costumer Atention Service for the contact formulary'
		)
	);
	add_settings_field(
		CF_SUBJECT_OPTION,
		__( 'Contact form subject', PLUGIN_NAME ),
		'saltos_render_input',
		PLUGIN_NAME, PLUGIN_SECTION_CF,
		array(
			'type'	=> 'text',
			'name'	=> CF_SUBJECT_OPTION,
			'desc'	=> 'Indicates a text to insert in the Subject of the mails sent from the contact form'
		)
	);

}
add_action( 'admin_init', 'saltos_admin_init' );


function saltos_settings_section( $args ) {
?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>">

<?php
	if ($args['id'] == PLUGIN_SECTION_DB) {
		esc_html_e( 'You can use following shortcodes: ['.LOGIN_SHORTCODE.'] and ['.TRACKING_SHORTCODE.']', PLUGIN_NAME ); 
	}
	else if ($args['id'] == PLUGIN_SECTION_CF) {
		esc_html_e( 'You can use following shortcode: ['.CONTACT_SHORTCODE.']', PLUGIN_NAME ); 
	}
?>
</p>
<?php
}

function saltos_render_input( $args ) {
	// Get the value of the setting we've registered with register_setting()
	$type = esc_attr($args['type']);
	$name = esc_attr($args['name']);
	$desc = esc_html($args['desc']);
	$last_value = get_option(PLUGIN_OPTIONS)[$name];
?>
	<input type="<?= $type ?>" id="<?= $name; ?>" name="<?= PLUGIN_OPTIONS ?>[<?= $name ?>]" value="<?= $last_value; ?>" required>
	<p class="description"><?= $desc; ?></p>
<?php
}

function saltos_admin_menu() {
	add_menu_page(
		PLUGIN_NAME,
		PLUGIN_NAME,
		'manage_options',
		PLUGIN_NAME,
		'render_saltos_settings',
		'dashicons-rest-api'
	);
}
add_action( 'admin_menu', 'saltos_admin_menu' );


function render_saltos_settings() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		//
		var_dump($_GET);
		add_settings_error( PLUGIN_MESSAGES, PLUGIN_MESSAGES, __( 'Settings Saved', PLUGIN_NAME ), 'updated' );
	}

	// show error/update messages
	settings_errors( PLUGIN_MESSAGES );
?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<form action="options.php" method="post">
<?php
	settings_fields( PLUGIN_NAME );
	do_settings_sections( PLUGIN_NAME );
	submit_button( 'Save Settings' );
?>
		</form>
	</div>
<?php
}
?>
