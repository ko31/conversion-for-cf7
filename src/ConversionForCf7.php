<?php

use ConversionForCf7\Pattern\Singleton;

class ConversionForCf7 extends Singleton
{
	private $prefix = 'conversion-for-cf7';

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
			ConversionForCf7\Module\A8::get_instance()->response();
			ConversionForCf7\Module\Moshimo::get_instance()->response();
		}
	}

	public function get_prefix() {
		return $this->prefix;
	}
}
