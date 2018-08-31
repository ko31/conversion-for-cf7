<?php

namespace ConversionForCf7\Module;

use ConversionForCf7\Pattern\Singleton;

/**
 * Customize the action.
 *
 * @package ConversionForCf7
 */
class Moshimo extends Singleton
{
	private $prefix;
    private $options;

	protected function on_construct() {
		$this->prefix = \ConversionForCf7::get_instance()->get_prefix();
	}

	public function response()
	{
        $this->options = get_option( $this->prefix );

		if ( ! empty( $this->options['moshimo_is_available'] ) ) {
			add_filter( 'the_content', array( $this, 'the_content' ) );
		}
	}

	public function the_content( $content )
	{
		if ( isset( $_GET[$this->prefix] ) && wp_verify_nonce( $_GET[$this->prefix], $this->prefix ) ) {
			$conversion_code = $this->get_conversion_code();
			$content = $conversion_code . $content;
		}

		return $content;
	}

	public function get_conversion_code()
	{
		if ( empty( $this->options['moshimo_conversion_code'] ) ) {
			return '';
		}

		$serial_number = '';
		$flamingo_inbound_id = get_transient( $_GET[$this->prefix] );
		if ( $flamingo_inbound_id !== false ) {
			$meta = get_post_meta( $flamingo_inbound_id, '_meta', true );
			if ( ! empty( $meta['serial_number'] ) ) {
				$serial_number = $meta['serial_number'];
			}
		}

		$moshimo_conversion_code = str_replace( '[serial_number]', $serial_number, $this->options['moshimo_conversion_code'] );

		return $moshimo_conversion_code;
	}
}
