<?php
/**
 * Plugin Name:     Conversion For Contact Form 7
 * Plugin URI:
 * Description:		An add-on plugin for the Contact Form 7 and Flamingo which measure any affiliates.
 * Author:			ko31
 * Author URI:
 * Text Domain:     conversion-for-cf7
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         conversion-for-cf7
 */

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

register_activation_hook( __FILE__, function() {
	if ( ! defined( 'WPCF7_VERSION' ) ) {
		deactivate_plugins( __FILE__ );
		exit( __( 'Sorry, Contact Form 7 is not installed.', 'conversion-for-cf7' ) );
	}
	if ( ! defined( 'FLAMINGO_VERSION' ) ) {
		deactivate_plugins( __FILE__ );
		exit( __( 'Sorry, Flamingo is not installed.', 'conversion-for-cf7' ) );
	}
});

ConversionForCf7::get_instance()->register();
