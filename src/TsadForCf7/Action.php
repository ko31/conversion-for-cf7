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
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );
	}

	public function wp_footer()
	{
        $this->options = get_option( $this->prefix );
		?>
		<script type="text/javascript">
		console.log("test1");
		console.log("<?php echo $this->prefix; ?>");
		console.log("<?php echo $this->options['a8_contact_posts']; ?>");
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			console.log("test2");
			console.log(event.detail);
			return;
//			if ( '123' == event.detail.contactFormId ) {
//				ga( 'send', 'event', 'Contact Form', 'submit' );
//			}
		}, false );
		</script>
		<?php
	}
}
