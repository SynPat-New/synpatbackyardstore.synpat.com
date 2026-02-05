<?php
/**
 * Single Patent Detail Template
 * The "inner room" - detailed view of individual patent
 */

if ( ! defined( 'ABSPATH' ) ) die;

// Variable: $patent object
?>
<div class="synpat-inner-room">
	<div class="patent-header-section">
		<h1><?php echo esc_html( $patent->patent_identifier ); ?></h1>
		<h2 class="patent-full-title"><?php echo esc_html( $patent->patent_name ); ?></h2>
		
		<div class="patent-status-bar">
			<span class="status-badge status-<?php echo esc_attr( $patent->enforcement_status ); ?>">
				<?php echo esc_html( ucfirst( $patent->enforcement_status ) ); ?>
			</span>
		</div>
	</div>
	
	<div class="patent-main-content">
		<div class="patent-info-columns">
			<div class="column-left">
				<section class="patent-section">
					<h3>Technical Abstract</h3>
					<div class="abstract-content">
						<?php echo wp_kses_post( nl2br( $patent->technical_abstract ) ); ?>
					</div>
				</section>
				
				<section class="patent-section">
					<h3>Filing & Grant Information</h3>
					<table class="patent-info-table">
						<tr>
							<th>Application Reference:</th>
							<td><?php echo esc_html( $patent->application_ref ); ?></td>
						</tr>
						<tr>
							<th>Filing Date:</th>
							<td><?php echo esc_html( date( 'F j, Y', strtotime( $patent->filing_timestamp ) ) ); ?></td>
						</tr>
						<tr>
							<th>Grant Date:</th>
							<td><?php echo esc_html( date( 'F j, Y', strtotime( $patent->grant_timestamp ) ) ); ?></td>
						</tr>
						<tr>
							<th>Expiry Date:</th>
							<td><?php echo esc_html( date( 'F j, Y', strtotime( $patent->expiry_timestamp ) ) ); ?></td>
						</tr>
					</table>
				</section>
			</div>
			
			<div class="column-right">
				<section class="patent-section">
					<h3>Ownership & Inventors</h3>
					<table class="patent-info-table">
						<tr>
							<th>Current Assignee:</th>
							<td><?php echo esc_html( $patent->assignee_current ); ?></td>
						</tr>
						<tr>
							<th>Original Inventor:</th>
							<td><?php echo esc_html( $patent->inventor_original ); ?></td>
						</tr>
					</table>
				</section>
				
				<section class="patent-section">
					<h3>Claims & Citations</h3>
					<table class="patent-info-table">
						<tr>
							<th>Independent Claims:</th>
							<td><?php echo esc_html( $patent->independent_claims ); ?></td>
						</tr>
						<tr>
							<th>Cited By (Forward):</th>
							<td><?php echo esc_html( $patent->cited_by_count ); ?></td>
						</tr>
						<tr>
							<th>Cites (Backward):</th>
							<td><?php echo esc_html( $patent->cites_prior_count ); ?></td>
						</tr>
					</table>
				</section>
			</div>
		</div>
	</div>
	
	<div class="patent-footer-actions">
		<a href="javascript:history.back()" class="btn-back">← Back to Portfolio</a>
	</div>
</div>
