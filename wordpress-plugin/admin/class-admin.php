<?php
/**
 * Backend Control Panel
 * Admin interface for managing portfolios and licensees
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Backend_Control_Panel {
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu_pages' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}
	
	public function add_admin_menu_pages() {
		add_menu_page(
			'Backyard Store',
			'Patent Store',
			'manage_options',
			'backyard-patent-store',
			array( $this, 'render_dashboard_page' ),
			'dashicons-store',
			30
		);
		
		add_submenu_page(
			'backyard-patent-store',
			'Licensees',
			'Licensees',
			'manage_options',
			'backyard-licensees',
			array( $this, 'render_licensees_page' )
		);
		
		add_submenu_page(
			'backyard-patent-store',
			'Customer Wishlists',
			'Customer Wishlists',
			'manage_options',
			'backyard-wishlists',
			array( $this, 'render_wishlists_page' )
		);
	}
	
	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'backyard' ) === false ) {
			return;
		}
		
		wp_enqueue_style( 'backyard-admin-css', SYNPAT_BACKYARD_URL . 'admin/css/admin-styles.css', array(), SYNPAT_BACKYARD_VER );
		wp_enqueue_script( 'backyard-admin-js', SYNPAT_BACKYARD_URL . 'admin/js/admin-scripts.js', array( 'jquery' ), SYNPAT_BACKYARD_VER, true );
	}
	
	public function render_dashboard_page() {
		global $wpdb;
		$portfolio_table = $wpdb->prefix . 'licensing_portfolios';
		$patent_table = $wpdb->prefix . 'patent_inventory';
		$wishlist_table = $wpdb->prefix . 'buyer_wishlist';
		
		$total_portfolios = $wpdb->get_var( "SELECT COUNT(*) FROM $portfolio_table" );
		$total_patents = $wpdb->get_var( "SELECT COUNT(*) FROM $patent_table" );
		$total_wishes = $wpdb->get_var( "SELECT COUNT(*) FROM $wishlist_table" );
		$essential_portfolios = $wpdb->get_var( "SELECT COUNT(*) FROM $portfolio_table WHERE essnt = 1" );
		
		?>
		<div class="wrap">
			<h1>Backyard Patent Store Dashboard</h1>
			
			<div class="backyard-stats">
				<div class="stat-box">
					<h3>Total Portfolios</h3>
					<p class="stat-number"><?php echo esc_html( $total_portfolios ); ?></p>
				</div>
				<div class="stat-box">
					<h3>Total Patents</h3>
					<p class="stat-number"><?php echo esc_html( $total_patents ); ?></p>
				</div>
				<div class="stat-box">
					<h3>Wishlist Items</h3>
					<p class="stat-number"><?php echo esc_html( $total_wishes ); ?></p>
				</div>
				<div class="stat-box">
					<h3>Essential Portfolios</h3>
					<p class="stat-number"><?php echo esc_html( $essential_portfolios ); ?></p>
				</div>
			</div>
			
			<h2>Recent Portfolios</h2>
			<?php
			$recent_portfolios = $wpdb->get_results( "SELECT * FROM $portfolio_table ORDER BY recorded_at DESC LIMIT 10" );
			if ( $recent_portfolios ) :
			?>
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th>Title</th>
							<th>Serial</th>
							<th>Patents</th>
							<th>Licensees</th>
							<th>Essential</th>
							<th>Upfront</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $recent_portfolios as $portfolio ) : ?>
							<tr>
								<td><?php echo esc_html( $portfolio->portfolio_title ); ?></td>
								<td><?php echo esc_html( $portfolio->serial_identifier ); ?></td>
								<td><?php echo esc_html( $portfolio->n_patents ); ?></td>
								<td><?php echo esc_html( $portfolio->n_lic ); ?></td>
								<td><?php echo $portfolio->essnt ? '✓' : '—'; ?></td>
								<td>$<?php echo number_format( $portfolio->u_upfront, 2 ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
	}
	
	public function render_licensees_page() {
		global $wpdb;
		$licensee_table = $wpdb->prefix . 'actual_and_potential_licensees';
		$portfolio_table = $wpdb->prefix . 'licensing_portfolios';
		
		$licensees = $wpdb->get_results(
			"SELECT l.*, p.portfolio_title 
			FROM $licensee_table l
			LEFT JOIN $portfolio_table p ON l.portfolio_fk = p.portfolio_id
			ORDER BY l.created_timestamp DESC"
		);
		
		?>
		<div class="wrap">
			<h1>Licensees (Potential & Actual)</h1>
			
			<?php if ( $licensees ) : ?>
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th>Company</th>
							<th>Portfolio</th>
							<th>Type</th>
							<th>Executed Date</th>
							<th>Added</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $licensees as $licensee ) : ?>
							<tr>
								<td><?php echo esc_html( $licensee->company_entity ); ?></td>
								<td><?php echo esc_html( $licensee->portfolio_title ); ?></td>
								<td><span class="licensee-type <?php echo esc_attr( $licensee->relationship_category ); ?>"><?php echo esc_html( ucfirst( $licensee->relationship_category ) ); ?></span></td>
								<td><?php echo esc_html( $licensee->executed_on ?: '—' ); ?></td>
								<td><?php echo esc_html( $licensee->created_timestamp ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p>No licensee records found.</p>
			<?php endif; ?>
		</div>
		<?php
	}
	
	public function render_wishlists_page() {
		global $wpdb;
		$wishlist_table = $wpdb->prefix . 'buyer_wishlist';
		$portfolio_table = $wpdb->prefix . 'licensing_portfolios';
		
		$wishlists = $wpdb->get_results(
			"SELECT w.*, p.portfolio_title, u.display_name as customer_name
			FROM $wishlist_table w
			LEFT JOIN $portfolio_table p ON w.portfolio_fk = p.portfolio_id
			LEFT JOIN {$wpdb->users} u ON w.customer_fk = u.ID
			ORDER BY w.wishlisted_at DESC"
		);
		
		?>
		<div class="wrap">
			<h1>Customer Wishlists</h1>
			
			<?php if ( $wishlists ) : ?>
				<table class="wp-list-table widefat fixed striped">
					<thead>
						<tr>
							<th>Customer</th>
							<th>Portfolio</th>
							<th>Added Date</th>
							<th>Notes</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $wishlists as $wish ) : ?>
							<tr>
								<td><?php echo esc_html( $wish->customer_name ); ?></td>
								<td><?php echo esc_html( $wish->portfolio_title ); ?></td>
								<td><?php echo esc_html( $wish->wishlisted_at ); ?></td>
								<td><?php echo esc_html( $wish->customer_memo ?: '—' ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p>No wishlist items found.</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
