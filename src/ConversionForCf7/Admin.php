<?php

namespace ConversionForCf7;

use ConversionForCf7\Pattern\Singleton;

/**
 * Customize the  admin screen.
 *
 * @package ConversionForCf7
 */
class Admin extends Singleton
{
	private $prefix;
    private $options;

	protected function on_construct() {
		$this->prefix = \ConversionForCf7::get_instance()->get_prefix();
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

		// もしも
        add_settings_section(
            'moshimo_settings',
            __( 'Moshimo settings', 'conversion-for-cf7' ),
            null,
            $this->prefix
        );

        add_settings_field(
            'is_available',
            __( 'Availability', 'conversion-for-cf7' ),
            array( $this, 'moshimo_is_available_callback' ),
            $this->prefix,
            'moshimo_settings'
        );

        add_settings_field(
            'conversion_code',
            __( 'Conversion page code', 'conversion-for-cf7' ),
            array( $this, 'moshimo_conversion_code_callback' ),
            $this->prefix,
            'moshimo_settings'
        );

		// フェルマ
        add_settings_section(
            'felmat_settings',
            __( 'Felmat settings', 'conversion-for-cf7' ),
            null,
            $this->prefix
        );

        add_settings_field(
            'is_available',
            __( 'Availability', 'conversion-for-cf7' ),
            array( $this, 'felmat_is_available_callback' ),
            $this->prefix,
            'felmat_settings'
        );

        add_settings_field(
            'landing_code',
            __( 'Landing page code', 'conversion-for-cf7' ),
            array( $this, 'felmat_landing_code_callback' ),
            $this->prefix,
            'felmat_settings'
        );

        add_settings_field(
            'conversion_code',
            __( 'Conversion page code', 'conversion-for-cf7' ),
            array( $this, 'felmat_conversion_code_callback' ),
            $this->prefix,
            'felmat_settings'
        );

		// Yahoo!スポンサードサーチ
        add_settings_section(
            'yahoo_settings',
            __( 'Yahoo sponsored search settings', 'conversion-for-cf7' ),
            null,
            $this->prefix
        );

        add_settings_field(
            'is_available',
            __( 'Availability', 'conversion-for-cf7' ),
            array( $this, 'yahoo_is_available_callback' ),
            $this->prefix,
            'yahoo_settings'
        );

        add_settings_field(
            'conversion_code',
            __( 'Conversion page code', 'conversion-for-cf7' ),
            array( $this, 'yahoo_conversion_code_callback' ),
            $this->prefix,
            'yahoo_settings'
        );

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
		<label for="a8_is_available">
		<input name="<?php echo $this->prefix;?>[a8_is_available]" type="checkbox" id="a8_is_available" value="1" <?php checked( '1', $a8_is_available ); ?> />
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

	public function moshimo_is_available_callback()
	{
        $moshimo_is_available = isset( $this->options['moshimo_is_available'] ) ? $this->options['moshimo_is_available'] : '';
		?>
		<label for="moshimo_is_available">
		<input name="<?php echo $this->prefix;?>[moshimo_is_available]" type="checkbox" id="moshimo_is_available" value="1" <?php checked( '1', $moshimo_is_available ); ?> />
		<?php _e( 'Can available', 'conversion-for-cf7' ); ?></label>
		<?php
    }

	public function moshimo_conversion_code_callback()
	{
        $moshimo_conversion_code = isset( $this->options['moshimo_conversion_code'] ) ? $this->options['moshimo_conversion_code'] : '';
		?>
		<p>
			<textarea name="<?php echo $this->prefix;?>[moshimo_conversion_code]" rows="10" cols="50" id="moshimo_conversion_code" class="large-text"><?php echo $moshimo_conversion_code;?></textarea>
		</p>
		<p class="description">
			<code>[serial_number]</code>
			<?php _e( ':Serial_number of Flamingo', 'conversion-for-cf7' ); ?>
		</p>
		<?php
    }

	public function felmat_is_available_callback()
	{
        $felmat_is_available = isset( $this->options['felmat_is_available'] ) ? $this->options['felmat_is_available'] : '';
		?>
		<label for="felmat_is_available">
		<input name="<?php echo $this->prefix;?>[felmat_is_available]" type="checkbox" id="felmat_is_available" value="1" <?php checked( '1', $felmat_is_available ); ?> />
		<?php _e( 'Can available', 'conversion-for-cf7' ); ?></label>
		<?php
    }

	public function felmat_landing_code_callback()
	{
        $felmat_landing_code = isset( $this->options['felmat_landing_code'] ) ? $this->options['felmat_landing_code'] : '';
		?>
		<textarea name="<?php echo $this->prefix;?>[felmat_landing_code]" rows="10" cols="50" id="felmat_landing_code" class="large-text"><?php echo $felmat_landing_code;?></textarea>
		<?php
    }

	public function felmat_conversion_code_callback()
	{
        $felmat_conversion_code = isset( $this->options['felmat_conversion_code'] ) ? $this->options['felmat_conversion_code'] : '';
		?>
		<p>
			<textarea name="<?php echo $this->prefix;?>[felmat_conversion_code]" rows="10" cols="50" id="felmat_conversion_code" class="large-text"><?php echo $felmat_conversion_code;?></textarea>
		</p>
		<p class="description">
			<code>[serial_number]</code>
			<?php _e( ':Serial_number of Flamingo', 'conversion-for-cf7' ); ?>
		</p>
		<?php
    }

	public function yahoo_is_available_callback()
	{
        $yahoo_is_available = isset( $this->options['yahoo_is_available'] ) ? $this->options['yahoo_is_available'] : '';
		?>
		<label for="yahoo_is_available">
		<input name="<?php echo $this->prefix;?>[yahoo_is_available]" type="checkbox" id="yahoo_is_available" value="1" <?php checked( '1', $yahoo_is_available ); ?> />
		<?php _e( 'Can available', 'conversion-for-cf7' ); ?></label>
		<?php
    }

	public function yahoo_conversion_code_callback()
	{
        $yahoo_conversion_code = isset( $this->options['yahoo_conversion_code'] ) ? $this->options['yahoo_conversion_code'] : '';
		?>
		<p>
			<textarea name="<?php echo $this->prefix;?>[yahoo_conversion_code]" rows="10" cols="50" id="yahoo_conversion_code" class="large-text"><?php echo $yahoo_conversion_code;?></textarea>
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
