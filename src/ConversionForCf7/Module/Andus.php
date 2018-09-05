<?php

namespace ConversionForCf7\Module;

use ConversionForCf7\Pattern\Singleton;

/**
 * Customize the action.
 *
 * @package ConversionForCf7
 */
class Andus extends Singleton
{
	private $prefix;
    private $options;

	protected function on_construct() {
		$this->prefix = \ConversionForCf7::get_instance()->get_prefix();
        $this->options = get_option( $this->prefix );
	}

	public function response()
	{
		if ( ! empty( $this->options['andus_is_available'] ) ) {
			add_action( 'wp_head', array( $this, 'wp_head' ) );
		}
	}

	public function wp_head()
	{
		echo $this->get_landing_code();
	}

	public function get_landing_code()
	{
		if ( empty( $this->options['andus_landing_code'] ) ) {
			return '';
		}

		return $this->options['andus_landing_code'];
	}

	public function is_available()
	{
		return ( ! empty( $this->options['andus_is_available'] ) );
	}
}
