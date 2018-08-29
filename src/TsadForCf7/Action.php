<?php

namespace TsadForCf7;

/**
 * Customize the action.
 *
 * @package TsadForCf7
 */
final class Action
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
			$instance = new Action();
		}
		return $instance;
	}

	public function register()
	{
        $this->options = get_option( $this->prefix );

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );
	}

	public function is_enabled()
	{
		if ( empty( $this->options['contact_posts'] ) ) {
			return false;
		}

		return ( $this->options['contact_posts'] == get_the_ID() );
	}

	public function get_conversion_url()
	{
		return get_permalink( $this->options['conversion_posts'] );
	}

	public function init()
	{
		/**
		 * Disable the JavaScript for the Contact Form 7.
		 */
		add_filter( 'wpcf7_load_js', '__return_false' );

		/**
		 * Redirect to the conversion page after Flamingo submitted.
		 */
		add_action( 'wpcf7_after_flamingo', function( $result ) {
			$url = $this->get_conversion_url();

			//TODO: URLにnonceを付与

			/**
			 * Filters the conversion url to redirect
			 *
			 * @param string $url
			 */
			$url = apply_filters( 'tsad_form_cf7_conversion_url', $url );

			if ( ! empty( $url ) ) {
				wp_safe_redirect( esc_url_raw( $url, array( 'http', 'https' ) ), 302 );
				exit;
			}
		}, 9999 );
	}

	public function wp_footer()
	{
		//TODO: 全ページのLPタグ設置


		//TODO: コンバージョンページのタグ設定

	}
}
