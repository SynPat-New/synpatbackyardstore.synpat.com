<?php
/**
 * Admin Settings Page View
 * Configuration for SynPat Backyard Store
 */

if ( ! defined( 'ABSPATH' ) ) die;

$current_settings = get_option( 'synpat_backyard_settings', array() );
?>

<div class="wrap synpat-admin-settings">
	<h1>SynPat Backyard Store Settings</h1>
	
	<form method="post" action="options.php">
		<?php settings_fields( 'synpat_backyard_settings' ); ?>
		
		<h2>General Settings</h2>
		<table class="form-table">
			<tr>
				<th>Enable Store</th>
				<td>
					<input type="checkbox" name="synpat_backyard_settings[store_enabled]" value="1" 
						<?php checked( isset( $current_settings['store_enabled'] ) && $current_settings['store_enabled'] ); ?>>
				</td>
			</tr>
			<tr>
				<th>Portfolios Per Page</th>
				<td>
					<input type="number" name="synpat_backyard_settings[portfolios_per_page]" 
						value="<?php echo esc_attr( isset( $current_settings['portfolios_per_page'] ) ? $current_settings['portfolios_per_page'] : 20 ); ?>">
				</td>
			</tr>
		</table>
		
		<h2>Store Statistics</h2>
		<?php
		global $wpdb;
		$portfolio_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}licensing_portfolios" );
		$patent_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}patent_inventory" );
		?>
		<p><strong>Portfolios:</strong> <?php echo esc_html( $portfolio_count ); ?></p>
		<p><strong>Patents:</strong> <?php echo esc_html( $patent_count ); ?></p>
		
		<?php submit_button(); ?>
	</form>
</div>
