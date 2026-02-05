<?php
/**
 * Single Portfolio Display Template
 * Shows portfolio details and list of patents
 */

if ( ! defined( 'ABSPATH' ) ) die;

// Variables: $portfolio object, $patents array
?>
<div class="synpat-portfolio-details">
	<div class="portfolio-header">
		<h1><?php echo esc_html( $portfolio->portfolio_title ); ?></h1>
		<div class="portfolio-meta-bar">
			<span class="meta-item">
				<strong>Serial:</strong> <?php echo esc_html( $portfolio->serial_identifier ); ?>
			</span>
			<span class="meta-item">
				<strong>Patents:</strong> <?php echo esc_html( $portfolio->n_patents ); ?>
			</span>
			<span class="meta-item">
				<strong>Licensees:</strong> <?php echo esc_html( $portfolio->n_lic ); ?>
			</span>
			<?php if ( $portfolio->essnt ) : ?>
				<span class="meta-item essential-indicator">✓ Essential</span>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="portfolio-content-area">
		<section class="portfolio-narrative">
			<h2>Portfolio Description</h2>
			<div class="narrative-text">
				<?php echo wp_kses_post( nl2br( $portfolio->portfolio_narrative ) ); ?>
			</div>
		</section>
		
		<section class="portfolio-business-terms">
			<h2>Licensing Terms</h2>
			<table class="terms-table">
				<tr>
					<th>Base Price:</th>
					<td>$<?php echo number_format( $portfolio->base_price, 2 ); ?></td>
				</tr>
				<?php if ( $portfolio->u_upfront > 0 ) : ?>
				<tr>
					<th>Upfront Payment:</th>
					<td>$<?php echo number_format( $portfolio->u_upfront, 2 ); ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<th>Option Expires:</th>
					<td><?php echo esc_html( date( 'M j, Y', strtotime( $portfolio->option_expires_on ) ) ); ?></td>
				</tr>
				<tr>
					<th>Regular Licensing:</th>
					<td><?php echo esc_html( date( 'M j, Y', strtotime( $portfolio->regular_licensing_begins ) ) ); ?></td>
				</tr>
			</table>
		</section>
		
		<section class="portfolio-patents-list">
			<h2>Patents in Portfolio</h2>
			<div class="patents-container">
				<?php if ( empty( $patents ) ) : ?>
					<p>No patents linked to this portfolio yet.</p>
				<?php else : ?>
					<div class="patents-list">
						<?php foreach ( $patents as $patent ) : ?>
							<div class="patent-item" data-patent-id="<?php echo esc_attr( $patent->patent_id ); ?>">
								<h3><?php echo esc_html( $patent->patent_identifier ); ?></h3>
								<p class="patent-title"><?php echo esc_html( $patent->patent_name ); ?></p>
								<div class="patent-meta">
									<span>Filed: <?php echo esc_html( date( 'Y', strtotime( $patent->filing_timestamp ) ) ); ?></span>
									<span>Granted: <?php echo esc_html( date( 'Y', strtotime( $patent->grant_timestamp ) ) ); ?></span>
									<span>Status: <?php echo esc_html( ucfirst( $patent->enforcement_status ) ); ?></span>
								</div>
								<a href="?patent=<?php echo esc_attr( $patent->patent_id ); ?>" class="btn-view-patent">View Patent Details</a>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	</div>
	
	<div class="portfolio-actions-bar">
		<button class="btn-primary btn-wishlist" data-portfolio-id="<?php echo esc_attr( $portfolio->portfolio_id ); ?>">
			Add to Wishlist
		</button>
		<a href="?action=request_license&portfolio=<?php echo esc_attr( $portfolio->portfolio_id ); ?>" class="btn-secondary">
			Request License Information
		</a>
	</div>
</div>
