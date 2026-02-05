(function($) {
'use strict';
$(document).ready(function() {
$('.btn-add-wishlist').on('click', function(e) {
e.preventDefault();
if (!backyardStoreConfig.isLoggedIn) {
alert('Please log in to add items to your wishlist.');
return;
}
var button = $(this);
var portfolioId = button.data('portfolio-id');
button.prop('disabled', true).text('Adding...');
$.ajax({
url: backyardStoreConfig.ajaxUrl,
type: 'POST',
data: { action: 'add_to_wishlist', nonce: backyardStoreConfig.nonce, portfolio_id: portfolioId },
success: function(response) {
if (response.success) {
button.text('✓ Added!').css('background', '#27ae60');
setTimeout(function() { button.prop('disabled', false).text('Add to Wishlist').css('background', ''); }, 2000);
} else {
alert(response.data.message || 'Failed to add to wishlist.');
button.prop('disabled', false).text('Add to Wishlist');
}
}
});
});
$('.btn-remove-wishlist').on('click', function(e) {
e.preventDefault();
if (!confirm('Remove this portfolio from your wishlist?')) return;
var button = $(this);
var portfolioId = button.data('portfolio-id');
var wishlistItem = button.closest('.wishlist-item');
button.prop('disabled', true).text('Removing...');
$.ajax({
url: backyardStoreConfig.ajaxUrl,
type: 'POST',
data: { action: 'remove_from_wishlist', nonce: backyardStoreConfig.nonce, portfolio_id: portfolioId },
success: function(response) {
if (response.success) {
wishlistItem.fadeOut(300, function() { $(this).remove(); });
}
}
});
});
});
})(jQuery);
