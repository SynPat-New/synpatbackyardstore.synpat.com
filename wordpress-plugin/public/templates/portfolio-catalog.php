<?php
/**
 * Portfolio Catalog Template
 * The "outer store" - displays available patent portfolios
 */

if ( ! defined( 'ABSPATH' ) ) die;

// This template is loaded by the shortcode handler
// Variables available: $portfolios array
?>
<div class="synpat-outer-store">
	<div class="catalog-header">
		<h1>Patent Portfolio Marketplace</h1>
		<p class="catalog-subtitle">Browse available patent portfolios for licensing</p>
	</div>
	
	<div class="catalog-filters">
		<label>
			Technology Sector:
			<select id="tech-sector-filter" class="filter-control">
				<option value="">All Sectors</option>
			</select>
		</label>
		<label>
			<input type="checkbox" id="essential-only-filter"> Essential Patents Only
		</label>
		<label>
			Min Patents: <input type="number" id="min-patents-filter" min="0" value="0" class="filter-control">
		</label>
	</div>
	
	<div class="portfolio-catalog-grid" id="portfolio-grid">
		<!-- Portfolios rendered by shortcode -->
	</div>
</div>
