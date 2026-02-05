=== SynPat Patent Store ===
Contributors: synpat
Tags: patents, portfolio, store, intellectual property
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A comprehensive WordPress plugin for managing and displaying patent portfolios and patents.

== Description ==

SynPat Patent Store is a powerful WordPress plugin that enables you to manage and showcase patent portfolios on your WordPress website. This plugin converts the existing CodeIgniter-based patent portfolio store into a fully WordPress-compatible solution.

**Key Features:**

* Custom post types for Portfolios and Patents
* Portfolio catalog display with filtering capabilities
* Individual portfolio detail pages with associated patents
* Patent detail pages with comprehensive information
* Custom database tables for storing detailed patent data
* AJAX-powered filtering and search functionality
* Shortcodes for easy page integration
* Responsive design for mobile and desktop
* Admin settings panel for configuration

**Custom Post Types:**

* **Portfolio** - For managing patent portfolios
* **Patent** - For managing individual patents

**Shortcodes:**

* `[synpat_portfolio_catalog]` - Display portfolio catalog
* `[synpat_portfolio_detail id="X"]` - Display single portfolio details
* `[synpat_patent_list portfolio_id="X"]` - Display patents in a portfolio
* `[synpat_patent_detail id="X"]` - Display single patent details

== Installation ==

1. Upload the `synpat-patent-store` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to 'SynPat Store' in the admin menu to configure settings
4. Create pages and add shortcodes to display your patent portfolios

For detailed installation instructions, see INSTALLATION.md in the plugin directory.

== Frequently Asked Questions ==

= How do I display the portfolio catalog? =

Create a new page and add the shortcode `[synpat_portfolio_catalog]` to the content area.

= Can I import existing patent data? =

Yes, the plugin includes a data migration utility accessible from the admin settings page.

= What database tables does this plugin create? =

The plugin creates the following tables:
* {prefix}_synpat_portfolios
* {prefix}_synpat_patents
* {prefix}_synpat_portfolio_patents
* {prefix}_synpat_licensees
* {prefix}_synpat_categories

== Screenshots ==

1. Portfolio catalog view
2. Portfolio detail page
3. Patent detail page
4. Admin settings page

== Changelog ==

= 1.0.0 =
* Initial release
* Custom post types for portfolios and patents
* Portfolio catalog shortcode
* Portfolio and patent detail views
* Admin settings page
* Database table creation
* AJAX filtering functionality

== Upgrade Notice ==

= 1.0.0 =
Initial release of SynPat Patent Store plugin.
