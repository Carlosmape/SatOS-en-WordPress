<?php
/*
Plugin Name:  SaltOS integration with WordPress
Plugin URI:   
Description:  A short little description of the plugin. It will be displayed on the Plugins page in WordPress admin area. 
Version:      0.1
Author:       Carlosmape
Author URI:   
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  
Domain Path:  
 */

/* require "wp-includes/class-wp-widget.php" */

class SaltOSContactForm extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'SaltOSContactForm',
			'description' => 'Contact form integrated in SaltOS platform',
		);
		parent::__construct( 'SaltOSContactForm', 'SaltOSContactForm', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$pngecontents = file_get_contents(__DIR__."/contact_form.html");
    	echo str_replace("Banana", "Pineapple", $pagecontents);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'SaltOSContactForm' );
});

require __DIR__."/sew_config.php";

?>
