(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInfoFollow.init();
		}
	);

	$( document ).on(
		'corsen_trigger_get_new_posts',
		function () {
			qodefInfoFollow.init();
		}
	);

	var qodefInfoFollow = {
		init: function () {
			var $gallery = $( '.qodef-hover-animation--follow' );

			if ( $gallery.length ) {
				qodefCore.body.append( '<div class="qodef-e-content-follow"><div class="qodef-e-top-holder"></div><div class="qodef-e-text"></div></div>' );

				var $contentFollow = $( '.qodef-e-content-follow' ),
					$topHolder     = $contentFollow.find( '.qodef-e-top-holder' ),
					$textHolder    = $contentFollow.find( '.qodef-e-text' );

				$gallery.each(
					function () {
						$gallery.find( '.qodef-e-inner' ).each(
							function () {
								var $thisItem = $( this );

								//info element position
								$thisItem.on(
									'mousemove',
									function ( e ) {
										if ( e.clientX + 20 + $contentFollow.width() > qodefCore.windowWidth ) {
											$contentFollow.addClass( 'qodef-right' );
										} else {
											$contentFollow.removeClass( 'qodef-right' );
										}

										$contentFollow.css(
											{
												top: e.clientY + 20,
												left: e.clientX + 20,
											}
										);
									}
								);

								//show/hide info element
								$thisItem.on(
									'mouseenter',
									function () {
										var $thisItemTopHolder  = $( this ).find( '.qodef-e-top-holder' ),
											$thisItemTextHolder = $( this ).find( '.qodef-e-text' );

										if ( $thisItemTopHolder.length ) {
											$topHolder.html( $thisItemTopHolder.html() );
										}

										if ( $thisItemTextHolder.length ) {
											$textHolder.html( $thisItemTextHolder.html() );
										}

										if ( ! $contentFollow.hasClass( 'qodef-is-active' ) ) {
											$contentFollow.addClass( 'qodef-is-active' );
										}
									}
								).on(
									'mouseleave',
									function () {
										if ( $contentFollow.hasClass( 'qodef-is-active' ) ) {
											$contentFollow.removeClass( 'qodef-is-active' );
										}
									}
								);
							}
						);
					}
				);
			}
		},
	};

	qodefCore.shortcodes.corsen_core_portfolio_list.qodefInfoFollow = qodefInfoFollow;

})( jQuery );
