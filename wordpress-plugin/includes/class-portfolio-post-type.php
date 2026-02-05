<?php
/**
 * Portfolio Catalog Display
 * Registers portfolios as custom content with business fields
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Portfolio_Catalog_Display {
	
	public function __construct() {
		add_action( 'init', array( $this, 'register_portfolio_content_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'attach_business_fields_panel' ) );
		add_action( 'save_post_patent_portfolio', array( $this, 'persist_business_metrics' ), 10, 2 );
		add_filter( 'manage_patent_portfolio_posts_columns', array( $this, 'customize_admin_columns' ) );
		add_action( 'manage_patent_portfolio_posts_custom_column', array( $this, 'populate_admin_columns' ), 10, 2 );
	}
	
	public function register_portfolio_content_type() {
		$config = array(
			'labels' => array(
				'name' => 'Patent Portfolios',
				'singular_name' => 'Portfolio',
				'add_new' => 'Add Portfolio',
				'add_new_item' => 'Create New Portfolio',
				'edit_item' => 'Edit Portfolio',
				'view_item' => 'View Portfolio',
				'search_items' => 'Search Portfolios',
				'not_found' => 'No portfolios found',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'portfolio-catalog' ),
			'menu_icon' => 'dashicons-portfolio',
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
			'taxonomies' => array( 'technology_domain' ),
		);
		
		register_post_type( 'patent_portfolio', $config );
		
		$tax_config = array(
			'labels' => array(
				'name' => 'Technology Domains',
				'singular_name' => 'Technology Domain',
			),
			'hierarchical' => true,
			'public' => true,
			'show_in_rest' => true,
			'rewrite' => array( 'slug' => 'tech-domain' ),
		);
		
		register_taxonomy( 'technology_domain', 'patent_portfolio', $tax_config );
	}
	
	public function attach_business_fields_panel() {
		add_meta_box(
			'portfolio_business_metrics',
			'Portfolio Business Metrics',
			array( $this, 'render_business_fields_ui' ),
			'patent_portfolio',
			'normal',
			'high'
		);
	}
	
	public function render_business_fields_ui( $post ) {
		wp_nonce_field( 'spbs_portfolio_metrics', 'spbs_metrics_nonce' );
		
		$n_patents = get_post_meta( $post->ID, '_n_patents', true );
		$essnt = get_post_meta( $post->ID, '_essnt', true );
		$n_lic = get_post_meta( $post->ID, '_n_lic', true );
		$u_upfront = get_post_meta( $post->ID, '_u_upfront', true );
		$serial_code = get_post_meta( $post->ID, '_serial_code', true );
		$cost_price = get_post_meta( $post->ID, '_cost_price', true );
		$option_deadline = get_post_meta( $post->ID, '_option_deadline', true );
		$regular_start = get_post_meta( $post->ID, '_regular_start', true );
		
		?>
		<style>
			.spbs-field-row { margin-bottom: 15px; }
			.spbs-field-row label { display: inline-block; width: 200px; font-weight: 600; }
			.spbs-field-row input[type="text"],
			.spbs-field-row input[type="number"],
			.spbs-field-row input[type="datetime-local"] { width: 300px; }
		</style>
		
		<div class="spbs-field-row">
			<label for="serial_code">Serial Code:</label>
			<input type="text" id="serial_code" name="serial_code" value="<?php echo esc_attr( $serial_code ); ?>" />
		</div>
		
		<div class="spbs-field-row">
			<label for="n_patents">Number of Patents:</label>
			<input type="number" id="n_patents" name="n_patents" value="<?php echo esc_attr( $n_patents ); ?>" min="0" />
		</div>
		
		<div class="spbs-field-row">
			<label for="essnt">Essential Status:</label>
			<input type="checkbox" id="essnt" name="essnt" value="1" <?php checked( $essnt, '1' ); ?> />
			<span>Mark as essential patent</span>
		</div>
		
		<div class="spbs-field-row">
			<label for="n_lic">Number of Licensees:</label>
			<input type="number" id="n_lic" name="n_lic" value="<?php echo esc_attr( $n_lic ); ?>" min="0" />
		</div>
		
		<div class="spbs-field-row">
			<label for="u_upfront">Upfront Payment ($):</label>
			<input type="number" id="u_upfront" name="u_upfront" value="<?php echo esc_attr( $u_upfront ); ?>" step="0.01" min="0" />
		</div>
		
		<div class="spbs-field-row">
			<label for="cost_price">Cost Price ($):</label>
			<input type="number" id="cost_price" name="cost_price" value="<?php echo esc_attr( $cost_price ); ?>" step="0.01" min="0" />
		</div>
		
		<div class="spbs-field-row">
			<label for="option_deadline">Option Expiration:</label>
			<input type="datetime-local" id="option_deadline" name="option_deadline" value="<?php echo esc_attr( $option_deadline ); ?>" />
		</div>
		
		<div class="spbs-field-row">
			<label for="regular_start">Regular License Start:</label>
			<input type="datetime-local" id="regular_start" name="regular_start" value="<?php echo esc_attr( $regular_start ); ?>" />
		</div>
		<?php
	}
	
	public function persist_business_metrics( $post_id, $post ) {
		if ( ! isset( $_POST['spbs_metrics_nonce'] ) || ! wp_verify_nonce( $_POST['spbs_metrics_nonce'], 'spbs_portfolio_metrics' ) ) {
			return;
		}
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		
		$business_fields = array(
			'serial_code' => 'sanitize_text_field',
			'n_patents' => 'absint',
			'n_lic' => 'absint',
			'u_upfront' => 'floatval',
			'cost_price' => 'floatval',
			'option_deadline' => 'sanitize_text_field',
			'regular_start' => 'sanitize_text_field',
		);
		
		foreach ( $business_fields as $field => $sanitizer ) {
			if ( isset( $_POST[ $field ] ) ) {
				$clean_value = call_user_func( $sanitizer, $_POST[ $field ] );
				update_post_meta( $post_id, '_' . $field, $clean_value );
			}
		}
		
		$essnt_value = isset( $_POST['essnt'] ) ? '1' : '0';
		update_post_meta( $post_id, '_essnt', $essnt_value );
		
		$this->sync_to_custom_table( $post_id, $post );
	}
	
	private function sync_to_custom_table( $post_id, $post ) {
		global $wpdb;
		
		$portfolio_data = array(
			'portfolio_title' => $post->post_title,
			'portfolio_narrative' => $post->post_content,
			'serial_identifier' => get_post_meta( $post_id, '_serial_code', true ),
			'n_patents' => (int) get_post_meta( $post_id, '_n_patents', true ),
			'essnt' => (int) get_post_meta( $post_id, '_essnt', true ),
			'n_lic' => (int) get_post_meta( $post_id, '_n_lic', true ),
			'u_upfront' => (float) get_post_meta( $post_id, '_u_upfront', true ),
			'base_price' => (float) get_post_meta( $post_id, '_cost_price', true ),
			'current_status' => $post->post_status === 'publish' ? 'live' : 'inactive',
		);
		
		$table = $wpdb->prefix . 'licensing_portfolios';
		$existing = $wpdb->get_var( $wpdb->prepare(
			"SELECT portfolio_id FROM $table WHERE serial_identifier = %s",
			$portfolio_data['serial_identifier']
		) );
		
		if ( $existing ) {
			$wpdb->update( $table, $portfolio_data, array( 'portfolio_id' => $existing ) );
		} else {
			$wpdb->insert( $table, $portfolio_data );
		}
	}
	
	public function customize_admin_columns( $columns ) {
		$new_columns = array();
		$new_columns['cb'] = $columns['cb'];
		$new_columns['title'] = 'Portfolio Name';
		$new_columns['serial_code'] = 'Serial #';
		$new_columns['n_patents'] = 'Patents';
		$new_columns['n_lic'] = 'Licensees';
		$new_columns['u_upfront'] = 'Upfront';
		$new_columns['essnt'] = 'Essential';
		$new_columns['date'] = 'Date';
		
		return $new_columns;
	}
	
	public function populate_admin_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'serial_code':
				echo esc_html( get_post_meta( $post_id, '_serial_code', true ) );
				break;
			case 'n_patents':
				echo esc_html( get_post_meta( $post_id, '_n_patents', true ) ?: '0' );
				break;
			case 'n_lic':
				echo esc_html( get_post_meta( $post_id, '_n_lic', true ) ?: '0' );
				break;
			case 'u_upfront':
				$upfront = get_post_meta( $post_id, '_u_upfront', true );
				echo '$' . number_format( (float) $upfront, 2 );
				break;
			case 'essnt':
				$is_essential = get_post_meta( $post_id, '_essnt', true );
				echo $is_essential == '1' ? '✓ Yes' : '—';
				break;
		}
	}
}
