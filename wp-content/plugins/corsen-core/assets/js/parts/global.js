(function ( $ ) {
	'use strict';

	// This case is important when theme is not active
	if ( typeof qodef !== 'object' ) {
		window.qodef = {};
	}

	window.qodefCore                = {};
	qodefCore.shortcodes            = {};
	qodefCore.listShortcodesScripts = {
		qodefSwiper: qodef.qodefSwiper,
		qodefPagination: qodef.qodefPagination,
		qodefFilter: qodef.qodefFilter,
		qodefMasonryLayout: qodef.qodefMasonryLayout,
		qodefJustifiedGallery: qodef.qodefJustifiedGallery,
		qodefDragCursor: qodefCore.qodefDragCursor,
	};

	qodefCore.body         = $( 'body' );
	qodefCore.html         = $( 'html' );
	qodefCore.windowWidth  = $( window ).width();
	qodefCore.windowHeight = $( window ).height();
	qodefCore.scroll       = 0;

	$( document ).ready(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
			qodefInlinePageStyle.init();
			qodefUncoverSection.init();
		}
	);

	$( window ).resize(
		function () {
			qodefCore.windowWidth  = $( window ).width();
			qodefCore.windowHeight = $( window ).height();
		}
	);

	$( window ).scroll(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
		}
	);

	$( window ).load(
		function () {
			qodefParallaxItem.init();
			qodefAppear.init();
			qodefBlurHover.init();
		}
	);

	qodef.body.on (
		'corsen_trigger_swiper_is_initialized',
		function () {
			qodefBlurHover.init();
		}
	);

	$( document ).on(
		'corsen_trigger_get_new_posts',
		function () {
			qodefBlurHover.init();
		}
	);

	/**
	 * Check element to be in the viewport
	 */
	var qodefIsInViewport = {
		check: function ( $element, callback, onlyOnce ) {
			if ( $element.length ) {
				var offset = typeof $element.data( 'viewport-offset' ) !== 'undefined' ? $element.data( 'viewport-offset' ) : 0.15; // When item is 15% in the viewport

				var observer = new IntersectionObserver(
					function ( entries ) {
						// isIntersecting is true when element and viewport are overlapping
						// isIntersecting is false when element and viewport don't overlap
						if ( entries[0].isIntersecting === true ) {
							callback.call( $element );

							// Stop watching the element when it's initialize
							if ( onlyOnce !== false ) {
								observer.disconnect();
							}
						}
					},
					{ threshold: [offset] }
				);

				observer.observe( $element[0] );
			}
		},
	};

	qodefCore.qodefIsInViewport = qodefIsInViewport;

	var qodefScroll = {
		disable: function () {
			if ( window.addEventListener ) {
				window.addEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}

			// window.onmousewheel = document.onmousewheel = qodefScroll.preventDefaultValue;
			document.onkeydown = qodefScroll.keyDown;
		},
		enable: function () {
			if ( window.removeEventListener ) {
				window.removeEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		},
		preventDefaultValue: function ( e ) {
			e = e || window.event;
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.returnValue = false;
		},
		keyDown: function ( e ) {
			var keys = [37, 38, 39, 40];
			for ( var i = keys.length; i--; ) {
				if ( e.keyCode === keys[i] ) {
					qodefScroll.preventDefaultValue( e );
					return;
				}
			}
		}
	};

	qodefCore.qodefScroll = qodefScroll;

	var qodefPerfectScrollbar = {
		init: function ( $holder ) {
			if ( $holder.length ) {
				qodefPerfectScrollbar.qodefInitScroll( $holder );
			}
		},
		qodefInitScroll: function ( $holder ) {
			var $defaultParams = {
				wheelSpeed: 0.6,
				suppressScrollX: true
			};

			var $ps = new PerfectScrollbar(
				$holder[0],
				$defaultParams
			);

			$( window ).resize(
				function () {
					$ps.update();
				}
			);
		}
	};

	qodefCore.qodefPerfectScrollbar = qodefPerfectScrollbar;

	/*
	 *  Add uncovering section
	 */
	var qodefUncoverSection = {
		init: function () {
			this.holder = $('#qodef-custom-section--uncover');

			if (this.holder.length && !qodefCore.html.hasClass('touchevents') && qodef.windowWidth > 1024) {
				qodefUncoverSection.addClass(this.holder);
				qodefUncoverSection.setHeight(this.holder);

				$(window).resize(function () {
					qodefUncoverSection.setHeight(qodefUncoverSection.holder);
				});
			}
		},
		setHeight: function ($holder) {
			$holder.css('height', 'auto');

			var sectionHeight = $holder.outerHeight();

			if (sectionHeight > 0) {
				$('#qodef-page-content').css({ 'margin-bottom': sectionHeight });
				$holder.css('height', sectionHeight);
			}

			document.addEventListener('scroll', function () {
				var scrolledNearBottomOfPage = document.documentElement.scrollHeight - qodefCore.scroll - qodefCore.windowHeight < 100;

				if ( scrolledNearBottomOfPage ) {
					$holder.css('z-index', '2');
				} else {
					$holder.css('z-index', '0');
				}

			}, {
				passive: true
			});
		},
		addClass: function () {
			qodefCore.body.addClass('qodef-page-has-custom-section--uncover');
		},
	};

	qodefCore.qodefUncoverSection = qodefUncoverSection;

	var qodefInlinePageStyle = {
		init: function () {
			this.holder = $( '#corsen-core-page-inline-style' );

			if ( this.holder.length ) {
				var style = this.holder.data( 'style' );

				if ( style.length ) {
					$( 'head' ).append( '<style type="text/css">' + style + '</style>' );
				}
			}
		}
	};

	/**
	 * Init parallax item
	 */
	var qodefParallaxItem = {
		init: function () {
			var $items = $( '.qodef-parallax-item' );

			if ( $items.length ) {
				$items.each(
					function () {
						var $currentItem = $( this ),
							$y           = Math.floor( Math.random() * (-100 - (-25)) + (-25) );

						if ( $currentItem.hasClass( 'qodef-grid-item' ) ) {
							$currentItem.children( '.qodef-e-inner' ).attr(
								'data-parallax',
								'{"y": ' + $y + ', "smoothness": ' + '30' + '}'
							);
						} else {
							$currentItem.attr(
								'data-parallax',
								'{"y": ' + $y + ', "smoothness": ' + '30' + '}'
							);
						}
					}
				);
			}

			qodefParallaxItem.initParallax();
		},
		initParallax: function () {
			var parallaxInstances = $( '[data-parallax]' );

			if ( parallaxInstances.length && ! qodefCore.html.hasClass( 'touchevents' ) && typeof ParallaxScroll === 'object' ) {
				ParallaxScroll.init(); //initialization removed from plugin js file to have it run only on non-touch devices
			}
		},
	};

	qodefCore.qodefParallaxItem = qodefParallaxItem;

	/**
	 * Init animation on appear
	 */
	var qodefAppear = {
		init: function () {
			this.holder = $('.qodef--has-appear:not(.qodef--appeared), .qodef--custom-section-appear:not(.qodef--appeared)');

			if (this.holder.length) {
				this.holder.each(
					function (index) {
						var holder = $(this),
							randomNum = gsap.utils.random(10, 300, 70),
							appearDelay = $(this).attr('data-appear-delay'),
							appearDelay = appearDelay ? appearDelay : randomNum;

						qodefCore.qodefIsInViewport.check(
							holder,
							function () {
								if (appearDelay != 0) {
									setTimeout(
										function () {
											holder.addClass('qodef--appeared');
										},
										appearDelay
									)
								} else {
									holder.addClass('qodef--appeared');
								}
							},
						);
					}
				);
			}
		},
	};

	qodefCore.qodefAppear = qodefAppear;

	var qodefBlurHover = {
		init: function () {
			var holder = $( '.qodef-image-gallery .qodef-e' );

			if ( holder.length ) {

				if ( ! qodefCore.html.hasClass( 'touchevents' )  && holder.length ) {
					holder.each(
						function () {
							qodefBlurHover.initItem($(this));
						}
					);
				}
			}
		},
		initItem: function ( $currentItem ) {
			var $image = $currentItem.find('img'),
				svg = $currentItem.find('svg'),
				filter = svg.find('filter'),
				filterId = filter.attr("id"),
				blur = filter.find('feGaussianBlur')[0],
				blurAmount = {val: 0},
				blurVal = 6,
				randomNumber = gsap.utils.random(0, 10000, 1);

			//make sure id is unique because swiper and ajax duplicates html with id-s
			filter.attr("id", `${filterId}-${randomNumber}`);
			filterId = filter.attr("id");

			var tl = gsap.timeline(
				{
					paused: true,
					onStart: () => {
						gsap.set($image, {
							filter: 'url(#' + filterId + ')',
						});
					},
					onUpdate: () => {
						blur.setAttribute('stdDeviation', blurAmount.val);
					}
				}
			);


			tl
				.to(blurAmount,
					{
						val: blurVal,
						duration: .62,
					}
				)

			$currentItem.on(
				'mouseenter',
				function () {
					tl && tl.play(0);
				}
			);

			$currentItem.on(
				'mouseleave',
				function () {
					if (tl) {
						tl.reverse().then(
							() => {
								gsap.set($image, {
									filter: 'none',
								});
							}
						);
					}
				}
			)
		}
	};

	qodefCore.qodefBlurHover = qodefBlurHover;

})( jQuery );
