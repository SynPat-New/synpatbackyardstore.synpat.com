<?php
/**
 * Patent List Template
 * Display patents in a portfolio (used within portfolio details)
 */

if ( ! defined( 'ABSPATH' ) ) die;

// Variable: $patents array, $portfolio_id
?>
<div class="synpat-patent-list">
	<?php if ( empty( $patents ) ) : ?>
		<div class="no-patents-message">
			<p>This portfolio does not have any patents linked yet.</p>
		</div>
	<?php else : ?>
		<div class="patents-table-wrapper">
			<table class="patents-data-table">
				<thead>
					<tr>
						<th>Patent Number</th>
						<th>Title</th>
						<th>Filed</th>
						<th>Granted</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $patents as $patent ) : ?>
						<tr class="patent-row" data-patent-id="<?php echo esc_attr( $patent->patent_id ); ?>">
							<td class="patent-number">
								<strong><?php echo esc_html( $patent->patent_identifier ); ?></strong>
							</td>
							<td class="patent-title">
								<?php echo esc_html( wp_trim_words( $patent->patent_name, 10 ) ); ?>
							</td>
							<td class="patent-filed">
								<?php echo esc_html( date( 'M Y', strtotime( $patent->filing_timestamp ) ) ); ?>
							</td>
							<td class="patent-granted">
								<?php echo esc_html( date( 'M Y', strtotime( $patent->grant_timestamp ) ) ); ?>
							</td>
							<td class="patent-status">
								<span class="status-indicator status-<?php echo esc_attr( $patent->enforcement_status ); ?>">
									<?php echo esc_html( ucfirst( $patent->enforcement_status ) ); ?>
								</span>
							</td>
							<td class="patent-actions">
								<a href="?patent=<?php echo esc_attr( $patent->patent_id ); ?>" class="btn-view-patent-sm">
									View Details
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		
		<div class="patents-summary">
			<p><strong>Total Patents:</strong> <?php echo count( $patents ); ?></p>
		</div>
	<?php endif; ?>
</div>
