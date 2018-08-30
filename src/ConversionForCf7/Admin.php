<?php

namespace ConversionForCf7;

/**
 * Customize the  admin screen.
 *
 * @package ConversionForCf7
 */
final class Admin
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
			$instance = new Admin();
		}
		return $instance;
	}

	public function register()
	{
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	public function admin_menu()
	{
        add_options_page(
			__( 'Conversion for Contact Form 7', 'conversion-for-cf7' ),
			__( 'Conversion for Contact Form 7', 'conversion-for-cf7' ),
            'manage_options',
			$this->prefix,
            array( $this, 'options_page' )
        );
	}

	public function admin_init()
	{
		register_setting(
			$this->prefix,
			$this->prefix
		);

		// Basic
        add_settings_section(
            'basic_settings',
            __( 'Basic settings', 'conversion-for-cf7' ),
            null,
            $this->prefix
        );

        add_settings_field(
            'contact_posts',
            __( 'Contact post id', 'conversion-for-cf7' ),
            array( $this, 'contact_posts_callback' ),
            $this->prefix,
            'basic_settings'
        );

        add_settings_field(
            'conversion_posts',
            __( 'Conversion post id', 'conversion-for-cf7' ),
            array( $this, 'conversion_posts_callback' ),
            $this->prefix,
            'basic_settings'
        );

		// A8
        add_settings_section(
            'a8_settings',
            __( 'A8 settings', 'conversion-for-cf7' ),
            null,
            $this->prefix
        );

        add_settings_field(
            'is_available',
            __( 'Availability', 'conversion-for-cf7' ),
            array( $this, 'a8_is_available_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'landing_code',
            __( 'Landing page code', 'conversion-for-cf7' ),
            array( $this, 'a8_landing_code_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'conversion_code',
            __( 'Conversion page code', 'conversion-for-cf7' ),
            array( $this, 'a8_conversion_code_callback' ),
            $this->prefix,
            'a8_settings'
        );

		// TODO:もしも

		// TODO:フェルマ

		// TODO:アンガス

	}

	public function contact_posts_callback()
	{
        $contact_posts = isset( $this->options['contact_posts'] ) ? $this->options['contact_posts'] : '';
		?>
		<input name="<?php echo $this->prefix;?>[contact_posts]" type="text" id="contact_posts" value="<?php echo $contact_posts;?>" class="regular-text">
		<?php
    }

	public function conversion_posts_callback()
	{
        $conversion_posts = isset( $this->options['conversion_posts'] ) ? $this->options['conversion_posts'] : '';
		?>
		<input name="<?php echo $this->prefix;?>[conversion_posts]" type="text" id="conversion_posts" value="<?php echo $conversion_posts;?>" class="regular-text">
		<?php
    }

	public function a8_is_available_callback()
	{
        $a8_is_available = isset( $this->options['a8_is_available'] ) ? $this->options['a8_is_available'] : '';
		?>
		<label for="is_available">
		<input name="<?php echo $this->prefix;?>[a8_is_available]" type="checkbox" id="is_available" value="1" <?php checked( '1', $a8_is_available ); ?> />
		<?php _e( 'Can available', 'conversion-for-cf7' ); ?></label>
		<?php
    }

	public function a8_landing_code_callback()
	{
        $a8_landing_code = isset( $this->options['a8_landing_code'] ) ? $this->options['a8_landing_code'] : '';
		?>
		<textarea name="<?php echo $this->prefix;?>[a8_landing_code]" rows="10" cols="50" id="a8_landing_code" class="large-text"><?php echo $a8_landing_code;?></textarea>
		<?php
    }

	public function a8_conversion_code_callback()
	{
        $a8_conversion_code = isset( $this->options['a8_conversion_code'] ) ? $this->options['a8_conversion_code'] : '';
		?>
		<p>
			<textarea name="<?php echo $this->prefix;?>[a8_conversion_code]" rows="10" cols="50" id="a8_conversion_code" class="large-text"><?php echo $a8_conversion_code;?></textarea>
		</p>
		<p class="description">
			<code>[serial_number]</code>
			<?php _e( ':Serial_number of Flamingo', 'conversion-for-cf7' ); ?>
		</p>
		<?php
    }

    public function options_page()
    {
		$action = untrailingslashit( admin_url() ) . '/options.php';
        $this->options = get_option( $this->prefix );
?>
		<div class="wrap conversion-for-cf7-settings">
			<h1 class="wp-heading-inline"><?php _e( 'Conversion For Contact Form 7', 'conversion-for-cf7' ); ?></h1>
			<form action="<?php echo esc_url( $action ); ?>" method="post">
<?php
			settings_fields( $this->prefix );
			do_settings_sections( $this->prefix );
			submit_button();
?>
			</form>
		</div>
<?php
	}
}
