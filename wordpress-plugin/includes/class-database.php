<?php
/**
 * Backyard Store Data - Patent Portfolio Licensing Database
 * Business logic from CodeIgniter customer_model.php and lead_model.php
 * Fields: n_patents, essnt, n_lic, u_upfront (from requirements)
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Licensing_Portfolio_Storage {
	
	// Create all tables needed for patent portfolio licensing business
	public static function initialize_database_tables() {
		global $wpdb;
		$collation = $wpdb->get_charset_collate();
		
		// Portfolios table with specific business fields
		$create_portfolios = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}licensing_portfolios (
			portfolio_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			portfolio_title VARCHAR(300),
			portfolio_narrative LONGTEXT,
			serial_identifier VARCHAR(120) UNIQUE KEY,
			n_patents INT UNSIGNED DEFAULT 0,
			essnt TINYINT UNSIGNED DEFAULT 0,
			n_lic INT UNSIGNED DEFAULT 0,
			u_upfront DECIMAL(18,2) DEFAULT 0.00,
			base_price DECIMAL(18,2),
			option_expires_on DATETIME,
			regular_licensing_begins DATETIME,
			late_licensing_begins DATETIME,
			button_status TINYINT DEFAULT 1,
			technology_sector VARCHAR(200),
			current_status VARCHAR(40) DEFAULT 'live',
			recorded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			KEY status_filter (current_status),
			KEY sector_filter (technology_sector)
		) $collation;";
		
		// Patents table
		$create_patents = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}patent_inventory (
			patent_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			patent_identifier VARCHAR(120) UNIQUE KEY NOT NULL,
			patent_name TEXT,
			application_ref VARCHAR(120),
			filing_timestamp DATE,
			grant_timestamp DATE,
			expiry_timestamp DATE,
			assignee_current VARCHAR(300),
			inventor_original VARCHAR(300),
			enforcement_status VARCHAR(60) DEFAULT 'active',
			technical_abstract LONGTEXT,
			independent_claims INT DEFAULT 0,
			cited_by_count INT DEFAULT 0,
			cites_prior_count INT DEFAULT 0,
			added_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
		) $collation;";
		
		// Portfolio-Patent mapping
		$create_mapping = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}portfolio_contains_patents (
			connection_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			portfolio_fk BIGINT UNSIGNED,
			patent_fk BIGINT UNSIGNED,
			display_sequence INT DEFAULT 0,
			connection_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
			KEY by_portfolio (portfolio_fk),
			KEY by_patent (patent_fk)
		) $collation;";
		
		// Wishlist table (from customer_model.php line 14: public $table_wishlist = 'wishlist')
		$create_wishlist = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}buyer_wishlist (
			wish_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			customer_fk BIGINT UNSIGNED,
			portfolio_fk BIGINT UNSIGNED,
			wishlisted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			customer_memo TEXT,
			UNIQUE KEY one_wish_per_portfolio (customer_fk, portfolio_fk),
			KEY by_customer (customer_fk)
		) $collation;";
		
		// Technology preferences (from customer_model.php line 8: public $table_technology_preference)
		$create_prefs = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}buyer_tech_preferences (
			preference_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			customer_fk BIGINT UNSIGNED,
			technology_sector VARCHAR(200),
			interest_weight TINYINT DEFAULT 1,
			preference_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
			KEY by_customer (customer_fk)
		) $collation;";
		
		// Licensees (potential vs actual)
		$create_licensees = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}actual_and_potential_licensees (
			licensee_record_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			portfolio_fk BIGINT UNSIGNED,
			company_entity VARCHAR(300),
			relationship_category ENUM('potential','actual') DEFAULT 'potential',
			executed_on DATE,
			agreement_details LONGTEXT,
			created_timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
			KEY by_portfolio (portfolio_fk),
			KEY by_relationship (relationship_category)
		) $collation;";
		
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $create_portfolios );
		dbDelta( $create_patents );
		dbDelta( $create_mapping );
		dbDelta( $create_wishlist );
		dbDelta( $create_prefs );
		dbDelta( $create_licensees );
	}
	
	// Query portfolios with business filters
	public static function query_portfolios_for_catalog( $filters = array() ) {
		global $wpdb;
		$table = $wpdb->prefix . 'licensing_portfolios';
		
		$conditions = array( "current_status = 'live'" );
		$prepare_args = array();
		
		if ( ! empty( $filters['technology_sector'] ) ) {
			$conditions[] = 'technology_sector = %s';
			$prepare_args[] = $filters['technology_sector'];
		}
		
		if ( isset( $filters['minimum_patent_count'] ) && $filters['minimum_patent_count'] > 0 ) {
			$conditions[] = 'n_patents >= %d';
			$prepare_args[] = intval( $filters['minimum_patent_count'] );
		}
		
		if ( ! empty( $filters['only_essential'] ) ) {
			$conditions[] = 'essnt = 1';
		}
		
		if ( ! empty( $filters['has_licensees'] ) ) {
			$conditions[] = 'n_lic > 0';
		}
		
		$where_clause = implode( ' AND ', $conditions );
		$query_base = "SELECT * FROM $table WHERE $where_clause ORDER BY recorded_at DESC";
		
		if ( count( $prepare_args ) > 0 ) {
			$sql_query = $wpdb->prepare( $query_base, $prepare_args );
		} else {
			$sql_query = $query_base;
		}
		
		return $wpdb->get_results( $sql_query );
	}
	
	public static function retrieve_single_portfolio( $portfolio_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'licensing_portfolios';
		$sql = $wpdb->prepare( "SELECT * FROM $table WHERE portfolio_id = %d", $portfolio_id );
		return $wpdb->get_row( $sql );
	}
	
	public static function insert_new_portfolio( $portfolio_data ) {
		global $wpdb;
		$table = $wpdb->prefix . 'licensing_portfolios';
		$wpdb->insert( $table, $portfolio_data );
		return $wpdb->insert_id;
	}
	
	public static function update_existing_portfolio( $portfolio_id, $update_data ) {
		global $wpdb;
		$table = $wpdb->prefix . 'licensing_portfolios';
		$wpdb->update( $table, $update_data, array( 'portfolio_id' => $portfolio_id ) );
		return $wpdb->rows_affected;
	}
	
	public static function get_patents_in_portfolio( $portfolio_id ) {
		global $wpdb;
		$patents_table = $wpdb->prefix . 'patent_inventory';
		$mapping_table = $wpdb->prefix . 'portfolio_contains_patents';
		
		$sql = $wpdb->prepare(
			"SELECT p.*, m.display_sequence 
			FROM $patents_table p
			INNER JOIN $mapping_table m ON p.patent_id = m.patent_fk
			WHERE m.portfolio_fk = %d
			ORDER BY m.display_sequence, p.filing_timestamp DESC",
			$portfolio_id
		);
		
		return $wpdb->get_results( $sql );
	}
	
	public static function find_patent_by_number( $patent_number ) {
		global $wpdb;
		$table = $wpdb->prefix . 'patent_inventory';
		$sql = $wpdb->prepare( "SELECT * FROM $table WHERE patent_identifier = %s", $patent_number );
		return $wpdb->get_row( $sql );
	}
	
	public static function store_patent_record( $patent_data ) {
		global $wpdb;
		$table = $wpdb->prefix . 'patent_inventory';
		$wpdb->insert( $table, $patent_data );
		return $wpdb->insert_id;
	}
	
	public static function connect_patent_to_portfolio( $portfolio_id, $patent_id, $sequence = 0 ) {
		global $wpdb;
		$table = $wpdb->prefix . 'portfolio_contains_patents';
		
		// Check if already connected
		$check_sql = $wpdb->prepare(
			"SELECT connection_id FROM $table WHERE portfolio_fk = %d AND patent_fk = %d",
			$portfolio_id,
			$patent_id
		);
		$existing = $wpdb->get_var( $check_sql );
		
		if ( $existing ) {
			return $existing;
		}
		
		$wpdb->insert( $table, array(
			'portfolio_fk' => $portfolio_id,
			'patent_fk' => $patent_id,
			'display_sequence' => $sequence
		) );
		
		return $wpdb->insert_id;
	}
	
	// Wishlist operations from customer_model.php
	public static function customer_adds_to_wishlist( $customer_id, $portfolio_id, $notes = '' ) {
		global $wpdb;
		$table = $wpdb->prefix . 'buyer_wishlist';
		
		// Check existing
		$check_sql = $wpdb->prepare(
			"SELECT wish_id FROM $table WHERE customer_fk = %d AND portfolio_fk = %d",
			$customer_id,
			$portfolio_id
		);
		$existing = $wpdb->get_var( $check_sql );
		
		if ( $existing ) {
			return $existing;
		}
		
		$wpdb->insert( $table, array(
			'customer_fk' => $customer_id,
			'portfolio_fk' => $portfolio_id,
			'customer_memo' => $notes
		) );
		
		return $wpdb->insert_id;
	}
	
	public static function customer_removes_from_wishlist( $customer_id, $portfolio_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'buyer_wishlist';
		$deleted = $wpdb->delete( $table, array(
			'customer_fk' => $customer_id,
			'portfolio_fk' => $portfolio_id
		) );
		return $deleted;
	}
	
	public static function get_customer_wishlist_items( $customer_id ) {
		global $wpdb;
		$wishlist_table = $wpdb->prefix . 'buyer_wishlist';
		$portfolio_table = $wpdb->prefix . 'licensing_portfolios';
		
		$sql = $wpdb->prepare(
			"SELECT p.*, w.wishlisted_at, w.customer_memo
			FROM $wishlist_table w
			INNER JOIN $portfolio_table p ON w.portfolio_fk = p.portfolio_id
			WHERE w.customer_fk = %d
			ORDER BY w.wishlisted_at DESC",
			$customer_id
		);
		
		return $wpdb->get_results( $sql );
	}
	
	public static function check_portfolio_in_wishlist( $customer_id, $portfolio_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'buyer_wishlist';
		$sql = $wpdb->prepare(
			"SELECT COUNT(*) FROM $table WHERE customer_fk = %d AND portfolio_fk = %d",
			$customer_id,
			$portfolio_id
		);
		$count = $wpdb->get_var( $sql );
		return $count > 0;
	}
	
	public static function record_technology_preference( $customer_id, $tech_sector, $weight = 1 ) {
		global $wpdb;
		$table = $wpdb->prefix . 'buyer_tech_preferences';
		
		// Check existing
		$check_sql = $wpdb->prepare(
			"SELECT preference_id FROM $table WHERE customer_fk = %d AND technology_sector = %s",
			$customer_id,
			$tech_sector
		);
		$existing = $wpdb->get_var( $check_sql );
		
		if ( $existing ) {
			$wpdb->update(
				$table,
				array( 'interest_weight' => $weight ),
				array( 'preference_id' => $existing )
			);
			return $existing;
		}
		
		$wpdb->insert( $table, array(
			'customer_fk' => $customer_id,
			'technology_sector' => $tech_sector,
			'interest_weight' => $weight
		) );
		
		return $wpdb->insert_id;
	}
	
	public static function get_customer_tech_preferences( $customer_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'buyer_tech_preferences';
		$sql = $wpdb->prepare(
			"SELECT * FROM $table WHERE customer_fk = %d ORDER BY interest_weight DESC",
			$customer_id
		);
		return $wpdb->get_results( $sql );
	}
	
	public static function add_licensee_record( $portfolio_id, $company_name, $licensee_type = 'potential', $extra_data = array() ) {
		global $wpdb;
		$table = $wpdb->prefix . 'actual_and_potential_licensees';
		
		$insert_data = array(
			'portfolio_fk' => $portfolio_id,
			'company_entity' => $company_name,
			'relationship_category' => $licensee_type
		);
		
		if ( isset( $extra_data['executed_on'] ) ) {
			$insert_data['executed_on'] = $extra_data['executed_on'];
		}
		
		if ( isset( $extra_data['agreement_details'] ) ) {
			$insert_data['agreement_details'] = $extra_data['agreement_details'];
		}
		
		$wpdb->insert( $table, $insert_data );
		return $wpdb->insert_id;
	}
	
	public static function get_portfolio_licensees( $portfolio_id, $filter_type = null ) {
		global $wpdb;
		$table = $wpdb->prefix . 'actual_and_potential_licensees';
		
		if ( $filter_type ) {
			$sql = $wpdb->prepare(
				"SELECT * FROM $table WHERE portfolio_fk = %d AND relationship_category = %s ORDER BY created_timestamp DESC",
				$portfolio_id,
				$filter_type
			);
		} else {
			$sql = $wpdb->prepare(
				"SELECT * FROM $table WHERE portfolio_fk = %d ORDER BY created_timestamp DESC",
				$portfolio_id
			);
		}
		
		return $wpdb->get_results( $sql );
	}
}
