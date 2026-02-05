<?php
/**
 * Plugin Name: SynPat Backyard Portfolio Store
 * Description: Patent licensing backyard store - migrate from CodeIgniter to WordPress
 * Version: 1.0.0
 * Author: SynPat
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) die;

define( 'SYNPAT_BACKYARD_VER', '1.0.0' );
define( 'SYNPAT_BACKYARD_PATH', plugin_dir_path( __FILE__ ) );
define( 'SYNPAT_BACKYARD_URL', plugin_dir_url( __FILE__ ) );

final class Backyard_Patent_Store {
	
	private static $instance_holder;
	
	public static function boot_system() {
		if ( null === self::$instance_holder ) {
			self::$instance_holder = new self();
		}
		return self::$instance_holder;
	}
	
	private function __construct() {
		$this->load_subsystems();
		$this->activate_lifecycle_hooks();
	}
	
	private function load_subsystems() {
		$components = glob( SYNPAT_BACKYARD_PATH . 'includes/*.php' );
		$components = array_merge( $components, glob( SYNPAT_BACKYARD_PATH . 'admin/*.php' ) );
		$components = array_merge( $components, glob( SYNPAT_BACKYARD_PATH . 'public/*.php' ) );
		
		foreach ( $components as $component_file ) {
			if ( file_exists( $component_file ) ) {
				require_once $component_file;
			}
		}
	}
	
	private function activate_lifecycle_hooks() {
		register_activation_hook( __FILE__, array( $this, 'on_plugin_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'on_plugin_deactivation' ) );
	}
	
	public function on_plugin_activation() {
		Licensing_Portfolio_Storage::initialize_database_tables();
		flush_rewrite_rules();
	}
	
	public function on_plugin_deactivation() {
		flush_rewrite_rules();
	}
}

Backyard_Patent_Store::boot_system();
