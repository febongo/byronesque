(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_horizontal_showcase = {};

	$( document ).ready(
		function () {
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefCustomHorizontalSlider.init();
		}
	);

	var qodefCustomHorizontalSlider = {
		currentHolder: '',
		currentScrollBackHolder: '',
		scrollBackAppearAfter: 10,
		init: function () {
			var holder = $( '.qodef-custom-horizontal-slider' );

			if ( qodef.windowWidth > 680 ) {
				if ( holder.length ) {

					qodef.body.addClass( 'qodef-with-custom-horizontal-slider' );

					holder.each(
						function() {
							qodefCustomHorizontalSlider.currentHolder 			= $( this );
							qodefCustomHorizontalSlider.currentScrollBackHolder = $( this ).find( '.qodef-scroll-back' );

							qodefCustomHorizontalSlider.animateSlider( $( this ) );
						}
					);
				}
			} else {

				if ( holder.length ) {

					holder.each(
						function() {
							var $thisHolder  = $( this ),
								$itemsHolder = $thisHolder.find( '.qodef-slides-holder' ),
								$images      = $itemsHolder.find( '.qodef-slide-image--1, .qodef-slide-image--2' );

							$thisHolder.addClass( 'qodef--init' );
							qodef.body.addClass( 'qodef-horizontal-slider-mobile' );

							$images.each(
								function (i) {
									var thisItem = $( this );

									if (i === 0) {
										setTimeout(
											function () {
												thisItem.addClass( 'qodef--appear' );
											},
											400
										)
									} else {
										qodefCore.qodefIsInViewport.check(
											thisItem,
											function () {
												thisItem.addClass( 'qodef--appear' );
											},
										);
									}
								}
							);
						}
					);
				}
			}
		},
		updateProgress: function() {
			var scroll = $( window ).scrollLeft();
		},
		animateSlider: function ( $thisHolder ) {
			var $itemsHolder         = $thisHolder.find( '.qodef-slides-holder' ),
				$items               = $itemsHolder.find( '.qodef-horizontal-slide' ),
				scrollItemOffset     = 0,
				scrollInitItemOffset = 74,
				windowOffset         = qodef.windowWidth / 2 - scrollItemOffset,
				timelines            = [],
				timelinesProgress    = [],
				itemWidths           = [],
				leftBounds           = [],
				rightBounds          = [];

			if (qodef.windowWidth < 1025) {

				var mobileHeader 	   = $( '#qodef-page-mobile-header' ),
					mobileHeaderHeight = mobileHeader.length ? mobileHeader.height() : 0;

				$thisHolder.height( qodef.windowHeight - mobileHeaderHeight );
			}

			var Scrollbar = window.Scrollbar;

			Scrollbar.use( HorizontalScrollPlugin );
			Scrollbar.use( window.OverscrollPlugin );

			var myScrollbar = Scrollbar.init(
				document.querySelector( '.qodef-custom-horizontal-slider .qodef-slides-holder' ),
				{
					damping: 0.05,
					plugins: {
						overscroll: {
							damping: 0.1,
							maxOverscroll: 0
						}
					}
				}
			);

			myScrollbar.track.yAxis.element.remove();

			/*add class for first item*/
			setTimeout(
				function () {
					$items.first().addClass( 'qodef--appear' );
				},
				200
			);

			$items.each(
				function (i) {
					var thisItem = $( this );

					timelinesProgress[i] = 0;
					itemWidths[i]        = $( this ).width();

					if ( i !== 0) {
						leftBounds[i]  = 2 * windowOffset;
						rightBounds[i] = -itemWidths[i];
						timelines[i]   = qodefCustomHorizontalSlider.animationOnScroll( thisItem );
					} else {
						leftBounds[i]  = scrollInitItemOffset;
						rightBounds[i] = -itemWidths[i] / 2;
						timelines[i]   = qodefCustomHorizontalSlider.animationOnScroll( thisItem , 1.25 );
					}
				}
			);

			myScrollbar.addListener(
				function (status) {
					if ( status.offset.x >= qodefCustomHorizontalSlider.scrollBackAppearAfter && ! qodefCustomHorizontalSlider.currentScrollBackHolder.hasClass( 'qodef-appear' ) ) {
						qodefCustomHorizontalSlider.currentScrollBackHolder.addClass( 'qodef-appear' );
					}

					if ( status.offset.x < qodefCustomHorizontalSlider.scrollBackAppearAfter && qodefCustomHorizontalSlider.currentScrollBackHolder.hasClass( 'qodef-appear' ) ) {
						qodefCustomHorizontalSlider.currentScrollBackHolder.removeClass( 'qodef-appear' );
					}

					$items.each(
						function (i) {
							var $offsetLeft = $( this ).offset().left;

							if (
								$offsetLeft < leftBounds[i] &&
								$offsetLeft > rightBounds[i]
							) {
								var progress = (gsap.utils.normalize( leftBounds[i], rightBounds[i], $offsetLeft )).toFixed( 2 );

								timelinesProgress[i] = qodefCustomHorizontalSlider.lerp( timelinesProgress[i], progress, 0.1 )

								timelines[i].progress( timelinesProgress[i] );
							}
						}
					);
				}
			);

			if ( qodefCustomHorizontalSlider.currentScrollBackHolder.length ) {
				qodefCustomHorizontalSlider.currentScrollBackHolder.bind(
					'click',
					function(e) {
						e.preventDefault();
						myScrollbar.scrollTo( 0, 0, 1500 );
					}
				);
			}

			$thisHolder.addClass( 'qodef--init' );
		},
		animationOnScroll: function ( $element , scale = 1.5 ) {
			var firstImage  = $element.find( '.qodef-slide-image--1 img' ),
				secondImage = $element.find( '.qodef-slide-image--2 img' );

			var tl = gsap.timeline(
				{
					paused: true,
					onStart: () => {
						$element.addClass( 'qodef--appear' )
					}
				}
			)

			tl
				.to(
					firstImage,
					{
						scale : scale,
						duration: 1,
					}
				)
				.to(
					secondImage,
					{
						scale : scale,
						duration: 1,
					},
					'<+=.7'
				)

			return tl;
		},
		lerp: function ( start, end, amt) {
			return (1 - amt) * start + amt * end;
		}
	};

	qodefCore.shortcodes.corsen_core_horizontal_showcase.qodefCustomHorizontalSlider = qodefCustomHorizontalSlider;

})( jQuery );
