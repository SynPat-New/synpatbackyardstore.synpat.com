<?php
/**
 * Storefront Experience
 * Frontend assets and user interactions
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Storefront_Experience {
	
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
		add_action( 'wp_footer', array( $this, 'inject_ajax_config' ) );
	}
	
	public function enqueue_frontend_assets() {
		wp_enqueue_style( 'backyard-store-frontend', SYNPAT_BACKYARD_URL . 'public/css/store-frontend.css', array(), SYNPAT_BACKYARD_VER );
		wp_enqueue_script( 'backyard-store-frontend', SYNPAT_BACKYARD_URL . 'public/js/store-frontend.js', array( 'jquery' ), SYNPAT_BACKYARD_VER, true );
		
		wp_localize_script( 'backyard-store-frontend', 'backyardAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'backyard_ajax_nonce' )
		) );
	}
	
	public function inject_ajax_config() {
		?>
		<script type="text/javascript">
			var backyardStoreConfig = {
				ajaxUrl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				nonce: '<?php echo wp_create_nonce( 'backyard_ajax_nonce' ); ?>',
				isLoggedIn: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>
			};
		</script>
		<?php
	}
}
