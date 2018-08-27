<?php

namespace TsadForCf7;

/**
 * Customize the list table on the admin screen.
 *
 * @package TsadForCf7
 */
final class Admin
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
			__( 'Tsad for Contact Form 7', 'tsad-for-cf7' ),
			__( 'Tsad for Contact Form 7', 'tsad-for-cf7' ),
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

		// A8
        add_settings_section(
            'a8_settings',
            __( 'A8 settings', 'tsad-for-cf7' ),
            array( $this, 'a8_section_callback' ),
            $this->prefix
        );

        add_settings_field(
            'is_available',
            __( 'Availability', 'tsad-for-cf7' ),
            array( $this, 'a8_is_available_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'landing_code',
            __( 'Landing page code', 'tsad-for-cf7' ),
            array( $this, 'a8_landing_code_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'conversion_code',
            __( 'Conversion page code', 'tsad-for-cf7' ),
            array( $this, 'a8_conversion_code_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'contact_posts',
            __( 'Contact post id', 'tsad-for-cf7' ),
            array( $this, 'a8_contact_posts_callback' ),
            $this->prefix,
            'a8_settings'
        );

        add_settings_field(
            'conversion_posts',
            __( 'Conversion post id', 'tsad-for-cf7' ),
            array( $this, 'a8_conversion_posts_callback' ),
            $this->prefix,
            'a8_settings'
        );

		// TODO:もしも

		// TODO:フェルマ

		// TODO:アンガス

	}

	public function a8_section_callback()
	{
        echo '<p>' . __( 'This is settings for A8.net', 'tsad-for-cf7' ) . '</p>';
    }

	public function a8_is_available_callback()
	{
        $a8_is_available = isset( $this->options['a8_is_available'] ) ? $this->options['a8_is_available'] : '';
		?>
		<label for="is_available">
		<input name="<?php echo $this->prefix;?>[a8_is_available]" type="checkbox" id="is_available" value="1" <?php checked( '1', $a8_is_available ); ?> />
		<?php _e( 'Can available', 'tsad-for-cf7' ); ?></label>
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
			<code>[flamingo_id]</code>
			<?php _e( ':Flamingo ID', 'tsad-for-cf7' ); ?>
		</p>
		<?php
    }

	public function a8_contact_posts_callback()
	{
        $a8_contact_posts = isset( $this->options['a8_contact_posts'] ) ? $this->options['a8_contact_posts'] : '';
		?>
		<input name="<?php echo $this->prefix;?>[a8_contact_posts]" type="text" id="a8_contact_posts" value="<?php echo $a8_contact_posts;?>" class="regular-text">
		<?php
    }

	public function a8_conversion_posts_callback()
	{
        $a8_conversion_posts = isset( $this->options['a8_conversion_posts'] ) ? $this->options['a8_conversion_posts'] : '';
		?>
		<input name="<?php echo $this->prefix;?>[a8_conversion_posts]" type="text" id="a8_conversion_posts" value="<?php echo $a8_conversion_posts;?>" class="regular-text">
		<?php
    }

    public function options_page()
    {
		$action = untrailingslashit( admin_url() ) . '/options.php';
        $this->options = get_option( $this->prefix );
?>
		<div class="wrap tsad-for-cf7-settings">
			<h1 class="wp-heading-inline"><?php _e( 'Tsad For Contact Form 7', 'tsad-for-cf7' ); ?></h1>
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
