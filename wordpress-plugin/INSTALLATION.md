# SynPat Backyard Patent Portfolio Store - Installation Guide

## Overview
This WordPress plugin migrates the patent portfolio licensing business from CodeIgniter to WordPress. It implements the "backyard store" concept with portfolio catalog browsing (outer store) and patent details viewing (inner room).

## Business Features Implemented

### Key Fields from CodeIgniter Application
- **n_patents**: Number of patents in portfolio
- **essnt**: Essential patent status flag
- **n_lic**: Number of licensees (potential and actual)
- **u_upfront**: Upfront payment amount

### Core Functionality
1. **Portfolio Catalog** - Browse available patent portfolios
2. **Patent Details** - View individual patents in a portfolio (inner room)
3. **Wishlist System** - Customers can save portfolios to wishlist
4. **Technology Preferences** - Track customer technology interests
5. **Licensee Tracking** - Manage potential vs actual licensees

## Installation Steps

### 1. Upload Plugin Files
Upload the `wordpress-plugin` directory contents to:
```
/wp-content/plugins/synpat-backyard-store/
```

### 2. Activate Plugin
1. Log in to WordPress admin dashboard
2. Navigate to **Plugins** > **Installed Plugins**
3. Find "SynPat Backyard Patent Portfolio Store"
4. Click **Activate**

### 3. Database Tables Created Automatically
On activation, these tables are created:
- `wp_licensing_portfolios` - Portfolio data
- `wp_patent_inventory` - Individual patents
- `wp_portfolio_contains_patents` - Portfolio-patent relationships
- `wp_buyer_wishlist` - Customer wishlists
- `wp_buyer_tech_preferences` - Technology preferences
- `wp_actual_and_potential_licensees` - Licensee tracking

### 4. Create Portfolios
1. Go to **Patent Portfolios** > **Add New**
2. Enter portfolio title and description
3. Fill in business metrics:
   - Serial Code
   - Number of Patents (n_patents)
   - Essential Status (essnt)
   - Number of Licensees (n_lic)
   - Upfront Payment (u_upfront)
   - Cost Price
   - Option Expiration
   - Regular License Start
4. Assign technology domain
5. Publish

### 5. Add Patents
1. Go to **Individual Patents** > **Add New**
2. Enter patent details:
   - Patent Number
   - Application Number
   - Filing/Issue/Expiration dates
   - Current Owner
   - Original Inventor
   - Legal Status
   - Claims count
   - Citations
3. Link to portfolios (sidebar)
4. Publish

### 6. Display on Frontend

#### Portfolio Catalog
Add this shortcode to any page:
```
[portfolio_catalog]
```

With filters:
```
[portfolio_catalog tech_sector="AI" min_patents="5" essential_only="true"]
```

#### Portfolio Details
Portfolios link to detail view automatically with parameter:
```
?portfolio=123
```

#### Customer Wishlist
Add wishlist page:
```
[customer_wishlist]
```

#### Patent Inner Room
Individual patent details:
```
[patent_inner_room]
```

## Admin Dashboard

Access at: **Patent Store** > **Dashboard**

### Features:
- **Dashboard** - Statistics overview
- **Licensees** - View potential and actual licensees
- **Customer Wishlists** - Monitor customer interests

## AJAX Endpoints

### Add to Wishlist
```javascript
{
  action: 'add_to_wishlist',
  nonce: backyardStoreConfig.nonce,
  portfolio_id: 123,
  notes: 'Optional notes'
}
```

### Remove from Wishlist
```javascript
{
  action: 'remove_from_wishlist',
  nonce: backyardStoreConfig.nonce,
  portfolio_id: 123
}
```

### Save Tech Preference
```javascript
{
  action: 'save_tech_preference',
  nonce: backyardStoreConfig.nonce,
  tech_sector: 'AI',
  weight: 5
}
```

## Data Migration from CodeIgniter

### Portfolio Data
Map CodeIgniter fields to WordPress:
- `lead_name` → `portfolio_title`
- `serial_number` → `serial_identifier`
- `n_patents` → `n_patents`
- `essnt` → `essnt`
- `n_lic` → `n_lic`
- `u_upfront` → `u_upfront`
- `cost_price` → `base_price`

### Wishlist Migration
From `customer_model.php line 14: public $table_wishlist = 'wishlist'`

SQL to migrate:
```sql
INSERT INTO wp_buyer_wishlist (customer_fk, portfolio_fk, wishlisted_at)
SELECT customer_id, portfolio_id, create_date
FROM wishlist;
```

### Technology Preferences
From `customer_model.php line 8: public $table_technology_preference`

```sql
INSERT INTO wp_buyer_tech_preferences (customer_fk, technology_sector, interest_weight)
SELECT company_id, preference_id, type
FROM technology_preference;
```

## Customization

### Custom Portfolio Fields
Edit `includes/class-portfolio-post-type.php`:
- `render_business_fields_ui()` - Add UI fields
- `persist_business_metrics()` - Save custom fields

### Custom Shortcode Attributes
Edit `includes/class-shortcodes.php`:
- Modify `render_portfolio_catalog()` for new filters
- Customize HTML output in each render method

### Styling
- Frontend: `public/css/store-frontend.css`
- Admin: `admin/css/admin-styles.css`

## Troubleshooting

### Tables Not Created
Manually run:
```php
Licensing_Portfolio_Storage::initialize_database_tables();
```

### Permissions Issues
Ensure WordPress user has these capabilities:
- `edit_posts`
- `manage_options` (for admin)

### AJAX Not Working
1. Check nonce is valid
2. Verify user is logged in for wishlist operations
3. Check browser console for JavaScript errors

## Technical Architecture

### Custom Post Types
- `patent_portfolio` - Portfolio catalog items
- `individual_patent` - Individual patents

### Taxonomies
- `technology_domain` - Technology categories

### Database Layer
Class `Licensing_Portfolio_Storage` handles all database operations without using WordPress post meta patterns, implementing direct SQL for better performance with large datasets.

### Dual Storage
- WordPress posts for content management
- Custom tables for business logic and relationships
- Automatic syncing on save

## Requirements
- WordPress 5.0+
- PHP 7.4+
- MySQL 5.7+

## Support
Contact SynPat development team for assistance.
