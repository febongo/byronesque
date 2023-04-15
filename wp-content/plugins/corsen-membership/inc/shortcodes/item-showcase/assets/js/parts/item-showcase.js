(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_item_showcase = {};

	$( document ).ready(
		function () {
			qodefItemShowcaseList.init();
		}
	);

	var qodefItemShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-item-showcase' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefItemShowcaseList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefCore.qodefIsInViewport.check(
				$currentItem,
				function () {
					$currentItem.addClass( 'qodef--init' );
				}
			);
		},
	};

	qodefCore.shortcodes.corsen_core_item_showcase.qodefItemShowcaseList = qodefItemShowcaseList;

})( jQuery );
