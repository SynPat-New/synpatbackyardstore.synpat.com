# SynPat Backyard Patent Portfolio Store - WordPress Plugin

## Overview
WordPress plugin that migrates SynPat's patent portfolio licensing business from CodeIgniter to WordPress. Implements a unique "backyard store" architecture where customers browse portfolios in the outer store and view patent details in the inner room.

## Unique Implementation Features

This plugin was built with a **completely custom architecture** specific to the patent licensing business, avoiding standard WordPress plugin patterns:

### Business-Specific Design
- Custom database tables for portfolio licensing workflows
- Direct SQL queries for performance (not WordPress post meta)
- Dual storage: WordPress posts for CMS + custom tables for business logic
- Patent-specific field handling: `n_patents`, `essnt`, `n_lic`, `u_upfront`

### Core Files Structure

```
wordpress-plugin/
├── synpat-patent-store.php          # Main plugin file
├── includes/
│   ├── class-database.php            # Licensing business data layer
│   ├── class-portfolio-post-type.php # Portfolio catalog management
│   ├── class-patent-post-type.php    # Patent details (inner room)
│   ├── class-shortcodes.php          # Frontend display handlers
│   └── class-ajax-handlers.php       # Wishlist AJAX operations
├── admin/
│   ├── class-admin.php               # Backend control panel
│   ├── css/admin-styles.css
│   └── js/admin-scripts.js
├── public/
│   ├── class-public.php              # Frontend experience
│   ├── css/store-frontend.css
│   └── js/store-frontend.js
└── INSTALLATION.md                   # Complete setup guide
```

## Key Business Features

### 1. Portfolio Management
- **n_patents**: Track number of patents in portfolio
- **essnt**: Flag essential patents
- **n_lic**: Count licensees (potential vs actual)
- **u_upfront**: Upfront payment amounts
- Technology sector categorization
- Option expiration and licensing timeline tracking

### 2. Patent Details (Inner Room)
- Patent number and application tracking
- Filing, grant, and expiration dates
- Current owner and original inventor
- Legal status monitoring
- Citation counts (forward and backward)
- Claims tracking

### 3. Customer Wishlist System
- Add/remove portfolios from wishlist
- Customer notes on saved portfolios
- AJAX-powered interactions
- Login-required functionality

### 4. Technology Preferences
- Track customer technology interests
- Weighted preference system
- Portfolio recommendation potential

### 5. Licensee Tracking
- Potential licensees database
- Actual licensee records
- Agreement date tracking
- Contract details storage

## Database Schema

### Custom Tables (NOT WordPress defaults)
- `wp_licensing_portfolios` - Portfolio business data
- `wp_patent_inventory` - Individual patent records
- `wp_portfolio_contains_patents` - Many-to-many relationships
- `wp_buyer_wishlist` - Customer saved portfolios
- `wp_buyer_tech_preferences` - Technology interests
- `wp_actual_and_potential_licensees` - Licensee tracking

## Frontend Usage

### Display Portfolio Catalog
```
[portfolio_catalog]
```

### Filter Portfolios
```
[portfolio_catalog tech_sector="AI" min_patents="5" essential_only="true"]
```

### Customer Wishlist Page
```
[customer_wishlist]
```

### Patent Details (Inner Room)
Automatic linking from portfolios with `?patent=ID` parameter

## Admin Features

Access via **Patent Store** menu in WordPress admin:

- **Dashboard** - Business metrics overview
- **Licensees** - Manage potential and actual licensees  
- **Customer Wishlists** - Monitor customer interests

## Technical Highlights

### Unique Architecture Choices
1. **No Standard Post Meta**: Custom tables for better query performance
2. **Dual Storage**: WordPress posts for content + custom tables for relationships
3. **Business-First Design**: Built around patent licensing workflows, not generic e-commerce
4. **Direct SQL**: Optimized queries instead of WP_Query overhead
5. **Patent-Specific Logic**: Essential status, licensee types, upfront payments

### CodeIgniter Migration
Maps business logic from:
- `customer_model.php` - Wishlist, preferences, company data
- `lead_model.php` - Portfolio details, patent relationships

## Installation

See [INSTALLATION.md](INSTALLATION.md) for complete setup instructions.

Quick start:
1. Upload to `/wp-content/plugins/synpat-backyard-store/`
2. Activate plugin
3. Database tables created automatically
4. Add portfolios and patents via WordPress admin
5. Use shortcodes on frontend pages

## Requirements
- WordPress 5.0+
- PHP 7.4+
- MySQL 5.7+

## License
Proprietary - SynPat Internal Use

## Credits
Developed for SynPat's patent portfolio licensing business.
