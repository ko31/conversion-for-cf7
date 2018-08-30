<?php

namespace ConversionForCf7;

/**
 * Customize the action.
 *
 * @package ConversionForCf7
 */
final class Action
{
	private $prefix;
    private $options;

	public function __construct()
	{
		$this->prefix = \ConversionForCf7::get_instance()->get_prefix();
	}

	public static function get_instance()
	{
		static $instance;
		if ( ! $instance ) {
			$instance = new Action();
		}
		return $instance;
	}

	public function register()
	{
        $this->options = get_option( $this->prefix );

		add_action( 'init', array( $this, 'init' ) );
	}

	public function is_contact()
	{
		if ( empty( $this->options['contact_posts'] ) ) {
			return false;
		}

		$url = ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" )
			. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return ( $this->options['contact_posts'] == url_to_postid( $url ) );
	}

	public function get_conversion_url()
	{
		return get_permalink( $this->options['conversion_posts'] );
	}

	public function init()
	{
		if ( ! $this->is_contact() ) {
			return;
		}

		/**
		 * Disable the JavaScript for the Contact Form 7.
		 */
		add_filter( 'wpcf7_load_js', '__return_false' );

		/**
		 * Redirect to the conversion page after Flamingo submitted.
		 */
		add_action( 'wpcf7_after_flamingo', function( $result ) {

			$url = $this->get_conversion_url();

			/**
			 * Filters the conversion url to redirect
			 *
			 * @param string $url
			 */
			$url = apply_filters( 'conversion_form_cf7_conversion_url', $url );

			$url = wp_nonce_url( $url, $this->prefix, $this->prefix );

			if ( ! empty( $url ) ) {
				parse_str( parse_url( $url, PHP_URL_QUERY ), $query );
				set_transient( $query[$this->prefix], $result['flamingo_inbound_id'], MINUTE_IN_SECONDS );

				wp_safe_redirect( esc_url_raw( $url, array( 'http', 'https' ) ), 302 );
				exit;
			}
		}, 9999 );
	}
}
