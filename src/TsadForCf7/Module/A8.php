<?php

namespace TsadForCf7\Module;

/**
 * Customize the action.
 *
 * @package TsadForCf7
 */
final class A8
{
	private $prefix;
    private $options;

	public function __construct()
	{
		$this->prefix = \TsadForCf7::get_instance()->get_prefix();
	}

	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new A8();
		}
		return $instance;
	}

	public function register()
	{
        $this->options = get_option( $this->prefix );

		if ( ! empty( $this->options['a8_is_available'] ) ) {
			add_action( 'wp_footer', array( $this, 'wp_footer' ) );
		}
	}

	public function wp_footer()
	{
		if ( ! $this->is_conversion() && ! empty( $this->options['a8_landing_code'] ) ) {
			 echo $this->options['a8_landing_code'];
		}

		if ( isset( $_GET[$this->prefix] ) && wp_verify_nonce( $_GET[$this->prefix], $this->prefix ) ) {
			echo $this->get_conversion_code();
		}
	}

	public function is_conversion()
	{
		if ( empty( $this->options['conversion_posts'] ) ) {
			return false;
		}

		return ( $this->options['conversion_posts'] == get_the_ID() );
	}

	public function get_conversion_code()
	{
		if ( empty( $this->options['a8_conversion_code'] ) ) {
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
		delete_transient( $_GET[$this->prefix] );

		$a8_conversion_code = str_replace( '[serial_number]', $serial_number, $this->options['a8_conversion_code'] );

		return $a8_conversion_code;
	}
}
