(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			//qodefSearchRevealingHeader.init();
		}
	);

	var qodefSearchRevealingHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-revealing-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchRevealingHeader.openRevealingHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchRevealingHeader.closeRevealingHeader( $searchForm );
					}
				);
			}
		},
		openRevealingHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-revealing-search--opened qodef-revealing-search--fadein' );
			qodefCore.body.removeClass( 'qodef-revealing-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeRevealingHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-revealing-search--opened qodef-revealing-search--fadein' );
			qodefCore.body.addClass( 'qodef-revealing-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-revealing-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );
