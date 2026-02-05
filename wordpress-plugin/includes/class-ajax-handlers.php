<?php
/**
 * Async Handler Router
 * AJAX handlers for wishlist and tech preferences
 */

if ( ! defined( 'ABSPATH' ) ) die;

class Async_Handler_Router {
	
	public function __construct() {
		add_action( 'wp_ajax_add_to_wishlist', array( $this, 'handle_add_to_wishlist' ) );
		add_action( 'wp_ajax_remove_from_wishlist', array( $this, 'handle_remove_from_wishlist' ) );
		add_action( 'wp_ajax_save_tech_preference', array( $this, 'handle_save_tech_preference' ) );
		add_action( 'wp_ajax_get_portfolio_patents', array( $this, 'handle_get_portfolio_patents' ) );
	}
	
	public function handle_add_to_wishlist() {
		check_ajax_referer( 'backyard_ajax_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'Please log in first.' ) );
		}
		
		$customer_id = get_current_user_id();
		$portfolio_id = isset( $_POST['portfolio_id'] ) ? intval( $_POST['portfolio_id'] ) : 0;
		$notes = isset( $_POST['notes'] ) ? sanitize_textarea_field( $_POST['notes'] ) : '';
		
		if ( ! $portfolio_id ) {
			wp_send_json_error( array( 'message' => 'Invalid portfolio.' ) );
		}
		
		$wish_id = Licensing_Portfolio_Storage::customer_adds_to_wishlist( $customer_id, $portfolio_id, $notes );
		
		if ( $wish_id ) {
			wp_send_json_success( array( 
				'message' => 'Added to wishlist!',
				'wish_id' => $wish_id
			) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to add to wishlist.' ) );
		}
	}
	
	public function handle_remove_from_wishlist() {
		check_ajax_referer( 'backyard_ajax_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'Please log in first.' ) );
		}
		
		$customer_id = get_current_user_id();
		$portfolio_id = isset( $_POST['portfolio_id'] ) ? intval( $_POST['portfolio_id'] ) : 0;
		
		if ( ! $portfolio_id ) {
			wp_send_json_error( array( 'message' => 'Invalid portfolio.' ) );
		}
		
		$removed = Licensing_Portfolio_Storage::customer_removes_from_wishlist( $customer_id, $portfolio_id );
		
		if ( $removed ) {
			wp_send_json_success( array( 'message' => 'Removed from wishlist.' ) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to remove from wishlist.' ) );
		}
	}
	
	public function handle_save_tech_preference() {
		check_ajax_referer( 'backyard_ajax_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'Please log in first.' ) );
		}
		
		$customer_id = get_current_user_id();
		$tech_sector = isset( $_POST['tech_sector'] ) ? sanitize_text_field( $_POST['tech_sector'] ) : '';
		$weight = isset( $_POST['weight'] ) ? intval( $_POST['weight'] ) : 1;
		
		if ( ! $tech_sector ) {
			wp_send_json_error( array( 'message' => 'Invalid technology sector.' ) );
		}
		
		$pref_id = Licensing_Portfolio_Storage::record_technology_preference( $customer_id, $tech_sector, $weight );
		
		if ( $pref_id ) {
			wp_send_json_success( array( 
				'message' => 'Preference saved!',
				'pref_id' => $pref_id
			) );
		} else {
			wp_send_json_error( array( 'message' => 'Failed to save preference.' ) );
		}
	}
	
	public function handle_get_portfolio_patents() {
		check_ajax_referer( 'backyard_ajax_nonce', 'nonce' );
		
		$portfolio_id = isset( $_POST['portfolio_id'] ) ? intval( $_POST['portfolio_id'] ) : 0;
		
		if ( ! $portfolio_id ) {
			wp_send_json_error( array( 'message' => 'Invalid portfolio.' ) );
		}
		
		$patents = Licensing_Portfolio_Storage::get_patents_in_portfolio( $portfolio_id );
		
		wp_send_json_success( array( 
			'patents' => $patents,
			'count' => count( $patents )
		) );
	}
}
