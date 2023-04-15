/* PharmaCare Yith Wishlist widget counter update
as covered here https://support.yithemes.com/hc/en-us/articles/115001372967-Wishlist-How-to-count-number-of-products-wishlist-in-ajax */
jQuery( document ).ready( function( $ ){
	$(document).on( 'added_to_wishlist removed_from_wishlist', function(){
		var counter = $('.qodef-wishlist-count');

		$.ajax({
			url: yith_wcwl_l10n.ajax_url,
			data: {
			action: 'yith_wcwl_update_wishlist_count'
			},
			dataType: 'json',
			success: function( data ){
			counter.html( data.count );
			},
			beforeSend: function(){
			counter.block();
			},
			complete: function(){
			counter.unblock();
			}
		})
	} )
});
