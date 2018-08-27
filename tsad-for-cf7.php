<?php
/**
 * Plugin Name:     tsad
 * Plugin URI:
 * Description:
 * Author:
 * Author URI:
 * Text Domain:     tsad
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         tsad
 */

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

register_activation_hook( __FILE__, function() {
	if ( ! defined( 'WPCF7_VERSION' ) ) {
		deactivate_plugins( __FILE__ );
		exit( __( 'Sorry, Contact Form 7 is not installed.', 'tsad-for-cf7' ) );
	}
	if ( ! defined( 'FLAMINGO_VERSION' ) ) {
		deactivate_plugins( __FILE__ );
		exit( __( 'Sorry, Flamingo is not installed.', 'tsad-for-cf7' ) );
	}
});

TsadForCf7::get_instance()->register();
