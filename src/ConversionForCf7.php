<?php

class ConversionForCf7
{
	private $prefix = 'conversion-for-cf7';

	public function __construct() {
	}

	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new ConversionForCf7();
		}
		return $instance;
	}

	public function register()
	{
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	public function plugins_loaded()
	{
		load_plugin_textdomain( $this->get_prefix(), false, 'conversion-for-cf7/languages' );
		if ( is_admin() ) {
			ConversionForCf7\Admin::get_instance()->register();
		} else {
			ConversionForCf7\Action::get_instance()->register();
			ConversionForCf7\Module\A8::get_instance()->register();
		}
	}

	public function get_prefix() {
		return $this->prefix;
	}

	public function get_option( $key, $default = null ) {
		$option = get_option( $this->get_prefix(), array() );
		if ( ! empty( $option[ $key ] ) && trim( $option[ $key ] ) ) {
			return trim( $option[ $key ] );
		} else {
			return $default;
		}
	}
}
