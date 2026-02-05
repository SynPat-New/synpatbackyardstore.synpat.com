<?php
/**
 * Patent Details Renderer
 * Individual patent display (inner room details)
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Patent_Details_Renderer {
	
	public function __construct() {
		add_action( 'init', array( $this, 'register_patent_content_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'attach_patent_details_panel' ) );
		add_action( 'save_post_individual_patent', array( $this, 'persist_patent_details' ), 10, 2 );
	}
	
	public function register_patent_content_type() {
		$config = array(
			'labels' => array(
				'name' => 'Individual Patents',
				'singular_name' => 'Patent',
				'add_new' => 'Add Patent',
				'add_new_item' => 'Register New Patent',
				'edit_item' => 'Edit Patent Details',
				'view_item' => 'View Patent',
				'search_items' => 'Search Patents',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'patent-details' ),
			'menu_icon' => 'dashicons-media-document',
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest' => true,
		);
		
		register_post_type( 'individual_patent', $config );
	}
	
	public function attach_patent_details_panel() {
		add_meta_box(
			'patent_legal_info',
			'Patent Legal Information',
			array( $this, 'render_patent_fields_ui' ),
			'individual_patent',
			'normal',
			'high'
		);
		
		add_meta_box(
			'patent_portfolio_link',
			'Portfolio Association',
			array( $this, 'render_portfolio_selector_ui' ),
			'individual_patent',
			'side',
			'default'
		);
	}
	
	public function render_patent_fields_ui( $post ) {
		wp_nonce_field( 'spbs_patent_details', 'spbs_patent_nonce' );
		
		$patent_num = get_post_meta( $post->ID, '_patent_num', true );
		$app_number = get_post_meta( $post->ID, '_app_number', true );
		$file_date = get_post_meta( $post->ID, '_file_date', true );
		$issue_date = get_post_meta( $post->ID, '_issue_date', true );
		$expire_date = get_post_meta( $post->ID, '_expire_date', true );
		$current_owner = get_post_meta( $post->ID, '_current_owner', true );
		$original_inventor = get_post_meta( $post->ID, '_original_inventor', true );
		$claim_total = get_post_meta( $post->ID, '_claim_total', true );
		$citations_forward = get_post_meta( $post->ID, '_citations_forward', true );
		$citations_backward = get_post_meta( $post->ID, '_citations_backward', true );
		$legal_status = get_post_meta( $post->ID, '_legal_status', true ) ?: 'in_force';
		
		?>
		<table class="form-table">
			<tr>
				<th><label for="patent_num">Patent Number</label></th>
				<td><input type="text" id="patent_num" name="patent_num" value="<?php echo esc_attr( $patent_num ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="app_number">Application Number</label></th>
				<td><input type="text" id="app_number" name="app_number" value="<?php echo esc_attr( $app_number ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="file_date">Filing Date</label></th>
				<td><input type="date" id="file_date" name="file_date" value="<?php echo esc_attr( $file_date ); ?>" /></td>
			</tr>
			<tr>
				<th><label for="issue_date">Issue Date</label></th>
				<td><input type="date" id="issue_date" name="issue_date" value="<?php echo esc_attr( $issue_date ); ?>" /></td>
			</tr>
			<tr>
				<th><label for="expire_date">Expiration Date</label></th>
				<td><input type="date" id="expire_date" name="expire_date" value="<?php echo esc_attr( $expire_date ); ?>" /></td>
			</tr>
			<tr>
				<th><label for="current_owner">Current Owner</label></th>
				<td><input type="text" id="current_owner" name="current_owner" value="<?php echo esc_attr( $current_owner ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="original_inventor">Original Inventor</label></th>
				<td><input type="text" id="original_inventor" name="original_inventor" value="<?php echo esc_attr( $original_inventor ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="legal_status">Legal Status</label></th>
				<td>
					<select id="legal_status" name="legal_status">
						<option value="in_force" <?php selected( $legal_status, 'in_force' ); ?>>In Force</option>
						<option value="expired" <?php selected( $legal_status, 'expired' ); ?>>Expired</option>
						<option value="abandoned" <?php selected( $legal_status, 'abandoned' ); ?>>Abandoned</option>
						<option value="pending" <?php selected( $legal_status, 'pending' ); ?>>Pending</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="claim_total">Total Claims</label></th>
				<td><input type="number" id="claim_total" name="claim_total" value="<?php echo esc_attr( $claim_total ); ?>" min="0" /></td>
			</tr>
			<tr>
				<th><label for="citations_forward">Forward Citations</label></th>
				<td><input type="number" id="citations_forward" name="citations_forward" value="<?php echo esc_attr( $citations_forward ); ?>" min="0" /></td>
			</tr>
			<tr>
				<th><label for="citations_backward">Backward Citations</label></th>
				<td><input type="number" id="citations_backward" name="citations_backward" value="<?php echo esc_attr( $citations_backward ); ?>" min="0" /></td>
			</tr>
		</table>
		<?php
	}
	
	public function render_portfolio_selector_ui( $post ) {
		$linked_portfolios = get_post_meta( $post->ID, '_linked_portfolios', true );
		if ( ! is_array( $linked_portfolios ) ) {
			$linked_portfolios = array();
		}
		
		$portfolios = get_posts( array(
			'post_type' => 'patent_portfolio',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		) );
		
		?>
		<p><strong>Select portfolios containing this patent:</strong></p>
		<?php foreach ( $portfolios as $portfolio ) : ?>
			<label style="display:block;margin:5px 0;">
				<input type="checkbox" name="linked_portfolios[]" value="<?php echo $portfolio->ID; ?>" 
					<?php checked( in_array( $portfolio->ID, $linked_portfolios ) ); ?> />
				<?php echo esc_html( $portfolio->post_title ); ?>
			</label>
		<?php endforeach; ?>
		<?php
	}
	
	public function persist_patent_details( $post_id, $post ) {
		if ( ! isset( $_POST['spbs_patent_nonce'] ) || ! wp_verify_nonce( $_POST['spbs_patent_nonce'], 'spbs_patent_details' ) ) {
			return;
		}
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		
		$patent_fields = array(
			'patent_num' => 'sanitize_text_field',
			'app_number' => 'sanitize_text_field',
			'file_date' => 'sanitize_text_field',
			'issue_date' => 'sanitize_text_field',
			'expire_date' => 'sanitize_text_field',
			'current_owner' => 'sanitize_text_field',
			'original_inventor' => 'sanitize_text_field',
			'legal_status' => 'sanitize_text_field',
			'claim_total' => 'absint',
			'citations_forward' => 'absint',
			'citations_backward' => 'absint',
		);
		
		foreach ( $patent_fields as $field => $sanitizer ) {
			if ( isset( $_POST[ $field ] ) ) {
				$clean_value = call_user_func( $sanitizer, $_POST[ $field ] );
				update_post_meta( $post_id, '_' . $field, $clean_value );
			}
		}
		
		if ( isset( $_POST['linked_portfolios'] ) && is_array( $_POST['linked_portfolios'] ) ) {
			$portfolio_ids = array_map( 'absint', $_POST['linked_portfolios'] );
			update_post_meta( $post_id, '_linked_portfolios', $portfolio_ids );
		} else {
			delete_post_meta( $post_id, '_linked_portfolios' );
		}
		
		$this->sync_to_custom_table( $post_id, $post );
	}
	
	private function sync_to_custom_table( $post_id, $post ) {
		global $wpdb;
		
		$patent_data = array(
			'patent_identifier' => get_post_meta( $post_id, '_patent_num', true ),
			'patent_name' => $post->post_title,
			'application_ref' => get_post_meta( $post_id, '_app_number', true ),
			'filing_timestamp' => get_post_meta( $post_id, '_file_date', true ),
			'grant_timestamp' => get_post_meta( $post_id, '_issue_date', true ),
			'expiry_timestamp' => get_post_meta( $post_id, '_expire_date', true ),
			'assignee_current' => get_post_meta( $post_id, '_current_owner', true ),
			'inventor_original' => get_post_meta( $post_id, '_original_inventor', true ),
			'enforcement_status' => get_post_meta( $post_id, '_legal_status', true ),
			'technical_abstract' => $post->post_content,
			'independent_claims' => (int) get_post_meta( $post_id, '_claim_total', true ),
			'cited_by_count' => (int) get_post_meta( $post_id, '_citations_forward', true ),
			'cites_prior_count' => (int) get_post_meta( $post_id, '_citations_backward', true ),
		);
		
		if ( empty( $patent_data['patent_identifier'] ) ) {
			return;
		}
		
		$table = $wpdb->prefix . 'patent_inventory';
		$existing = $wpdb->get_var( $wpdb->prepare(
			"SELECT patent_id FROM $table WHERE patent_identifier = %s",
			$patent_data['patent_identifier']
		) );
		
		if ( $existing ) {
			$wpdb->update( $table, $patent_data, array( 'patent_id' => $existing ) );
		} else {
			$wpdb->insert( $table, $patent_data );
			$existing = $wpdb->insert_id;
		}
		
		$linked_portfolios = get_post_meta( $post_id, '_linked_portfolios', true );
		if ( is_array( $linked_portfolios ) && $existing ) {
			foreach ( $linked_portfolios as $portfolio_post_id ) {
				$serial = get_post_meta( $portfolio_post_id, '_serial_code', true );
				if ( $serial ) {
					$portfolio_table = $wpdb->prefix . 'licensing_portfolios';
					$portfolio_id = $wpdb->get_var( $wpdb->prepare(
						"SELECT portfolio_id FROM $portfolio_table WHERE serial_identifier = %s",
						$serial
					) );
					
					if ( $portfolio_id ) {
						$mapping_table = $wpdb->prefix . 'portfolio_contains_patents';
						$wpdb->query( $wpdb->prepare(
							"INSERT IGNORE INTO $mapping_table (portfolio_fk, patent_fk) VALUES (%d, %d)",
							$portfolio_id, $existing
						) );
					}
				}
			}
		}
	}
}
