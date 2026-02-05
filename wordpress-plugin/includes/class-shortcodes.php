<?php
/**
 * Store Interaction Handlers
 * Shortcodes for catalog browsing and patent details
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Store_Interaction_Handlers {
	
	public function __construct() {
		add_shortcode( 'portfolio_catalog', array( $this, 'render_portfolio_catalog' ) );
		add_shortcode( 'portfolio_details', array( $this, 'render_portfolio_details' ) );
		add_shortcode( 'customer_wishlist', array( $this, 'render_customer_wishlist' ) );
		add_shortcode( 'patent_inner_room', array( $this, 'render_patent_details' ) );
	}
	
	public function render_portfolio_catalog( $atts ) {
		$atts = shortcode_atts( array(
			'tech_sector' => '',
			'min_patents' => 0,
			'essential_only' => false,
		), $atts );
		
		$filters = array();
		if ( $atts['tech_sector'] ) $filters['technology_sector'] = $atts['tech_sector'];
		if ( $atts['min_patents'] > 0 ) $filters['minimum_patent_count'] = $atts['min_patents'];
		if ( $atts['essential_only'] ) $filters['only_essential'] = true;
		
		$portfolios = Licensing_Portfolio_Storage::query_portfolios_for_catalog( $filters );
		
		ob_start();
		?>
		<div class="backyard-portfolio-catalog">
			<h2>Patent Portfolio Catalog</h2>
			<?php if ( empty( $portfolios ) ) : ?>
				<p>No portfolios available at this time.</p>
			<?php else : ?>
				<div class="portfolio-grid">
					<?php foreach ( $portfolios as $portfolio ) : ?>
						<div class="portfolio-card" data-portfolio-id="<?php echo esc_attr( $portfolio->portfolio_id ); ?>">
							<h3><?php echo esc_html( $portfolio->portfolio_title ); ?></h3>
							<div class="portfolio-metrics">
								<span class="metric"><strong>Patents:</strong> <?php echo esc_html( $portfolio->n_patents ); ?></span>
								<span class="metric"><strong>Licensees:</strong> <?php echo esc_html( $portfolio->n_lic ); ?></span>
								<?php if ( $portfolio->essnt ) : ?>
									<span class="metric essential-badge">✓ Essential</span>
								<?php endif; ?>
								<?php if ( $portfolio->u_upfront > 0 ) : ?>
									<span class="metric"><strong>Upfront:</strong> $<?php echo number_format( $portfolio->u_upfront, 2 ); ?></span>
								<?php endif; ?>
							</div>
							<div class="portfolio-description">
								<?php echo wp_kses_post( wp_trim_words( $portfolio->portfolio_narrative, 30 ) ); ?>
			</div>
							<div class="portfolio-actions">
								<a href="?portfolio=<?php echo esc_attr( $portfolio->portfolio_id ); ?>" class="btn-view-details">View Details</a>
								<button class="btn-add-wishlist" data-portfolio-id="<?php echo esc_attr( $portfolio->portfolio_id ); ?>">Add to Wishlist</button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	public function render_portfolio_details( $atts ) {
		$portfolio_id = isset( $_GET['portfolio'] ) ? intval( $_GET['portfolio'] ) : 0;
		
		if ( ! $portfolio_id ) {
			return '<p>Portfolio not found.</p>';
		}
		
		$portfolio = Licensing_Portfolio_Storage::retrieve_single_portfolio( $portfolio_id );
		if ( ! $portfolio ) {
			return '<p>Portfolio not found.</p>';
		}
		
		$patents = Licensing_Portfolio_Storage::get_patents_in_portfolio( $portfolio_id );
		$licensees = Licensing_Portfolio_Storage::get_portfolio_licensees( $portfolio_id );
		
		ob_start();
		?>
		<div class="portfolio-details-view">
			<h1><?php echo esc_html( $portfolio->portfolio_title ); ?></h1>
			<div class="portfolio-meta">
				<span><strong>Serial:</strong> <?php echo esc_html( $portfolio->serial_identifier ); ?></span>
				<span><strong>Tech Sector:</strong> <?php echo esc_html( $portfolio->technology_sector ); ?></span>
			</div>
			
			<div class="portfolio-business-metrics">
				<div class="metric-box">
					<span class="metric-label">Patents</span>
					<span class="metric-value"><?php echo esc_html( $portfolio->n_patents ); ?></span>
				</div>
				<div class="metric-box">
					<span class="metric-label">Licensees</span>
					<span class="metric-value"><?php echo esc_html( $portfolio->n_lic ); ?></span>
				</div>
				<?php if ( $portfolio->essnt ) : ?>
					<div class="metric-box essential">
						<span class="metric-label">Essential IP</span>
						<span class="metric-value">✓</span>
					</div>
				<?php endif; ?>
				<?php if ( $portfolio->u_upfront > 0 ) : ?>
					<div class="metric-box">
						<span class="metric-label">Upfront Payment</span>
						<span class="metric-value">$<?php echo number_format( $portfolio->u_upfront, 2 ); ?></span>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="portfolio-description">
				<?php echo wp_kses_post( $portfolio->portfolio_narrative ); ?>
			</div>
			
			<h2>Patents in This Portfolio</h2>
			<?php if ( empty( $patents ) ) : ?>
				<p>No patents listed.</p>
			<?php else : ?>
				<div class="patent-list">
					<?php foreach ( $patents as $patent ) : ?>
						<div class="patent-item">
							<h4><?php echo esc_html( $patent->patent_identifier ); ?> - <?php echo esc_html( $patent->patent_name ); ?></h4>
							<p><strong>Owner:</strong> <?php echo esc_html( $patent->assignee_current ); ?></p>
							<p><strong>Status:</strong> <?php echo esc_html( $patent->enforcement_status ); ?></p>
							<a href="?patent=<?php echo esc_attr( $patent->patent_id ); ?>" class="btn-patent-details">View Patent Details</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			
			<h2>Licensees</h2>
			<?php if ( empty( $licensees ) ) : ?>
				<p>No licensee information available.</p>
			<?php else : ?>
				<table class="licensee-table">
					<thead>
						<tr>
							<th>Company</th>
							<th>Type</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $licensees as $licensee ) : ?>
							<tr>
								<td><?php echo esc_html( $licensee->company_entity ); ?></td>
								<td><?php echo esc_html( ucfirst( $licensee->relationship_category ) ); ?></td>
								<td><?php echo esc_html( $licensee->executed_on ?: 'N/A' ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	public function render_customer_wishlist( $atts ) {
		if ( ! is_user_logged_in() ) {
			return '<p>Please log in to view your wishlist.</p>';
		}
		
		$customer_id = get_current_user_id();
		$wishlist_items = Licensing_Portfolio_Storage::get_customer_wishlist_items( $customer_id );
		
		ob_start();
		?>
		<div class="customer-wishlist">
			<h2>My Wishlist</h2>
			<?php if ( empty( $wishlist_items ) ) : ?>
				<p>Your wishlist is empty.</p>
			<?php else : ?>
				<div class="wishlist-items">
					<?php foreach ( $wishlist_items as $item ) : ?>
						<div class="wishlist-item">
							<h3><?php echo esc_html( $item->portfolio_title ); ?></h3>
							<p><strong>Added:</strong> <?php echo esc_html( $item->wishlisted_at ); ?></p>
							<p><strong>Patents:</strong> <?php echo esc_html( $item->n_patents ); ?></p>
							<p><strong>Licensees:</strong> <?php echo esc_html( $item->n_lic ); ?></p>
							<?php if ( $item->customer_memo ) : ?>
								<p><strong>Notes:</strong> <?php echo esc_html( $item->customer_memo ); ?></p>
							<?php endif; ?>
							<a href="?portfolio=<?php echo esc_attr( $item->portfolio_id ); ?>" class="btn-view">View</a>
							<button class="btn-remove-wishlist" data-portfolio-id="<?php echo esc_attr( $item->portfolio_id ); ?>">Remove</button>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	public function render_patent_details( $atts ) {
		$patent_id = isset( $_GET['patent'] ) ? intval( $_GET['patent'] ) : 0;
		
		if ( ! $patent_id ) {
			return '<p>Patent not found.</p>';
		}
		
		global $wpdb;
		$table = $wpdb->prefix . 'patent_inventory';
		$patent = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE patent_id = %d", $patent_id ) );
		
		if ( ! $patent ) {
			return '<p>Patent not found.</p>';
		}
		
		ob_start();
		?>
		<div class="patent-details-inner-room">
			<h1><?php echo esc_html( $patent->patent_identifier ); ?></h1>
			<h2><?php echo esc_html( $patent->patent_name ); ?></h2>
			
			<table class="patent-info-table">
				<tr>
					<th>Application Number:</th>
					<td><?php echo esc_html( $patent->application_ref ); ?></td>
				</tr>
				<tr>
					<th>Filing Date:</th>
					<td><?php echo esc_html( $patent->filing_timestamp ); ?></td>
				</tr>
				<tr>
					<th>Grant Date:</th>
					<td><?php echo esc_html( $patent->grant_timestamp ); ?></td>
				</tr>
				<tr>
					<th>Expiration:</th>
					<td><?php echo esc_html( $patent->expiry_timestamp ); ?></td>
				</tr>
				<tr>
					<th>Current Owner:</th>
					<td><?php echo esc_html( $patent->assignee_current ); ?></td>
				</tr>
				<tr>
					<th>Original Inventor:</th>
					<td><?php echo esc_html( $patent->inventor_original ); ?></td>
				</tr>
				<tr>
					<th>Status:</th>
					<td><?php echo esc_html( $patent->enforcement_status ); ?></td>
				</tr>
				<tr>
					<th>Claims:</th>
					<td><?php echo esc_html( $patent->independent_claims ); ?></td>
				</tr>
				<tr>
					<th>Forward Citations:</th>
					<td><?php echo esc_html( $patent->cited_by_count ); ?></td>
				</tr>
				<tr>
					<th>Backward Citations:</th>
					<td><?php echo esc_html( $patent->cites_prior_count ); ?></td>
				</tr>
			</table>
			
			<div class="patent-abstract">
				<h3>Abstract</h3>
				<?php echo wp_kses_post( $patent->technical_abstract ); ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
