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

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefBackToTop.init();
		}
	);

	var qodefBackToTop = {
		init: function () {
			this.holder = $( '#qodef-back-to-top' );

			if ( this.holder.length ) {
				// Scroll To Top
				this.holder.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefBackToTop.animateScrollToTop();
					}
				);

				qodefBackToTop.showHideBackToTop();
			}
		},
		animateScrollToTop: function () {
			var startPos = qodef.scroll,
				newPos   = qodef.scroll,
				step     = .9,
				animationFrameId;

			var startAnimation = function () {
				if ( newPos === 0 ) {
					return;
				}

				newPos < 0.0001 ? newPos = 0 : null;

				var ease = qodefBackToTop.easingFunction( (startPos - newPos) / startPos );
				$( 'html, body' ).scrollTop( startPos - (startPos - newPos) * ease );
				newPos = newPos * step;

				animationFrameId = requestAnimationFrame( startAnimation );
			};

			startAnimation();

			$( window ).one(
				'wheel touchstart',
				function () {
					cancelAnimationFrame( animationFrameId );
				}
			);
		},
		easingFunction: function ( n ) {
			return 0 == n ? 0 : Math.pow( 1024, n - 1 );
		},
		showHideBackToTop: function () {
			$( window ).scroll(
				function () {
					var $thisItem = $( this ),
						b         = $thisItem.scrollTop(),
						c         = $thisItem.height(),
						d;

					if ( b > 0 ) {
						d = b + c / 2;
					} else {
						d = 1;
					}

					if ( d < 1e3 ) {
						qodefBackToTop.addClass( 'off' );
					} else {
						qodefBackToTop.addClass( 'on' );
					}
				}
			);
		},
		addClass: function ( a ) {
			this.holder.removeClass( 'qodef--off qodef--on' );

			if ( a === 'on' ) {
				this.holder.addClass( 'qodef--on' );
			} else {
				this.holder.addClass( 'qodef--off' );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefUncoverFooter.init();
		}
	);

	var qodefUncoverFooter = {
		holder: '',
		init: function () {
			this.holder = $( '#qodef-page-footer.qodef--uncover' );

			if ( this.holder.length && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				qodefUncoverFooter.addClass();
				qodefUncoverFooter.setHeight( this.holder );

				$( window ).resize(
					function () {
						qodefUncoverFooter.setHeight( qodefUncoverFooter.holder );
					}
				);
			}
		},
		setHeight: function ( $holder ) {
			$holder.css( 'height', 'auto' );

			var footerHeight = $holder.outerHeight();

			if ( footerHeight > 0 ) {
				$( '#qodef-page-outer' ).css(
					{
						'margin-bottom': footerHeight,
						'background-color': qodefCore.body.css( 'backgroundColor' )
					}
				);

				$holder.css( 'height', footerHeight );
			}
		},
		addClass: function () {
			qodefCore.body.addClass( 'qodef-page-footer--uncover' );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefFullscreenMenu.init();
		}
	);

	$( window ).on(
		'resize',
		function () {
			qodefFullscreenMenu.handleHeaderWidth( 'resize' );
		}
	);

	var qodefFullscreenMenu = {
		init: function () {
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' ),
				$menuItems            = $( '#qodef-fullscreen-area nav ul li a' ),

				$firstLevelMenuItemsWithChildren = $( '#qodef-fullscreen-area nav > ul > li.menu-item-has-children > a' ),
				$arrow =  '<svg class="qodef-svg--menu-arrow qodef-menu-item-arrow" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"><g><path d="M 13.8,24.196c 0.39,0.39, 1.024,0.39, 1.414,0l 6.486-6.486c 0.196-0.196, 0.294-0.454, 0.292-0.71 c0-0.258-0.096-0.514-0.292-0.71L 15.214,9.804c-0.39-0.39-1.024-0.39-1.414,0c-0.39,0.39-0.39,1.024,0,1.414L 19.582,17 L 13.8,22.782C 13.41,23.172, 13.41,23.806, 13.8,24.196z"></path></g></svg>';


			$firstLevelMenuItemsWithChildren.append($arrow);

			if ( $fullscreenMenuOpener.length ) {
				// prevent header changing width when fullscreen menu is open
				qodefFullscreenMenu.handleHeaderWidth( 'init' );

				// open popup menu
				$fullscreenMenuOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						var $thisOpener = $( this );

						if ( ! qodefCore.body.hasClass( 'qodef-fullscreen-menu--opened' ) ) {
							qodefFullscreenMenu.openFullscreen( $thisOpener );

							$( document ).keyup(
								function ( e ) {
									if ( e.keyCode === 27 ) {
										qodefFullscreenMenu.closeFullscreen( $thisOpener );
									}
								}
							);
						} else {
							qodefFullscreenMenu.closeFullscreen( $thisOpener );
						}
					}
				);

				// open dropdowns
				$menuItems.on(
					'tap click',
					function ( e ) {
						var $thisItem = $( this );

						if ( $thisItem.parent().hasClass( 'menu-item-has-children' ) ) {
							e.preventDefault();
							qodefFullscreenMenu.clickItemWithChild( $thisItem );
						} else if ( $thisItem.attr( 'href' ) !== 'http://#' && $thisItem.attr( 'href' ) !== '#' ) {
							qodefFullscreenMenu.closeFullscreen( $fullscreenMenuOpener );
						}
					}
				);
			}
		},
		openFullscreen: function ( $opener ) {
			$opener.addClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu-animate--out' ).addClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' );
			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $opener ) {
			$opener.removeClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' ).addClass( 'qodef-fullscreen-menu-animate--out' );
			qodefCore.qodefScroll.enable();
			$( 'nav.qodef-fullscreen-menu ul.sub_menu' ).slideUp( 200 );
		},
		clickItemWithChild: function ( thisItem ) {
			var $thisItemParent  = thisItem.parent(),
				$thisItemSubMenu = $thisItemParent.find( '.sub-menu' ).first();

			if ( $thisItemSubMenu.is( ':visible' ) ) {
				$thisItemSubMenu.slideUp( 300 );
				$thisItemParent.removeClass( 'qodef--opened' );
			} else {
				$thisItemSubMenu.slideDown( 300 );
				$thisItemParent.addClass( 'qodef--opened' ).siblings().find( '.sub-menu' ).slideUp( 400 );
			}
		},
		handleHeaderWidth: function ( state ) {
			var $header               = $( '#qodef-page-header' );
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' );

			if ( $header.length && $fullscreenMenuOpener.length ) {
				// if desktop device
				if ( qodefCore.windowWidth > 1024 ) {
					// if page height is greater then window height, scroll bar is visible
					if ( qodefCore.body.height() > qodefCore.windowHeight ) {
						// on resize reset previously set inline width
						if ( 'resize' === state ) {
							$header.css( { 'width': '' } );
						}
						$header.width( $header.width() );
					}
				} else {
					// reset previously set inline width
					$header.css( { 'width': '' } );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefHeaderScrollAppearance.init();
		}
	);

	var qodefHeaderScrollAppearance = {
		appearanceType: function () {
			return qodefCore.body.attr( 'class' ).indexOf( 'qodef-header-appearance--' ) !== -1 ? qodefCore.body.attr( 'class' ).match( /qodef-header-appearance--([\w]+)/ )[1] : '';
		},
		init: function () {
			var appearanceType = this.appearanceType();

			if ( appearanceType !== '' && appearanceType !== 'none' ) {
				qodefCore[appearanceType + 'HeaderAppearance']();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefMobileHeaderAppearance.init();
        }
	);

	/*
	 **	Init mobile header functionality
	 */
	var qodefMobileHeaderAppearance = {
		init: function () {
			if ( qodefCore.body.hasClass( 'qodef-mobile-header-appearance--sticky' ) ) {

				var docYScroll1   = qodefCore.scroll,
					displayAmount = qodefGlobal.vars.mobileHeaderHeight + qodefGlobal.vars.adminBarHeight,
					$pageOuter    = $( '#qodef-page-outer' );

				qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );

				$( window ).scroll(
				    function () {
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                        docYScroll1 = qodefCore.scroll;
                    }
				);

				$( window ).resize(
				    function () {
                        $pageOuter.css( 'padding-top', 0 );
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                    }
				);
			}
		},
		showHideMobileHeader: function ( docYScroll1, displayAmount, $pageOuter ) {
			if ( qodefCore.windowWidth <= 1024 ) {
				if ( qodefCore.scroll > displayAmount * 2 ) {
					//set header to be fixed
					qodefCore.body.addClass( 'qodef-mobile-header--sticky' );

					//add transition to it
					setTimeout(
						function () {
							qodefCore.body.addClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//add padding to content so there is no 'jumping'
					$pageOuter.css( 'padding-top', qodefGlobal.vars.mobileHeaderHeight );
				} else {
					//unset fixed header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky' );

					//remove transition
					setTimeout(
						function () {
							qodefCore.body.removeClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//remove padding from content since header is not fixed anymore
					$pageOuter.css( 'padding-top', 0 );
				}

				if ( (qodefCore.scroll > docYScroll1 && qodefCore.scroll > displayAmount) || (qodefCore.scroll < displayAmount * 3) ) {
					//show sticky header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky-display' );
				} else {
					//hide sticky header
					qodefCore.body.addClass( 'qodef-mobile-header--sticky-display' );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefNavMenu.init();
		}
	);

	var qodefNavMenu = {
		init: function () {
			qodefNavMenu.dropdownBehavior();
			qodefNavMenu.wideDropdownPosition();
			qodefNavMenu.dropdownPosition();
		},
		dropdownBehavior: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li' );

			$menuItems.each(
				function () {
					var $thisItem = $( this );

					if ( $thisItem.find( '.qodef-drop-down-second' ).length ) {
						qodef.qodefWaitForImages.check(
							$thisItem,
							function () {
								var $dropdownHolder      = $thisItem.find( '.qodef-drop-down-second' ),
									$dropdownMenuItem    = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
									dropDownHolderHeight = $dropdownMenuItem.outerHeight();

								if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
									$thisItem.on(
										'touchstart mouseenter',
										function () {
											$dropdownHolder.css(
												{
													'height': dropDownHolderHeight,
													'overflow': 'visible',
													'visibility': 'visible',
													'opacity': '1',
												}
											);
										}
									).on(
										'mouseleave',
										function () {
											$dropdownHolder.css(
												{
													'height': '0px',
													'overflow': 'hidden',
													'visibility': 'hidden',
													'opacity': '0',
												}
											);
										}
									);
								} else {
									if ( qodefCore.body.hasClass( 'qodef-drop-down-second--animate-height' ) ) {
										var animateConfig = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).css(
															{
																'visibility': 'visible',
																'height': '0',
																'opacity': '1',
															}
														);
														$dropdownHolder.stop().animate(
															{
																'height': dropDownHolderHeight,
															},
															400,
															'linear',
															function () {
																$dropdownHolder.css( 'overflow', 'visible' );
															}
														);
													},
													100
												);
											},
											timeout: 100,
											out: function () {
												$dropdownHolder.stop().animate(
													{
														'height': '0',
														'opacity': 0,
													},
													100,
													function () {
														$dropdownHolder.css(
															{
																'overflow': 'hidden',
																'visibility': 'hidden',
															}
														);
													}
												);

												$dropdownHolder.removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( animateConfig );
									} else {
										var config = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).stop().css( { 'height': dropDownHolderHeight } );
													},
													150
												);
											},
											timeout: 150,
											out: function () {
												$dropdownHolder.stop().css( { 'height': '0' } ).removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( config );
									}
								}
							}
						);
					}
				}
			);
		},
		wideDropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--wide' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $menuItem        = $( this );
						var $menuItemSubMenu = $menuItem.find( '.qodef-drop-down-second' );

						if ( $menuItemSubMenu.length ) {
							$menuItemSubMenu.css( 'left', 0 );

							var leftPosition = $menuItemSubMenu.offset().left;

							if ( qodefCore.body.hasClass( 'qodef--boxed' ) ) {
								//boxed layout case
								var boxedWidth = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
								leftPosition   = leftPosition - (qodefCore.windowWidth - boxedWidth) / 2;
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': boxedWidth } );

							} else if ( qodefCore.body.hasClass( 'qodef-drop-down-second--full-width' ) ) {
								//wide dropdown full width case
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': qodefCore.windowWidth } );
							} else {
								//wide dropdown in grid case
								$menuItemSubMenu.css( { 'left': -leftPosition + (qodefCore.windowWidth - $menuItemSubMenu.width()) / 2 } );
							}
						}
					}
				);
			}
		},
		dropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--narrow.menu-item-has-children' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $thisItem         = $( this ),
							menuItemPosition  = $thisItem.offset().left,
							$dropdownHolder   = $thisItem.find( '.qodef-drop-down-second' ),
							$dropdownMenuItem = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
							dropdownMenuWidth = $dropdownMenuItem.outerWidth(),
							menuItemFromLeft  = $( window ).width() - menuItemPosition;

						if ( qodef.body.hasClass( 'qodef--boxed' ) ) {
							//boxed layout case
							var boxedWidth   = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
							menuItemFromLeft = boxedWidth - menuItemPosition;
						}

						var dropDownMenuFromLeft;

						if ( $thisItem.find( 'li.menu-item-has-children' ).length > 0 ) {
							dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
						}

						$dropdownHolder.removeClass( 'qodef-drop-down--right' );
						$dropdownMenuItem.removeClass( 'qodef-drop-down--right' );
						if ( menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth ) {
							$dropdownHolder.addClass( 'qodef-drop-down--right' );
							$dropdownMenuItem.addClass( 'qodef-drop-down--right' );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefParallaxBackground.init();
		}
	);

	/**
	 * Init global parallax background functionality
	 */
	var qodefParallaxBackground = {
		init: function ( settings ) {
			this.$sections = $( '.qodef-parallax' );

			// Allow overriding the default config
			$.extend(
				this.$sections,
				settings
			);

			var isSupported = ! qodefCore.html.hasClass( 'touchevents' ) && ! qodefCore.body.hasClass( 'qodef-browser--edge' ) && ! qodefCore.body.hasClass( 'qodef-browser--ms-explorer' );

			if ( this.$sections.length && isSupported ) {
				this.$sections.each(
					function () {
						qodefParallaxBackground.ready( $( this ) );
					}
				);
			}
		},
		ready: function ( $section ) {
			$section.rowHolder   = $section.find( '.qodef-parallax-row-holder' );
			$section.$imgHolder  = $section.find( '.qodef-parallax-img-holder' );
			$section.$imgWrapper = $section.find( '.qodef-parallax-img-wrapper' );
			$section.$img        = $section.find( 'img.qodef-parallax-img' );

			qodef.qodefWaitForImages.check(
				$section,
				function () {
					$section.$imgHolder.animate(
						{ opacity: 1 },
						100
					);
					qodefParallaxBackground.calc( $section );
					qodefParallaxBackground.animateParallax( $section );
				}
			);

			//recalc
			$( window ).on(
				'resize',
				function () {
					qodefParallaxBackground.calc( $section );
				}
			);
		},
		calc: function ( $section ) {
			$section.speed           = parseFloat( $section.rowHolder.attr( 'data-speed' ) );
			$section.speed           = $section.speed && ! isNaN( $section.speed ) ? $section.speed : 1.16; //if 1 no effect will be applied, use values between -1 and 2
			$section.speedNormalized = $section.speed - 1;

			$section.$imgHolder.css( {
				'top': -Math.abs( $section.speedNormalized / 2 * 100 ) + '%',
				'height': 100 + Math.abs( $section.speedNormalized * 100 ) + '%'
			} );

			var wH = $section.$imgWrapper.height(),
				wW = $section.$imgWrapper.width(),
				heightDiff = $section.$img.height() - wH,
				widthDiff = $section.$img.width() - wW;

			if ( widthDiff < 0 && widthDiff <= heightDiff  ) {
				$section.$img.css(
					{
						'width': '100%',
						'height': 'auto',
					}
				);
			}

			if ( heightDiff < 0 && heightDiff <= widthDiff ) {
				$section.$img.css(
					{
						'height': '100%',
						'width': 'auto',
						'max-width': 'unset',
					}
				);
			}
		},
		animateParallax: function ( $section ) {
			if ( $section.speedNormalized == 0 ) return;

			var oldY               = 0,
				yVal               = 0,
				parallaxSmoothness = parseFloat( $section.rowHolder.attr( 'data-smoothness' ) ),//bigger the number, effect will appear smoother, use values between .5 and 1.5
				parallaxSmoothness = parallaxSmoothness && ! isNaN( parallaxSmoothness ) ? parallaxSmoothness : .6,
				sectionHeight      = $section.height(),
				maxY = Math.round($section.outerHeight() * $section.speedNormalized),
				isTriggered        = false,
				animationID;

			$section.rect         = $section[0].getBoundingClientRect();
			$section.windowCenter = qodefCore.windowHeight / 2;

			window.addEventListener(
				'scroll',
				handleScroll
			);

			function handleScroll() {
				$section.rect = $section[0].getBoundingClientRect();
			}


			function loop() {
				var sectionCenter           = $section.rect.top + sectionHeight / 2,//center of the section from viewport top
					scrollFromSectionCentre = -(sectionCenter - $section.windowCenter);

				oldY = yVal;
				yVal = $section.speedNormalized * scrollFromSectionCentre / 2;// because overflow image height should be split on both sides
				yVal = gsap.utils.clamp(-maxY, maxY, yVal);

				if ( oldY != yVal ) {
					gsap.to(
						$section.$imgWrapper,
						{
							ease: 'power2.out',
							y: yVal,
							duration: parallaxSmoothness,
						}
					);
				}

				animationID = requestAnimationFrame( loop );
			};

			qodefCore.qodefIsInViewport.check(
				$section,
				function () {//when in viewport request animation frame
					animationID = requestAnimationFrame( loop );
				},
				false,
				function () {//when out of viewport cancel animation frame
					if (isTriggered){
						cancelAnimationFrame( animationID );
					}
				},
			);

			//init loop
			animationID = requestAnimationFrame( loop );
			isTriggered = true;
		}
	};

	qodefCore.qodefParallaxBackground = qodefParallaxBackground;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefReview.init();
		}
	);

	var qodefReview = {
		init: function () {
			var ratingHolder = $( '#qodef-page-comments-form .qodef-rating-inner' );

			var addActive = function ( stars, ratingValue ) {
				for ( var i = 0; i < stars.length; i++ ) {
					var star = stars[i];

					if ( i < ratingValue ) {
						$( star ).addClass( 'active' );
					} else {
						$( star ).removeClass( 'active' );
					}
				}
			};

			ratingHolder.each(
				function () {
					var thisHolder  = $( this ),
						ratingInput = thisHolder.find( '.qodef-rating' ),
						ratingValue = ratingInput.val(),
						stars       = thisHolder.find( '.qodef-star-rating' );

					addActive( stars, ratingValue );

					stars.on(
						'click',
						function () {
							ratingInput.val( $( this ).data( 'value' ) ).trigger( 'change' );
						}
					);

					ratingInput.change(
						function () {
							ratingValue = ratingInput.val();

							addActive( stars, ratingValue );
						}
					);
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideArea.init();
		}
	);

	var qodefSideArea = {
		init: function () {
			var $sideAreaOpener = $( 'a.qodef-side-area-opener' ),
				$sideAreaClose  = $( '#qodef-side-area-close' ),
				$sideArea       = $( '#qodef-side-area' );

			qodefSideArea.openerHoverColor( $sideAreaOpener );

			// Open Side Area
			$sideAreaOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! qodefCore.body.hasClass( 'qodef-side-area--opened' ) ) {
						qodefSideArea.openSideArea();

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideArea.closeSideArea();
								}
							}
						);
					} else {
						qodefSideArea.closeSideArea();
					}
				}
			);

			$sideAreaClose.on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			if ( $sideArea.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $sideArea );
			}
		},
		openSideArea: function () {
			var $wrapper      = $( '#qodef-page-wrapper' );
			var currentScroll = $( window ).scrollTop();

			$( '.qodef-side-area-cover' ).remove();
			$wrapper.prepend( '<div class="qodef-side-area-cover"/>' );
			qodefCore.body.removeClass( 'qodef-side-area-animate--out' ).addClass( 'qodef-side-area--opened qodef-side-area-animate--in' );

			$( '.qodef-side-area-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			$( window ).scroll(
				function () {
					if ( Math.abs( qodefCore.scroll - currentScroll ) > 400 ) {
						qodefSideArea.closeSideArea();
					}
				}
			);
		},
		closeSideArea: function () {
			qodefCore.body.removeClass( 'qodef-side-area--opened qodef-side-area-animate--in' ).addClass( 'qodef-side-area-animate--out' );
		},
		openerHoverColor: function ( $opener ) {
			if ( typeof $opener.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $opener.data( 'hover-color' );
				var originalColor = $opener.css( 'color' );

				$opener.on(
					'mouseenter',
					function () {
						$opener.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$opener.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function() {
			qodefSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefSpinner.windowLoaded = true;

			if (document.visibilityState === 'visible') {
				qodefSpinner.fadeOutLoader();
			} else {
				document.addEventListener("visibilitychange", function() {
					if (document.visibilityState === 'visible') {
						qodefSpinner.fadeOutLoader();
					}
				});
			}
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefSpinner.init( isEditMode );
			}
		}
	);

	var qodefSpinner = {
		holder: '',
		windowLoaded: false,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner:not(.qodef--custom-spinner):not(.qodef-layout--textual)' );

			if ( this.holder.length ) {
				qodefSpinner.animateSpinner( isEditMode );
				qodefSpinner.fadeOutAnimation();
			}
		},
		animateSpinner: function ( isEditMode ) {

			if ( isEditMode ) {
				qodefSpinner.fadeOutLoader();
			}
		},
		fadeOutLoader: function ( speed, delay, easing ) {
			var $holder = qodefSpinner.holder.length ? qodefSpinner.holder : $( '#qodef-page-spinner:not(.qodef--custom-spinner):not(.qodef-layout--textual)' );

			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		},
		fadeOutAnimation: function () {

			// Check for fade out animation
			if ( qodefCore.body.hasClass( 'qodef-spinner--fade-out' ) ) {
				var $pageHolder = $( '#qodef-page-wrapper' ),
					$linkItems  = $( 'a' );

				// If back button is pressed, than show content to avoid state where content is on display:none
				window.addEventListener(
					'pageshow',
					function ( event ) {
						var historyPath = event.persisted || (typeof window.performance !== 'undefined' && window.performance.navigation.type === 2);
						if ( historyPath && ! $pageHolder.is( ':visible' ) ) {
							$pageHolder.show();
						}
					}
				);

				$linkItems.on(
					'click',
					function ( e ) {
						var $clickedLink = $( this );

						if (
							e.which === 1 && // check if the left mouse button has been pressed
							$clickedLink.attr( 'href' ).indexOf( window.location.host ) >= 0 && // check if the link is to the same domain
							! $clickedLink.hasClass( 'remove' ) && // check is WooCommerce remove link
							$clickedLink.parent( '.product-remove' ).length <= 0 && // check is WooCommerce remove link
							$clickedLink.parents( '.woocommerce-product-gallery__image' ).length <= 0 && // check is product gallery link
							typeof $clickedLink.data( 'rel' ) === 'undefined' && // check pretty photo link
							typeof $clickedLink.attr( 'rel' ) === 'undefined' && // check VC pretty photo link
							! $clickedLink.hasClass( 'lightbox-active' ) && // check is lightbox plugin active
							(typeof $clickedLink.attr( 'target' ) === 'undefined' || $clickedLink.attr( 'target' ) === '_self') && // check if the link opens in the same window
							$clickedLink.attr( 'href' ).split( '#' )[0] !== window.location.href.split( '#' )[0] // check if it is an anchor aiming for a different page
						) {
							e.preventDefault();

							$pageHolder.fadeOut(
								600,
								'easeOutSine',
								function () {
									window.location = $clickedLink.attr( 'href' );
								}
							);
						}
					}
				);
			}
		}
	};

	qodefCore.qodefSpinner = qodefSpinner;

})( jQuery );

(function ($) {
    "use strict";

    $(window).on('load', function () {
        qodefStickyColumn.init('init');
    });

    $(window).resize(function () {
        qodefStickyColumn.init('resize');
    });

    $( document ).on(
        'corsen_trigger_get_new_posts',
        function () {
        }
    );

    var qodefStickyColumn = {
        init: function () {
            var stickyColumnHolder = $( '.qodef-sticky-column--yes' );

            if ( stickyColumnHolder.length ) {
                stickyColumnHolder.each(
                    function () {

                        $( this ).closest( '#qodef-page-wrapper' ).css(
                            'overflow',
                            'visible'
                        );

                        var height = $( this ).height();
                        var width  = $( this ).css( 'width' );

                        // $( this ).css(
                        //     'top',
                        //     'calc(50% - ' + (height / 2) + 'px )'
                        // );
                    }
                );
            }
        }
    };

    window.qodefStickyColumn       = qodefStickyColumn;
})(jQuery);

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_accordion = {};

	$( document ).ready(
		function () {
			qodefAccordion.init();
		}
	);

	var qodefAccordion = {
		init: function () {
			var $holder = $( '.qodef-accordion' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						qodefAccordion.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( $currentItem.hasClass( 'qodef-behavior--accordion' ) ) {
				qodefAccordion.initAccordion( $currentItem );
			}

			if ( $currentItem.hasClass( 'qodef-behavior--toggle' ) ) {
				qodefAccordion.initToggle( $currentItem );
			}

			$currentItem.addClass( 'qodef--init' );
		},
		initAccordion: function ( $accordion ) {
			$accordion.accordion(
				{
					animate: 'swing',
					collapsible: true,
					active: 0,
					icons: '',
					heightStyle: 'content',
				}
			);
		},
		initToggle: function ( $toggle ) {
			var $toggleAccordionTitle = $toggle.find( '.qodef-accordion-title' );

			$toggleAccordionTitle.off().on(
				'mouseenter',
				function () {
					$( this ).addClass( 'ui-state-hover' );
				}
			).on(
				'mouseleave',
				function () {
					$( this ).removeClass( 'ui-state-hover' );
				}
			).on(
				'click',
				function ( e ) {
					e.preventDefault();
					e.stopImmediatePropagation();

					var $thisTitle = $( this );

					if ( $thisTitle.hasClass( 'ui-state-active' ) ) {
						$thisTitle.removeClass( 'ui-state-active' );
						$thisTitle.next().removeClass( 'ui-accordion-content-active' ).slideUp( 300 );
					} else {
						$thisTitle.addClass( 'ui-state-active' );
						$thisTitle.next().addClass( 'ui-accordion-content-active' ).slideDown( 400 );
					}
				}
			);
		}
	};

	qodefCore.shortcodes.corsen_core_accordion.qodefAccordion = qodefAccordion;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_button = {};

	$( document ).ready(
		function () {
			qodefButton.init();
		}
	);

	var qodefButton = {
		init: function () {
			this.buttons = $( '.qodef-button' );

			if ( this.buttons.length ) {
				this.buttons.each(
					function () {
						qodefButton.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefButton.buttonHoverColor( $currentItem );
			qodefButton.buttonHoverBgColor( $currentItem );
			qodefButton.buttonHoverBorderColor( $currentItem );
		},
		buttonHoverColor: function ( $button ) {
			if ( typeof $button.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $button.data( 'hover-color' );
				var originalColor = $button.css( 'color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'color', hoverColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'color', originalColor );
					}
				);
			}
		},
		buttonHoverBgColor: function ( $button ) {
			if ( typeof $button.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $button.data( 'hover-background-color' );
				var originalBackgroundColor = $button.css( 'background-color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'background-color', hoverBackgroundColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'background-color', originalBackgroundColor );
					}
				);
			}
		},
		buttonHoverBorderColor: function ( $button ) {
			if ( typeof $button.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $button.data( 'hover-border-color' );
				var originalBorderColor = $button.css( 'borderTopColor' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'border-color', hoverBorderColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'border-color', originalBorderColor );
					}
				);
			}
		},
		changeColor: function ( $button, cssProperty, color ) {
			$button.css( cssProperty, color );
		}
	};

	qodefCore.shortcodes.corsen_core_button.qodefButton = qodefButton;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_countdown = {};

	$( document ).ready(
		function () {
			qodefCountdown.init();
		}
	);

	var qodefCountdown = {
		init: function () {
			this.countdowns = $( '.qodef-countdown' );

			if ( this.countdowns.length ) {
				this.countdowns.each(
					function () {
						qodefCountdown.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $countdownElement = $currentItem.find( '.qodef-m-date' ),
				dateFormats       = ['week', 'day', 'hour', 'minute', 'second'],
				options           = qodefCountdown.generateOptions( $currentItem, dateFormats );

			qodefCountdown.initCountdown( $countdownElement, options, dateFormats );
		},
		generateOptions: function ( $countdown, dateFormats ) {
			var options = {};

			options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;

			for ( var i = 0; i < dateFormats.length; i++ ) {
				var label       = dateFormats[i] + 'Label',
					labelPlural = dateFormats[i] + 'LabelPlural';

				options[label]       = typeof $countdown.data( dateFormats[i] + '-label' ) !== 'undefined' ? $countdown.data( dateFormats[i] + '-label' ) : '';
				options[labelPlural] = typeof $countdown.data( dateFormats[i] + '-label-plural' ) !== 'undefined' ? $countdown.data( dateFormats[i] + '-label-plural' ) : '';
			}

			return options;
		},
		initCountdown: function ( $countdownElement, options, dateFormats ) {
			var countDownDate = new Date( options.date ).getTime();

			// Update the count down every 1 second
			var x = setInterval(
				function () {

					// Get today's date and time
					var now = new Date().getTime();

					// Find the distance between now and the count down date
					var distance = countDownDate - now;

					// Time calculations for days, hours, minutes and seconds
					this.weeks   = Math.floor( distance / (1000 * 60 * 60 * 24 * 7) );
					this.days    = Math.floor( (distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24) );
					this.hours   = Math.floor( (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60) );
					this.minutes = Math.floor( (distance % (1000 * 60 * 60)) / (1000 * 60) );
					this.seconds = Math.floor( (distance % (1000 * 60)) / 1000 );

					for ( var i = 0; i < dateFormats.length; i++ ) {
						var dateName = dateFormats[i] + 's';
						qodefCountdown.initiateDate( $countdownElement, this[dateName], dateFormats[i], options );
					}

					// If the count down is finished, write some text
					if ( distance < 0 ) {
						clearInterval( x );
						qodefCountdown.afterClearInterval( $countdownElement, dateFormats, options );
					}
				},
				1000
			);
		},
		initiateDate: function ( $countdownElement, date, dateFormat, options ) {
			var $holder = $countdownElement.find( '.qodef-' + dateFormat + 's' );

			$holder.find( '.qodef-label' ).html( ( 1 === date ) ? options[dateFormat + 'Label'] : options[dateFormat + 'LabelPlural'] );

			date = (date < 10) ? '0' + date : date;

			$holder.find( '.qodef-digit' ).html( date );
		},
		afterClearInterval: function( $countdownElement, dateFormats, options ) {
			for ( var i = 0; i < dateFormats.length; i++ ) {
				var $holder = $countdownElement.find( '.qodef-' + dateFormats[i] + 's' );

				$holder.find( '.qodef-label' ).html( options[dateFormats[i] + 'LabelPlural'] );
				$holder.find( '.qodef-digit' ).html( '00' );
			}
		}
	};

	qodefCore.shortcodes.corsen_core_countdown.qodefCountdown = qodefCountdown;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_counter = {};

	$( document ).ready(
		function () {
			qodefCounter.init();
		}
	);

	var qodefCounter = {
		init: function () {
			this.counters = $( '.qodef-counter' );

			if ( this.counters.length ) {
				this.counters.each(
					function () {
						qodefCounter.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $counterElement = $currentItem.find( '.qodef-m-digit' ),
				options         = qodefCounter.generateOptions( $currentItem );

			qodefCore.qodefIsInViewport.check(
				$currentItem,
				function () {
					qodefCounter.counterScript( $counterElement, options );
				},
				false
			);
		},
		generateOptions: function ( $counter ) {
			var options   = {};
			options.start = typeof $counter.data( 'start-digit' ) !== 'undefined' && $counter.data( 'start-digit' ) !== '' ? $counter.data( 'start-digit' ) : 0;
			options.end   = typeof $counter.data( 'end-digit' ) !== 'undefined' && $counter.data( 'end-digit' ) !== '' ? $counter.data( 'end-digit' ) : null;
			options.step  = typeof $counter.data( 'step-digit' ) !== 'undefined' && $counter.data( 'step-digit' ) !== '' ? $counter.data( 'step-digit' ) : 1;
			options.delay = typeof $counter.data( 'step-delay' ) !== 'undefined' && $counter.data( 'step-delay' ) !== '' ? parseInt( $counter.data( 'step-delay' ), 10 ) : 100;
			options.txt   = typeof $counter.data( 'digit-label' ) !== 'undefined' && $counter.data( 'digit-label' ) !== '' ? $counter.data( 'digit-label' ) : '';

			return options;
		},
		counterScript: function ( $counterElement, options ) {
			var defaults = {
				start: 0,
				end: null,
				step: 1,
				delay: 50,
				txt: '',
			};

			var settings = $.extend( defaults, options || {} );
			var nb_start = settings.start;
			var nb_end   = settings.end;

			$counterElement.text( nb_start + settings.txt );

			// Timer
			// Launches every "settings.delay"
			var counterInterval = setInterval(
				function () {
					// Definition of conditions of arrest
					if ( nb_end !== null && nb_start >= nb_end ) {
						return;
					}

					// incrementation
					nb_start = nb_start + settings.step;

					// Check is ended
					if ( nb_start >= nb_end ) {
						nb_start = nb_end;

						clearInterval( counterInterval );
					}

					// display
					$counterElement.text( nb_start + settings.txt );
				},
				settings.delay
			);
		}
	};

	qodefCore.shortcodes.corsen_core_counter.qodefCounter = qodefCounter;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_fixed_indent_slider = {};

	$( document ).ready(
		function () {
			qodefFixedIndentSlider.init();
		}
	);

	var qodefFixedIndentSlider = {
		init: function () {
			this.holder = $( '.qodef-fixed-indent-slider-holder-outer .qodef-fixed-indent-slider-holder' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefFixedIndentSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var sliderOptions     = typeof $holder.data( 'options' ) !== 'undefined' ? $holder.data( 'options' ) : {},
				sliderScroll      = sliderOptions.sliderScroll !== undefined && sliderOptions.sliderScroll !== 'no' ? sliderOptions.sliderScroll : false,
				loop              = sliderOptions.loop !== undefined && sliderOptions.loop !== '' ? sliderOptions.loop : true,
				autoplay          = sliderOptions.autoplay !== undefined && sliderOptions.autoplay !== '' ? sliderOptions.autoplay : true,
				speed             = sliderOptions.speed !== undefined && sliderOptions.speed !== '' ? parseInt( sliderOptions.speed, 10 ) : 5000,
				speedAnimation    = sliderOptions.speedAnimation !== undefined && sliderOptions.speedAnimation !== '' ? parseInt( sliderOptions.speedAnimation, 10 ) : 800,
				slideAnimation    = sliderOptions.slideAnimation !== undefined && sliderOptions.slideAnimation !== '' ? sliderOptions.slideAnimation : '';

			if ( autoplay !== false && speed !== 5000 ) {
				autoplay = {
					delay: speed,
				};
			}

			var $swiperHolder 	  = $holder.find( '.qodef-m-swiper' ),
				$sliderHolder 	  = $holder.find( '.qodef-m-items' ),
				$pagination   	  = $holder.find( '.swiper-pagination' ),
				slidesPerView 	  = 2.1947,
				slidesPerView1440 = 2.1947,
				slidesPerView1368 = 2.1947,
				slidesPerView1366 = 2.1947,
				slidesPerView1280 = 2.1947,
				slidesPerView1024 = 1.476,
				slidesPerView834  = 1.476,
				slidesPerView768  = 1.476,
				slidesPerView680  = 1,
				slidesPerView480  = 1;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: false,
					spaceBetween: 30,
					autoplay: autoplay,
					loop: loop,
					speed: speedAnimation,
					pagination: {
						el: $pagination,
						type: 'bullets',
						clickable: true,
					},
					breakpoints: {
						// when window width is < 481px
						0: {
							slidesPerView: slidesPerView480
						},
						// when window width is >= 481px
						481: {
							slidesPerView: slidesPerView680
						},
						// when window width is >= 681px
						681: {
							slidesPerView: slidesPerView768
						},
						// when window width is >= 769px
						769: {
							slidesPerView: slidesPerView834
						},
						// when window width is >= 835px
						835: {
							slidesPerView: slidesPerView1024
						},
						// when window width is >= 1025px
						1025: {
							slidesPerView: slidesPerView1280
						},
						// when window width is >= 1281px
						1281: {
							slidesPerView: slidesPerView1366
						},
						// when window width is >= 1367px
						1367: {
							slidesPerView: slidesPerView1368
						},
						// when window width is >= 1369px
						1369: {
							slidesPerView: slidesPerView1440
						},
						// when window width is >= 1441px
						1441: {
							slidesPerView: slidesPerView
						}
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									$sliderHolder.addClass( 'qodef-swiper--initialized' );
								},
								1500
							);

							if ( sliderScroll ) {
								var scrollStart = false;

								$sliderHolder.on(
									'mousewheel',
									function ( e ) {
										e.preventDefault();

										if ( ! scrollStart ) {
											scrollStart = true;

											if ( e.deltaY < 0 ) {
												$swiper.slideNext();
											} else {
												$swiper.slidePrev();
											}

											setTimeout(
												function () {
													scrollStart = false;
												},
												1000
											);
										}
									}
								);
							}
						}
					},
				}
			);
		}
	};

	qodefCore.shortcodes.corsen_core_fixed_indent_slider.qodefFixedIndentSlider = qodefFixedIndentSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_google_map = {};

	$( document ).ready(
		function () {
			qodefGoogleMap.init();
		}
	);

	var qodefGoogleMap = {
		init: function () {
			this.holder = $( '.qodef-google-map' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefGoogleMap.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( typeof window.qodefGoogleMap !== 'undefined' ) {
				window.qodefGoogleMap.init( $currentItem.find( '.qodef-m-map' ) );
			}
		},
	};

	qodefCore.shortcodes.corsen_core_google_map.qodefGoogleMap = qodefGoogleMap;

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_icon = {};

	$( document ).ready(
		function () {
			qodefIcon.init();
		}
	);

	var qodefIcon = {
		init: function () {
			this.icons = $( '.qodef-icon-holder' );

			if ( this.icons.length ) {
				this.icons.each(
					function () {
						qodefIcon.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefIcon.iconHoverColor( $currentItem );
			qodefIcon.iconHoverBgColor( $currentItem );
			qodefIcon.iconHoverBorderColor( $currentItem );
		},
		iconHoverColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-color' ) !== 'undefined' ) {
				var spanHolder    = $iconHolder.find( 'span' ).length ? $iconHolder.find( 'span' ) : $iconHolder;
				var originalColor = spanHolder.css( 'color' );
				var hoverColor    = $iconHolder.data( 'hover-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							hoverColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							originalColor
						);
					}
				);
			}
		},
		iconHoverBgColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $iconHolder.data( 'hover-background-color' );
				var originalBackgroundColor = $iconHolder.css( 'background-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							hoverBackgroundColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							originalBackgroundColor
						);
					}
				);
			}
		},
		iconHoverBorderColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $iconHolder.data( 'hover-border-color' );
				var originalBorderColor = $iconHolder.css( 'borderTopColor' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							hoverBorderColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							originalBorderColor
						);
					}
				);
			}
		},
		changeColor: function ( iconElement, cssProperty, color ) {
			iconElement.css(
				cssProperty,
				color
			);
		}
	};

	qodefCore.shortcodes.corsen_core_icon.qodefIcon = qodefIcon;

})( jQuery );

(function ($) {
	'use strict';

	qodefCore.shortcodes.corsen_core_image_gallery                    = {};
	qodefCore.shortcodes.corsen_core_image_gallery.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.corsen_core_image_gallery.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.corsen_core_image_gallery.qodefMagnificPopup = qodef.qodefMagnificPopup;
	qodefCore.shortcodes.corsen_core_image_gallery.qodefDragCursor    = qodefCore.qodefDragCursor;
	qodefCore.shortcodes.corsen_core_image_gallery.qodefBlurHover     = qodefCore.qodefBlurHover;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_image_with_text = {};

	$(document).ready(function () {
		qodefScrollingImageWithText.init();
	});

	var qodefScrollingImageWithText = {
		init: function () {
			var $holder = $('.qodef-image-with-text.qodef-image-action--scrolling-image');

			if ($holder.length) {
				$holder.each(function(){
					var $thisHolder = $(this),
						$imageHolder 	= $thisHolder.find('.qodef-m-image-inner-holder'),
						$scrollingImage = $thisHolder.find('.qodef-m-image img'),
						$scrollingFrame = $thisHolder.find('.qodef-m-iwt-frame'),
						horizontal 		= $thisHolder.hasClass('qodef-scrolling-direction--horizontal'),
						state;

					var initAnimation = function() {
						state = qodefScrollingImageWithText.sizing($scrollingImage, $scrollingFrame, horizontal);
						qodefScrollingImageWithText.scrollAnimation($imageHolder, $scrollingImage, state);
					}

					qodef.qodefWaitForImages.check(
						$thisHolder,
						function () {
							initAnimation();
						}
					);

					$(window).resize(function(){
						initAnimation();
					});
				});
			}
		},
		sizing: function($scrollingImage, $scrollingFrame, horizontal) {
			var scrollingFrameHeight = $scrollingFrame.height(),
				scrollingImageHeight = $scrollingImage.height(),
				scrollingFrameWidth  = $scrollingFrame.width(),
				scrollingImageWidth  = $scrollingImage.width(),
				delta,
				timing,
				scrollable = false;

			if (horizontal) {
				delta = Math.round(scrollingImageWidth - scrollingFrameWidth);
				timing = Math.round(scrollingImageWidth / scrollingFrameWidth) * 2;
			} else {
				delta = Math.round(scrollingImageHeight - scrollingFrameHeight);
				timing = Math.round(scrollingImageHeight / scrollingFrameHeight) * 2;
			}

			if (horizontal) {
				if (scrollingImageWidth > scrollingFrameWidth) {
					scrollable = true;
				}
			} else {
				if (scrollingImageHeight > scrollingFrameHeight) {
					scrollable = true;
				}
			}

			return {
				delta: delta,
				timing: timing,
				scrollable: scrollable,
				horizontal: horizontal
			}
		},
		scrollAnimation: function($thisHolder, $scrollingImage, state) {
			//scroll animation on hover
			$thisHolder.mouseenter(function(){
				$scrollingImage.css('transition-duration', state.timing +'s'); //transition duration set in relation to image height
				if (state.horizontal) {
					$scrollingImage.css('transform', 'translate3d(-'+ state.delta +'px, 0px, 0px)');
				} else {
					$scrollingImage.css('transform', 'translate3d(0px, -'+ state.delta +'px, 0px)');
				}});

			//scroll animation reset
			$thisHolder.mouseleave(function(){
				if (state.scrollable) {
					$scrollingImage.css('transition-duration', Math.min(state.timing / 3, 3) +'s');
					$scrollingImage.css('transform', 'translate3d(0px, 0px, 0px)');
				}
			});
		}
	};


	qodefCore.shortcodes.corsen_core_image_with_text.qodefScrollingImageWithText = qodefScrollingImageWithText;
	qodefCore.shortcodes.corsen_core_image_with_text.qodefMagnificPopup 		   = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_interactive_link_showcase = {};

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_progress_bar = {};

	$( document ).ready(
		function () {
			qodefProgressBar.init();
		}
	);

	/**
	 * Init progress bar shortcode functionality
	 */
	var qodefProgressBar = {
		init: function () {
			this.holder = $( '.qodef-progress-bar' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefProgressBar.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var layout = $currentItem.data( 'layout' );

			qodefCore.qodefIsInViewport.check(
				$currentItem,
				function () {
					$currentItem.addClass( 'qodef--init' );

					var $container = $currentItem.find( '.qodef-m-canvas' ),
						data       = qodefProgressBar.generateBarData( $currentItem, layout ),
						number     = $currentItem.data( 'number' ) / 100;

					switch (layout) {
						case 'circle':
							qodefProgressBar.initCircleBar( $container, data, number );
							break;
						case 'semi-circle':
							qodefProgressBar.initSemiCircleBar( $container, data, number );
							break;
						case 'line':
							data = qodefProgressBar.generateLineData( $currentItem, number );
							qodefProgressBar.initLineBar( $container, data );
							break;
						case 'custom':
							qodefProgressBar.initCustomBar( $container, data, number );
							break;
					}
				},
				false
			);
		},
		generateBarData: function ( thisBar, layout ) {
			var activeWidth   = thisBar.data( 'active-line-width' );
			var activeColor   = thisBar.data( 'active-line-color' );
			var inactiveWidth = thisBar.data( 'inactive-line-width' );
			var inactiveColor = thisBar.data( 'inactive-line-color' );
			var easing        = 'linear';
			var duration      = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor     = thisBar.data( 'text-color' );

			return {
				strokeWidth: activeWidth,
				color: activeColor,
				trailWidth: inactiveWidth,
				trailColor: inactiveColor,
				easing: easing,
				duration: duration,
				svgStyle: {
					width: '100%',
					height: '100%'
				},
				text: {
					style: {
						color: textColor
					},
					autoStyleContainer: false
				},
				from: {
					color: inactiveColor
				},
				to: {
					color: activeColor
				},
				step: function ( state, bar ) {
					if ( layout !== 'custom' ) {
						bar.setText( Math.round( bar.value() * 100 ) + '%' );
					}
				},
			};
		},
		generateLineData: function ( thisBar, number ) {
			var height         = thisBar.data( 'active-line-width' );
			var activeColor    = thisBar.data( 'active-line-color' );
			var inactiveHeight = thisBar.data( 'inactive-line-width' );
			var inactiveColor  = thisBar.data( 'inactive-line-color' );
			var duration       = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor      = thisBar.data( 'text-color' );

			return {
				percentage: number * 100,
				duration: duration,
				fillBackgroundColor: activeColor,
				backgroundColor: inactiveColor,
				height: height,
				inactiveHeight: inactiveHeight,
				followText: thisBar.hasClass( 'qodef-percentage--floating' ),
				textColor: textColor,
			};
		},
		initCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Circle( $container[0], data );

				$bar.animate( number );
			}
		},
		initSemiCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.SemiCircle( $container[0], data );

				$bar.animate( number );
			}
		},
		initCustomBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Path( $container[0], data );

				$bar.set( 0 );
				$bar.animate( number );
			}
		},
		initLineBar: function ( $container, data ) {
			$container.LineProgressbar( data );
		},
		checkBar: function ( $container ) {
			// check if svg is already in container, elementor fix
			if ( $container.find( 'svg' ).length ) {
				return false;
			}

			return true;
		}
	};

	qodefCore.shortcodes.corsen_core_progress_bar.qodefProgressBar = qodefProgressBar;

})( jQuery );

(function ($) {
	"use strict";

	qodefCore.shortcodes.corsen_core_single_image = {};

	qodefCore.shortcodes.corsen_core_single_image.qodefAppear = qodefCore.qodefAppear;
})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_swapping_image_gallery = {};

	$( document ).ready(
		function () {
			qodefSwappingImageGallery.init();
		}
	);

	var qodefSwappingImageGallery = {
		init: function () {
			this.holder = $( '.qodef-swapping-image-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefSwappingImageGallery.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $swiperHolder     = $currentItem.find( '.qodef-m-image-holder' );
			var $paginationHolder = $currentItem.find( '.qodef-m-thumbnails-holder .qodef-grid-inner' );
			var spaceBetween      = 0;
			var slidesPerView     = 1;
			var centeredSlides    = false;
			var loop              = false;
			var autoplay          = false;
			var speed             = 800;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: centeredSlides,
					spaceBetween: spaceBetween,
					autoplay: autoplay,
					loop: loop,
					speed: speed,
					effect: 'fade',
					fadeEffect: {
						crossFade: true
					},
					pagination: {
						el: $paginationHolder,
						type: 'custom',
						clickable: true,
						bulletClass: 'qodef-m-thumbnail',
					},
					on: {
						init: function () {
							$swiperHolder.addClass( 'qodef-swiper--initialized' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( 0 ).addClass( 'qodef--active' );
						},
						slideChange: function slideChange() {
							var swiper      = this;
							var activeIndex = swiper.activeIndex;
							$paginationHolder.find( '.qodef--active' ).removeClass( 'qodef--active' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( activeIndex ).addClass( 'qodef--active' );
						}
					},
				}
			);
		},
	};

	qodefCore.shortcodes.corsen_core_swapping_image_gallery.qodefSwappingImageGallery = qodefSwappingImageGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_tabs = {};

	$( document ).ready(
		function () {
			qodefTabs.init();
		}
	);

	var qodefTabs = {
		init: function () {
			this.holder = $( '.qodef-tabs' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTabs.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			$currentItem.children( '.qodef-tabs-content' ).each(
				function ( index ) {
					index = index + 1;

					var $that    = $( this ),
						link     = $that.attr( 'id' ),
						$navItem = $that.parent().find( '.qodef-tabs-navigation li:nth-child(' + index + ') a' ),
						navLink  = $navItem.attr( 'href' );

					link = '#' + link;

					if ( link.indexOf( navLink ) > -1 ) {
						$navItem.attr(
							'href',
							link
						);
					}
				}
			);

			$currentItem.addClass( 'qodef--init' ).tabs();
		},
		setHeight ( $holder ) {
			var $navigation      = $holder.find( '.qodef-tabs-navigation' ),
				$content         = $holder.find( '.qodef-tabs-content' ),
				navHeight,
				contentHeight,
				maxContentHeight = 0;

			if ( $navigation.length ) {
				navHeight = $navigation.outerHeight( true );
			}

			if ( $content.length ) {
				$content.each(
					function () {
						contentHeight = $( this ).outerHeight( true );
						maxContentHeight = contentHeight > maxContentHeight ? contentHeight : maxContentHeight;
					}
				)
			}

			$holder.height(navHeight + maxContentHeight);
		}
	};

	qodefCore.shortcodes.corsen_core_tabs.qodefTabs = qodefTabs;

})( jQuery );

(function ($) {
	'use strict';

	qodefCore.shortcodes.corsen_core_text_marquee = {};

	$(document).ready(
		function () {
			qodefTextMarquee.init();
		}
	);

	$(window).resize(
		function () {
			qodefTextMarquee.init();
		}
	);

	var qodefTextMarquee = {
		init               : function () {
			this.holder = $('.qodef-text-marquee');

			if (this.holder.length) {
				this.holder.each(
					function () {
						qodefTextMarquee.prepareContent($(this));
						qodefTextMarquee.calculateWidthRatio($(this));
					}
				);
			}
		},
		prepareContent     : function ($currentItem) {
			var $contentInnerCopy = $currentItem.find('.qodef--copy');

			// remove holder init class
			$currentItem.removeClass('qodef--init');

			// remove duplicated content
			if ($contentInnerCopy.length) {
				$contentInnerCopy.remove();
			}
		},
		calculateWidthRatio: function ($currentItem) {
			var $content = $currentItem.find('.qodef-m-content'),
				$contentInner = $content.find('.qodef-m-content-inner'),
				multiplyCoef = Math.ceil($content.outerWidth() / $contentInner.outerWidth()),
				i;

			// duplicate content at least once
			for (i = 0; i < multiplyCoef; i++) {
				qodefTextMarquee.duplicateContent($content, $contentInner);
			}

			// add holder init class
			$currentItem.addClass('qodef--init');
		},
		duplicateContent   : function ($content, $contentInner) {
			$contentInner.clone().appendTo($content).addClass('qodef--copy');
		},
	};

	qodefCore.shortcodes.corsen_core_text_marquee.qodefTextMarquee = qodefTextMarquee;

})(jQuery);

(function ($) {
	'use strict';

	qodefCore.shortcodes.corsen_vertical_split_slider = {};

	$( document ).ready(
		function () {
			qodefVerticalSplitSlider.init();
		}
	);

	var qodefVerticalSplitSlider = {
		init              : function () {
			var $holder = $( '.qodef-vertical-split-slider' );

			if ($holder.length) {
				qodefVerticalSplitSlider.initItem( $holder );
			}
		},
		initItem          : function ($holder) {
			var $headerInner       = $( '#qodef-page-header-inner' ),
				breakpoint         = qodefVerticalSplitSlider.getBreakpoint( $holder ),
				initialHeaderStyle = '';

			if ($headerInner.hasClass( 'qodef-skin--light' )) {
				initialHeaderStyle = 'light';
			} else if ($headerInner.hasClass( 'qodef-skin--dark' )) {
				initialHeaderStyle = 'dark';
			}

			$holder.multiscroll(
				{
					navigation        : true,
					navigationPosition: 'right',
					easing: 'easeInOutCubic',
					scrollingSpeed: 800,
					afterRender       : function () {
						qodefCore.body.addClass( 'qodef-vertical-split-slider--init' );
						qodefVerticalSplitSlider.headerClassHandler( $( '.ms-left .ms-section:first-child' ).data( 'header-skin' ), initialHeaderStyle, $headerInner );
					},
					onLeave           : function (index, nextIndex) {
						qodefVerticalSplitSlider.headerClassHandler( $( $( '.ms-left .ms-section' )[nextIndex - 1] ).data( 'header-skin' ), initialHeaderStyle, $headerInner );
					},
				}
			);

			// $holder.height(qodefCore.windowHeight);
			qodefVerticalSplitSlider.buildAndDestroy( breakpoint );

			$( window ).resize(
				function () {
					qodefVerticalSplitSlider.buildAndDestroy( breakpoint );
				}
			);
		},
		getBreakpoint     : function ($holder) {
			if ($holder.hasClass( 'qodef-disable-below--768' )) {
				return 768;
			} else {
				return 1024;
			}
		},
		buildAndDestroy   : function (breakpoint) {
			if (qodefCore.windowWidth <= breakpoint) {
				$.fn.multiscroll.destroy();
				qodefCore.body.removeClass( 'qodef-vertical-split-slider--init' );
				// enable scroll on responsive layout
				qodefCore.body.css( {'overflow': 'initial'} );
				qodefCore.html.css( {'overflow': 'initial'} );
			} else {
				$.fn.multiscroll.build();
				qodefCore.body.addClass( 'qodef-vertical-split-slider--init' );
			}
		},
		headerClassHandler: function (slideHeaderStyle, initialHeaderStyle, $headerInner) {
			var $controls = $( '#multiscroll-nav' );

			if (slideHeaderStyle !== undefined && slideHeaderStyle !== '') {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );

				if ($controls.length) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );
				}
			} else if (initialHeaderStyle !== '') {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );

				if ($controls.length) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' ).addClass( 'qodef-skin--' + slideHeaderStyle );
				}
			} else {
				$headerInner.removeClass( 'qodef-skin--light qodef-skin--dark' );

				if ($controls.length) {
					$controls.removeClass( 'qodef-skin--light qodef-skin--dark' );
				}
			}
		}
	};

	qodefCore.shortcodes.corsen_vertical_split_slider.qodefVerticalSplitSlider = qodefVerticalSplitSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_video_button                    = {};
	qodefCore.shortcodes.corsen_core_video_button.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefStickySidebar.init();
		}
	);

	var qodefStickySidebar = {
		init: function () {
			var info = $( '.widget_corsen_core_sticky_sidebar' );

			if ( info.length && qodefCore.windowWidth > 1024 ) {
				info.wrapper = info.parents( '#qodef-page-sidebar' );
				info.offsetM = info.offset().top - info.wrapper.offset().top;
				info.adj     = 15;

				qodefStickySidebar.callStack( info );

				$( window ).on(
					'resize',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.callStack( info );
						}
					}
				);

				$( window ).on(
					'scroll',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.infoPosition( info );
						}
					}
				);
			}
		},
		calc: function ( info ) {
			var content = $( '.qodef-page-content-section' ),
				headerH = qodefCore.body.hasClass( 'qodef-header-appearance--none' ) ? 0 : parseInt( qodefGlobal.vars.headerHeight, 10 );

			// If posts not found set content to have the same height as the sidebar
			if ( qodefCore.windowWidth > 1024 && content.height() < 100 ) {
				content.css( 'height', info.wrapper.height() - content.height() );
			}

			info.start = content.offset().top;
			info.end   = content.outerHeight();
			info.h     = info.wrapper.height();
			info.w     = info.outerWidth();
			info.left  = info.offset().left;
			info.top   = headerH + qodefGlobal.vars.adminBarHeight - info.offsetM;
			info.data( 'state', 'top' );
		},
		infoPosition: function ( info ) {
			if ( qodefCore.scroll < info.start - info.top && qodefCore.scroll + info.h && info.data( 'state' ) !== 'top' ) {
				gsap.to(
					info.wrapper,
					.1,
					{
						y: 5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
				info.data( 'state', 'top' );
				info.wrapper.css(
					{
						'position': 'static',
					}
				);
			} else if ( qodefCore.scroll >= info.start - info.top && qodefCore.scroll + info.h + info.adj <= info.start + info.end &&
				info.data( 'state' ) !== 'fixed' ) {
				var c = info.data( 'state' ) === 'top' ? 1 : -1;
				info.data( 'state', 'fixed' );
				info.wrapper.css(
					{
						'position': 'fixed',
						'top': info.top,
						'left': info.left,
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.2,
					{
						y: 0
					},
					{
						y: c * 10,
						ease: Power4.easeInOut
					}
				);
				gsap.to(
					info.wrapper,
					.2,
					{
						y: 0,
						delay: .2,
					}
				);
			} else if ( qodefCore.scroll + info.h + info.adj > info.start + info.end && info.data( 'state' ) !== 'bottom' ) {
				info.data( 'state', 'bottom' );
				info.wrapper.css(
					{
						'position': 'absolute',
						'top': info.end - info.h - info.adj,
						'left': 'auto',
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.1,
					{
						y: 0
					},
					{
						y: -5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
			}
		},
		callStack: function ( info ) {
			this.calc( info );
			this.infoPosition( info );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'corsen_core_blog_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	qodefCore.shortcodes[shortcode].qodefResizeIframes = qodef.qodefResizeIframes;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefVerticalNavMenu.init();
		}
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalNavMenu = {
		initNavigation: function ( $verticalMenuObject ) {
			var $verticalNavObject = $verticalMenuObject.find( '.qodef-header-vertical-navigation' );

			if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--below' ) ) {
				qodefVerticalNavMenu.dropdownClickToggle( $verticalNavObject );
			} else if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--side' ) ) {
				qodefVerticalNavMenu.dropdownFloat( $verticalNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalAreaScrollable: function ( $verticalMenuObject ) {
			return $verticalMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalAreaScroll: function ( $verticalMenuObject ) {
			if ( qodefVerticalNavMenu.verticalAreaScrollable( $verticalMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalMenuObject );
			}
		},
		init: function () {
			var $verticalMenuObject = $( '.qodef-header--vertical #qodef-page-header' );

			if ( $verticalMenuObject.length ) {
				qodefVerticalNavMenu.initNavigation( $verticalMenuObject );
				qodefVerticalNavMenu.initVerticalAreaScroll( $verticalMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefVerticalSlidingNavMenu.init();
        }
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalSlidingNavMenu = {
		openedScroll: 0,

		initNavigation: function ( $verticalSlidingMenuObject ) {
			var $verticalSlidingNavObject = $verticalSlidingMenuObject.find( '.qodef-header-vertical-sliding-navigation' );

			if ( $verticalSlidingNavObject.hasClass( 'qodef-vertical-sliding-drop-down--below' ) ) {
				qodefVerticalSlidingNavMenu.dropdownClickToggle( $verticalSlidingNavObject );
			} else if ( $verticalSlidingNavObject.hasClass( 'qodef-vertical-sliding-drop-down--side' ) ) {
				qodefVerticalSlidingNavMenu.dropdownFloat( $verticalSlidingNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalSlidingNavObject ) {
			var $menuItems = $verticalSlidingNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalSlidingNavObject ) {
			var $menuItems = $verticalSlidingNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalSlidingAreaScrollable: function ( $verticalSlidingMenuObject ) {
			return $verticalSlidingMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalSlidingAreaScroll: function ( $verticalSlidingMenuObject ) {
			if ( qodefVerticalSlidingNavMenu.verticalSlidingAreaScrollable( $verticalSlidingMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalSlidingMenuObject );
			}
		},
		verticalSlidingAreaShowHide: function ( $verticalSlidingMenuObject ) {
			var $verticalSlidingMenuOpener = $verticalSlidingMenuObject.find( '.qodef-vertical-sliding-menu-opener' );

			$verticalSlidingMenuOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					var $thisOpener = $( this );

					if ( ! $verticalSlidingMenuObject.hasClass( 'qodef-vertical-sliding-menu--opened' ) ) {
						$thisOpener.addClass( 'qodef--opened' );
						$verticalSlidingMenuObject.addClass( 'qodef-vertical-sliding-menu--opened' );
						qodefVerticalSlidingNavMenu.openedScroll = qodef.window.scrollTop();
					} else {
						$thisOpener.removeClass( 'qodef--opened' );
						$verticalSlidingMenuObject.removeClass( 'qodef-vertical-sliding-menu--opened' );
					}
				}
			);
		},
		verticalSlidingAreaCloseOnScroll: function ( $verticalSlidingMenuObject ) {
			qodef.window.on(
				'scroll',
				function () {
					if ( $verticalSlidingMenuObject.hasClass( 'qodef-vertical-sliding-menu--opened' ) && Math.abs( qodef.scroll - qodefVerticalSlidingNavMenu.openedScroll ) > 400 ) {
						$verticalSlidingMenuObject.find( '.qodef-vertical-sliding-menu-opener' ).removeClass( 'qodef--opened' );
						$verticalSlidingMenuObject.removeClass( 'qodef-vertical-sliding-menu--opened' );
					}
				}
			);
		},
		init: function () {
			var $verticalSlidingMenuObject = $( '.qodef-header--vertical-sliding #qodef-page-header' );

			if ( $verticalSlidingMenuObject.length ) {
				qodefVerticalSlidingNavMenu.verticalSlidingAreaShowHide( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.verticalSlidingAreaCloseOnScroll( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.initNavigation( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.initVerticalSlidingAreaScroll( $verticalSlidingMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var fixedHeaderAppearance = {
		showHideHeader: function ( $pageOuter, $header ) {
			if ( qodefCore.windowWidth > 1024 ) {
				if ( qodefCore.scroll <= 0 ) {
					qodefCore.body.removeClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', '0' );
					$header.css( 'margin-top', '0' );
				} else {
					qodefCore.body.addClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.topAreaHeight ) + 'px' );
					$header.css( 'margin-top', parseInt( qodefGlobal.vars.topAreaHeight ) + 'px' );
				}
			}
		},
		init: function () {

			if ( ! qodefCore.body.hasClass( 'qodef-header--vertical' ) ) {
				var $pageOuter = $( '#qodef-page-outer' ),
					$header    = $( '#qodef-page-header' );

				fixedHeaderAppearance.showHideHeader( $pageOuter, $header );

				$( window ).scroll(
					function () {
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);

				$( window ).resize(
					function () {
						$pageOuter.css( 'padding-top', '0' );
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);
			}
		}
	};

	qodefCore.fixedHeaderAppearance = fixedHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	var stickyHeaderAppearance = {
		header: '',
		docYScroll: 0,
		init: function () {
			var displayAmount = stickyHeaderAppearance.displayAmount();

			// Set variables
			stickyHeaderAppearance.header 	  = $( '.qodef-header-sticky' );
			stickyHeaderAppearance.docYScroll = $( document ).scrollTop();

			// Set sticky visibility
			stickyHeaderAppearance.setVisibility( displayAmount );

			$( window ).scroll(
				function () {
					stickyHeaderAppearance.setVisibility( displayAmount );
				}
			);
		},
		displayAmount: function () {
			if ( qodefGlobal.vars.qodefStickyHeaderScrollAmount !== 0 ) {
				return parseInt( qodefGlobal.vars.qodefStickyHeaderScrollAmount, 10 );
			} else {
				return parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.adminBarHeight, 10 );
			}
		},
		setVisibility: function ( displayAmount ) {
			var isStickyHidden = qodefCore.scroll < displayAmount;

			if ( stickyHeaderAppearance.header.hasClass( 'qodef-appearance--up' ) ) {
				var currentDocYScroll = $( document ).scrollTop();

				isStickyHidden = (currentDocYScroll > stickyHeaderAppearance.docYScroll && currentDocYScroll > displayAmount) || (currentDocYScroll < displayAmount);

				stickyHeaderAppearance.docYScroll = $( document ).scrollTop();
			}

			stickyHeaderAppearance.showHideHeader( isStickyHidden );
		},
		showHideHeader: function ( isStickyHidden ) {
			if ( isStickyHidden ) {
				qodefCore.body.removeClass( 'qodef-header--sticky-display' );
			} else {
				qodefCore.body.addClass( 'qodef-header--sticky-display' );
			}
		},
	};

	qodefCore.stickyHeaderAppearance = stickyHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchCoversHeader.init();
		}
	);

	var qodefSearchCoversHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-cover-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.openCoversHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.closeCoversHeader( $searchForm );
					}
				);
			}
		},
		openCoversHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeCoversHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.addClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchFullscreen.init();
		}
	);

	var qodefSearchFullscreen = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchHolder = $( '.qodef-fullscreen-search-holder' ),
				$searchClose  = $searchHolder.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchHolder.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						if ( qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) {
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						} else {
							qodefSearchFullscreen.openFullscreen( $searchHolder );
						}
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchFullscreen.closeFullscreen( $searchHolder );
					}
				);

				//Close on escape
				$( document ).keyup(
					function ( e ) {
						if ( e.keyCode === 27 && qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) { //KeyCode for ESC button is 27
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						}
					}
				);
			}
		},
		openFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).focus();
				},
				900
			);

			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--fadeout' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).val( '' );
					$searchHolder.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
				},
				300
			);

			qodefCore.qodefScroll.enable();
		}
	};

})( jQuery );

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

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearch.init();
		}
	);

	var qodefSearch = {
		init: function () {
			this.search = $( 'a.qodef-search-opener' );

			if ( this.search.length ) {
				this.search.each(
					function () {
						var $thisSearch = $( this );

						qodefSearch.searchHoverColor( $thisSearch );
					}
				);
			}
		},
		searchHoverColor: function ( $searchHolder ) {
			if ( typeof $searchHolder.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $searchHolder.data( 'hover-color' ),
					originalColor = $searchHolder.css( 'color' );

				$searchHolder.on(
					'mouseenter',
					function () {
						$searchHolder.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$searchHolder.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ($) {
	'use strict';

	$( document ).ready(
		function () {
			qodefPredefinedSpinner.init();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			const isEditMode = Boolean( elementorFrontend.isEditMode() );

			if (isEditMode) {
				qodefPredefinedSpinner.init( isEditMode );
			}
		}
	);

	const qodefPredefinedSpinner = {
		init( isEditMode ) {
			const $holder        = $( '#qodef-page-spinner.qodef-layout--predefined' );

			if ($holder.length) {
				if (isEditMode) {
				} else {
					qodefPredefinedSpinner.animateSpinner( $holder );
				}
			}
		},
		animateSpinner( $holder ) {
			var $logo             = $holder.find( '.qodef-m-spinner-logo svg' ),
				$draws            = $logo.children(),
				comparePathLength = 96,
				$appears          = $( '.qodef--custom-appear:not(.qodef-image-with-text)' ),
				$homes            = $( '.qodef--custom-appear.qodef-image-with-text' );

			gsap.set(
				$draws,
				{
					drawSVG:"0% 0%",
					opacity: 0,
				}
			)

			gsap.set(
				$homes,
				{
					y: 70,
					autoAlpha: 0,
				}
			)

			gsap.set(
				$appears,
				{
					autoAlpha: 0,
				}
			)

			var tl = gsap.timeline(
				{
					paused: true,
					onStart: () => {
						gsap.set(
							$logo,
							{
								autoAlpha: 1,
							}
						)
					},
					onComplete:() => {
						if (qodefCore.qodefSpinner.windowLoaded) {
							tlOut.play();
						} else {
							tl.restart();
						}
					},
				}
			);

			var tlOut = gsap.timeline(
				{
					paused: true,
					onComplete:() => {
						$holder.addClass( 'qodef--finished' );
					},
				}
			);

			tlOut
				.to(
					$holder,
					{
						'--qodef-clip': 100,
						duration: 2,
						ease:'power2.inOut'
					},
				)
				.to(
					$homes,
					{
						autoAlpha: 1,
						y: 0,
						stagger: .2,
						duration: 1.2,
					},
					'>-1.7'
				)
				.to(
					$appears,
					{
						autoAlpha: 1,
						stagger: .15,
						duration: 1,
					},
					'>-1.5'
				)

			tl
				.to(
					$draws,
					{
						drawSVG:"0% 100%",
						opacity: 1,
						stagger: {
							each: .15,
						},
						duration: (i) => {
							var $duration = DrawSVGPlugin.getLength( $draws[i] ) / comparePathLength;

							$duration = i === $draws.length - 1 ? 1.5 : $duration * 1.1;

							return $duration;
						},
						ease:'power2.inOut'
					}
				)

			tl.play();
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function() {
			qodefProgressBarSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefProgressBarSpinner.windowLoaded = true;
			qodefProgressBarSpinner.completeAnimation();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefProgressBarSpinner.init( isEditMode );
			}
		}
	);

	var qodefProgressBarSpinner = {
		holder: '',
		windowLoaded: false,
		percentNumber: 0,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			if ( this.holder.length ) {
				qodefProgressBarSpinner.animateSpinner( this.holder, isEditMode );
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			var $numberHolder = $holder.find( '.qodef-m-spinner-number-label' ),
				$spinnerLine  = $holder.find( '.qodef-m-spinner-line-front' );

			$spinnerLine.animate(
				{ 'width': '100%' },
				10000,
				'linear'
			);

			var numberInterval = setInterval(
				function () {
					qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );

					if ( qodefProgressBarSpinner.windowLoaded ) {
						clearInterval( numberInterval );
					}
				},
				100
			);

			if ( isEditMode ) {
				qodefProgressBarSpinner.fadeOutLoader( $holder );
			}
		},
		completeAnimation: function () {
			var $holder = qodefProgressBarSpinner.holder.length ? qodefProgressBarSpinner.holder : $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			var numberIntervalFastest = setInterval(
				function () {

					if ( qodefProgressBarSpinner.percentNumber >= 100 ) {
						clearInterval( numberIntervalFastest );

						$holder.find( '.qodef-m-spinner-line-front' ).stop().animate(
							{ 'width': '100%' },
							500
						);

						$holder.addClass( 'qodef--finished' );

						setTimeout(
							function () {
								qodefProgressBarSpinner.fadeOutLoader( $holder );
							},
							600
						);
					} else {
						qodefProgressBarSpinner.animatePercent(
							$holder.find( '.qodef-m-spinner-number-label' ),
							qodefProgressBarSpinner.percentNumber
						);
					}
				},
				6
			);
		},
		animatePercent: function ( $numberHolder, percentNumber ) {
			if ( percentNumber < 100 ) {
				percentNumber += 5;
				$numberHolder.text( percentNumber );

				qodefProgressBarSpinner.percentNumber = percentNumber;
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefTextualSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefTextualSpinner.windowLoaded = true;
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefTextualSpinner.init( isEditMode );
			}
		}
	);

	var qodefTextualSpinner = {
		init ( isEditMode ) {
			var $holder = $( '#qodef-page-spinner.qodef-layout--textual' );

			if ( $holder.length ) {
				if ( isEditMode ) {
					qodefTextualSpinner.fadeOutLoader( $holder );
				} else {
					qodefTextualSpinner.splitText( $holder );
				}
			}
		},
		splitText ( $holder ) {
			var $textHolder = $holder.find( '.qodef-m-text' );

			if ( $textHolder.length ) {
				var text     = $textHolder.text().trim(),
					chars    = text.split( '' ),
					cssClass = '';

				$textHolder.empty();

				chars.forEach(
					( element ) => {
						cssClass = (element === ' ' ? 'qodef-m-empty-char' : ' ');
						$textHolder.append( '<span class="qodef-m-char ' + cssClass + '">' + element + '</span>' );
					}
				);

				setTimeout(
					() => {
						qodefTextualSpinner.animateSpinner( $holder );
					}, 100
				);
			}
		},
		animateSpinner ( $holder ) {
			$holder.addClass( 'qodef--init' );

			function animationLoop ( animationProps ) {
				var $chars      = $holder.find( '.qodef-m-char' ),
					charsLength = $chars.length - 1;

				if ( $chars.length ) {
					$chars.each(
						( index, element ) => {
							var $thisChar = $( element );

							setTimeout(
								() => {
									$thisChar.animate(
									    animationProps.type,
										animationProps.duration,
										animationProps.easing,
										() => {
											if ( index === charsLength ) {
												if ( 1 === animationProps.repeat ) {
													animationLoop(
													    {
                                                            type: { opacity: 0 },
                                                            duration: 1200,
                                                            easing: 'swing',
                                                            delay: 0,
                                                            repeat: 0,
                                                        }
													);
												} else {
													if ( ! qodefTextualSpinner.windowLoaded ) {
														animationLoop(
														    {
                                                                type: { opacity: 1 },
                                                                duration: 1800,
                                                                easing: 'swing',
                                                                delay: 160,
                                                                repeat: 1,
                                                            }
														);
													} else {
														qodefTextualSpinner.fadeOutLoader(
															$holder,
															600,
															0,
															'swing'
														);

														setTimeout(
															() => {
																var $revSlider = $( '.qodef-after-spinner-rev rs-module' );

																if ( $revSlider.length ) {
																	$revSlider.revstart();
																}
															}, 800
														);
													}
												}
											}
										}
									);
								}, index * animationProps.delay
							);
						}
					);
				}
			}

			animationLoop (
			    {
                    type: { opacity: 1 },
                    duration: 1800,
                    easing: 'swing',
                    delay: 160,
                    repeat: 1,
                }
			);
		},
		fadeOutLoader( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 500;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			if ( $holder.length ) {
				$holder.delay( delay ).fadeOut( speed, easing );

				$( window ).on(
					'bind',
					'pageshow',
					function( event ) {

						if ( event.originalEvent.persisted ) {
							$holder.fadeOut( speed, easing );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_instagram_list = {};

	$( document ).ready(
		function () {
			qodefInstagram.init();
		}
	);

	var qodefInstagram = {
		init: function () {
			this.holder = $( '.qodef-instagram-list #sb_instagram' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {

						if ( $( this ).parent().hasClass( 'qodef-instagram-columns' ) ) {
							var $imagesHolder  = $( this ).find( '#sbi_images' ),
								$images        = $imagesHolder.find( '.sbi_item.sbi_type_image, .sbi_item.sbi_type_carousel' ),
								initialPadding = $imagesHolder.css( 'padding' );

							// remove some unnecessary paddings
							$imagesHolder.css('padding', '0');
							$imagesHolder.css('margin', '-' + initialPadding);
							$imagesHolder.css('width', 'calc(100% + ' + ( initialPadding) + ' + ' + ( initialPadding) + ')');

							$images.attr('style', 'padding: ' + initialPadding + '!important');
						} else if ( $( this ).parent().hasClass( 'qodef-instagram-slider' ) ) {
							qodefInstagram.initSlider( $( this ) );
						}
					}
				);
			}
		},
		initSlider: function ( $currentItem, $initAllItems ) {

			var $imagesHolder  = $currentItem.find( '#sbi_images' ),
				$images        = $currentItem.find( '.sbi_item.sbi_type_image' ),
				initialPadding = $imagesHolder.css( 'padding' );

			// remove some unnecessary paddings
			$imagesHolder.css('padding', '0');
			$images.css('padding', '0');

			// items will inherit this margin
			$imagesHolder.attr('style', 'margin-right: ' + (parseInt( initialPadding ) * 2) + 'px !important');

			var sliderOptions = {};

			sliderOptions.spaceBetween      = parseInt( initialPadding ) * 2;
			sliderOptions.customStages      = true;
			sliderOptions.slidesPerView     = $currentItem.data( 'cols' ) !== undefined && $currentItem.data( 'cols' ) !== '' ? $currentItem.data( 'cols' ) : 3;
			sliderOptions.slidesPerView1024 = $currentItem.data( 'cols' ) !== undefined && $currentItem.data( 'cols' ) !== '' ? $currentItem.data( 'cols' ) : 3;
			sliderOptions.slidesPerView680  = $currentItem.data( 'colstablet' ) !== undefined && $currentItem.data( 'colstablet' ) !== '' ? $currentItem.data( 'colstablet' ) : 2;
			sliderOptions.slidesPerView480  = $currentItem.data( 'colsmobile' ) !== undefined && $currentItem.data( 'colsmobile' ) !== '' ? $currentItem.data( 'colsmobile' ) : 1;

			$currentItem.attr( 'data-options', JSON.stringify(sliderOptions) );

			$imagesHolder.addClass( 'swiper-wrapper' );

			if ( $images.length ) {
				$images.each(
					function () {
						$( this ).addClass( 'qodef-e qodef-image-wrapper swiper-slide' );
					}
				);
			}

			if ( typeof qodef.qodefSwiper === 'object' ) {

				if ( false === $initAllItems ) {
					qodef.qodefSwiper.initSlider( $currentItem );
				} else {
					qodef.qodefSwiper.init( $currentItem );
				}
			}
		},
	};

	qodefCore.shortcodes.corsen_core_instagram_list.qodefInstagram = qodefInstagram;
	qodefCore.shortcodes.corsen_core_instagram_list.qodefSwiper    = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	/*
	 **	Re-init scripts on gallery loaded
	 */
	$( document ).on(
		'yith_wccl_product_gallery_loaded',
		function () {

			if ( typeof qodefCore.qodefWooMagnificPopup === 'function' ) {
				qodefCore.qodefWooMagnificPopup.init();
			}
		}
	);

})( jQuery );

(function ($) {
	'use strict';

	$(document).on(
		'qv_loader_stop qv_variation_gallery_loaded',
		function () {
			qodefYithSelect2.init();
		}
	);

	var qodefYithSelect2 = {
		init: function (settings) {
			this.holder = [];
			this.holder.push(
				{
					holder: $('#yith-quick-view-modal .variations select'),
					options: {
						minimumResultsForSearch: Infinity
					}
				}
			);

			// Allow overriding the default config
			$.extend(this.holder, settings);

			if (typeof this.holder === 'object') {
				$.each(
					this.holder,
					function (key, value) {
						qodefYithSelect2.createSelect2(value.holder, value.options);
					}
				);
			}
		},
		createSelect2: function ($holder, options) {
			if (typeof $holder.select2 === 'function') {
				$holder.select2(options);
			}
		}
	};

})(jQuery);

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_product_category_list                    = {};
	qodefCore.shortcodes.corsen_core_product_category_list.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.corsen_core_product_category_list.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.corsen_core_product_category_list.qodefAppear        = qodefCore.qodefAppear;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'corsen_core_product_list';

	$( document ).on(
		'corsen_trigger_get_new_posts',
		function ( e, $holder, response, nextPage ) {
			if ( $holder.hasClass( 'qodef-woo-product-list' ) ) {
				qodefProductListFilter.init(
					$holder,
					response,
					nextPage
				);
			}
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefProductListFilter.init();
			//qodefProductListFilter.setMasonryMobileHeight();
		}
	);

	$( window ).on(
		'resize',
		function () {
			//qodefProductListFilter.setMasonryMobileHeight();
		}
	);

	var qodefProductListFilter = {
		init: function () {
			var $productList = $( '.qodef-woo-product-list' );

			if ( $productList.length ) {
				$productList.each(
					function () {
						var $thisProductList = $( this ),
							$fields			 = [];

						$fields.$orderbyFields 		 = $productList.find( '.qodef-ordering-filter-link' );
						$fields.orderbyFieldsExists  = $fields.$orderbyFields.length;
						$fields.$categoryFields 	 = $productList.find( '.qodef-category-filter-link' );
						$fields.categoryFieldsExists = $fields.$categoryFields.length;
						$fields.$priceFields         = $productList.find( '.qodef-price-filter-link' );
						$fields.priceFieldsExists    = $fields.$priceFields.length;

						qodefProductListFilter.initFilter( $thisProductList, $fields );
					}
				);
			}
		},
		initFilter: function( $list, $fields ) {
			var links  = $list.find( '.qodef-category-filter-link, .qodef-ordering-filter-link, .qodef-price-filter-link' ),
				filter = $list.find( '.qodef-order-price-filter' );

			filter.on(
				'mouseenter',
				function() {
					qodefCore.body.addClass( 'qodef-dropdown-menu-opened' );
				}
			).on(
				'mouseleave',
				function() {
					qodefCore.body.removeClass( 'qodef-dropdown-menu-opened' );
				}
			);

			links.on(
				'click',
				function(e) {
					e.preventDefault();
					e.stopPropagation();

					var clickedLink = $( this );
					if ( ! clickedLink.hasClass( 'qodef--active' ) ) {

						clickedLink.addClass( 'qodef--active' );
						clickedLink.parent().siblings().find( 'a' ).removeClass( 'qodef--active' );

						var options    = $list.data( 'options' ),
							newOptions = {};

						if ($fields.orderbyFieldsExists) {
							$fields.$orderbyFields.each(
								function () {
									if ( $( this ).hasClass( 'qodef--active' ) ) {
										var orderKey = 'order_by',
											value    = $( this ).data( 'ordering' );

										if (typeof value !== "undefined" && value !== "") {
											newOptions[orderKey] = value;
										} else {
											newOptions[orderKey] = '';
										}
									}
								}
							);
						}

						if ($fields.categoryFieldsExists) {
							$fields.$categoryFields.each(
								function () {
									if ( $( this ).hasClass( 'qodef--active' ) ) {
										var categoryKey = 'category',
											value 		= $( this ).data( 'category' );

										if (typeof value !== "undefined" && value !== "") {
											if ( value.indexOf( ',' ) !== -1 ) {
												value = value.split( ',' );
												newOptions[categoryKey] = value;
											} else {
												newOptions[categoryKey] = value;
											}
										} else {
											newOptions[categoryKey] = '';
										}
									}
								}
							);
						}

						if ($fields.priceFieldsExists) {
							$fields.$priceFields.each(
								function () {
									if ( $( this ).hasClass( 'qodef--active' ) ) {

										var mainParent   = $( this ).parents( '.qodef-filter-price' ),
											orderKey     = 'price',
											value        = $( this ).data( 'price' );

										newOptions['price-range'] = mainParent.data( 'range' );

										if (typeof value !== "undefined" && value !== "") {
											newOptions[orderKey] = value;
										} else {
											newOptions[orderKey] = '';
										}
									}
								}
							);
						}

						var additional = qodefProductListFilter.createAdditionalQuery( newOptions );

						$.each(
							additional,
							function (key, value) {
								options[key] = value;
							}
						);

						$list.data( 'options',options );

						qodef.body.trigger( 'corsen_trigger_load_more', [$list, 1] );

					}
				}
			);
		},
		createAdditionalQuery: function( newOptions ){
			var addQuery 		= {},
				taxQueryOptions = {},
				categories 		= $( '.qodef-category-filter-link' ),
				i               = 0;

			addQuery.additional_query_args 			  = {};
			addQuery.additional_query_args.tax_query  = [];
			addQuery.additional_query_args.meta_query = {};

			if (typeof newOptions === 'object') {
				$.each(
					newOptions,
					function ( key, value ) {

						switch (key) {
							case 'order_by':
								addQuery.orderby = newOptions.order_by;
								break;
							case 'category':
								taxQueryOptions = {
									0: {
										taxonomy: 'product_cat',
										field: typeof value === 'number' ? 'term_id' : 'slug',
										terms: value,
									}
								};
								break;
							case 'price':
								if ( value !== '' ) {
									addQuery.additional_query_args.meta_query['value' + i]         = {};
									addQuery.additional_query_args.meta_query['value' + i].key     = '_price';
									addQuery.additional_query_args.meta_query['value' + i].value   = [parseInt( value ), parseInt( value ) + newOptions['price-range']];
									addQuery.additional_query_args.meta_query['value' + i].compare = 'BETWEEN';
									addQuery.additional_query_args.meta_query['value' + i].type    = 'NUMERIC';
									i++;
								}
								break;
						}
					}
				);

				if ( Object.entries( addQuery.additional_query_args.meta_query ).length > 1 ) {
					addQuery.additional_query_args.meta_query['relation'] = 'OR';
				}

				if ( categories.length && taxQueryOptions[0].terms.length > 0 ) {
					addQuery.additional_query_args.tax_query = taxQueryOptions;
				}
			}

			return addQuery;
		},
		setMasonryMobileHeight: function() {
			var $productList = $( '.qodef-woo-product-list' );

			if ( $productList.length ) {
				$productList.each(
					function () {
						var $thisProductList = $( this );

						if ( $thisProductList.hasClass( "qodef-layout--masonry" ) ) {

							var options      = $thisProductList.data( 'options' ),
								mobileHeight = options['product_list_masonry_mobile_height'];

							if ( mobileHeight.length ) {
								$thisProductList.find( '.qodef-grid-item' ).each(
									function () {
										if ( qodefCore.windowWidth <= 480 ) {
											$( this ).css(
												'min-height',
												mobileHeight
											);
										} else {
											$( this ).css(
												'min-height',
												''
											);
										}
									}
								);
							}
						}
					}
				);
			}
		},
	};

	qodefCore.shortcodes[shortcode]                        = {};
	qodefCore.shortcodes[shortcode].qodefProductListFilter = qodefProductListFilter;

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'corsen_core_product_list_indent_slider';

	$( document ).ready(
		function () {
			qodefProductListIndentSlider.init();
		}
	);

	var qodefProductListIndentSlider = {
		init: function () {
			this.holder = $( '.qodef-woo-product-list.qodef-layout--indent-slider .qodef-fixed-indent-slider-holder' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefProductListIndentSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var sliderOptions     = typeof $holder.data( 'options' ) !== 'undefined' ? $holder.data( 'options' ) : {},
				sliderScroll      = sliderOptions.sliderScroll !== undefined && sliderOptions.sliderScroll !== 'no' ? sliderOptions.sliderScroll : false,
				loop              = sliderOptions.loop !== undefined && sliderOptions.loop !== '' ? sliderOptions.loop : true,
				autoplay          = sliderOptions.autoplay !== undefined && sliderOptions.autoplay !== '' ? sliderOptions.autoplay : true,
				speed             = sliderOptions.speed !== undefined && sliderOptions.speed !== '' ? parseInt( sliderOptions.speed, 10 ) : 5000,
				speedAnimation    = sliderOptions.speedAnimation !== undefined && sliderOptions.speedAnimation !== '' ? parseInt( sliderOptions.speedAnimation, 10 ) : 800,
				slideAnimation    = sliderOptions.slideAnimation !== undefined && sliderOptions.slideAnimation !== '' ? sliderOptions.slideAnimation : '',
				outsideNavigation = sliderOptions.outsideNavigation !== undefined && sliderOptions.outsideNavigation === 'yes',
				nextNavigation    = outsideNavigation ? '.swiper-button-next-' + sliderOptions.unique : $holder.parent('.qodef-right-slider').prev('.qodef-left-info').find( '.swiper-button-next' ),
				prevNavigation    = outsideNavigation ? '.swiper-button-prev-' + sliderOptions.unique : $holder.parent('.qodef-right-slider').prev('.qodef-left-info').find( '.swiper-button-prev' );

			if ( autoplay !== false && speed !== 5000 ) {
				autoplay = {
					delay: speed,
				};
			}

			var $swiperHolder 	  = $holder.find( '.qodef-m-swiper' ),
				$sliderHolder 	  = $holder.find( '.qodef-m-items' ),
				$pagination   	  = $holder.find( '.swiper-pagination' ),
				slidesPerView 	  = 2.27,
				slidesPerView1440 = 2.27,
				slidesPerView1368 = 2.27,
				slidesPerView1366 = 2.27,
				slidesPerView1280 = 2.27,
				slidesPerView1024 = 1.26,
				slidesPerView834  = 1.26,
				slidesPerView768  = 1.26,
				slidesPerView680  = 1,
				slidesPerView480  = 1;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: false,
					spaceBetween: 40,
					// autoplay: autoplay,
					autoplay: false,
					loop: loop,
					speed: speedAnimation,
					navigation: { nextEl: nextNavigation, prevEl: prevNavigation },
					pagination: {
						el: $pagination,
						type: 'bullets',
						clickable: true,
					},
					breakpoints: {
						// when window width is < 481px
						0: {
							slidesPerView: slidesPerView480
						},
						// when window width is >= 481px
						481: {
							slidesPerView: slidesPerView680
						},
						// when window width is >= 681px
						681: {
							slidesPerView: slidesPerView768
						},
						// when window width is >= 769px
						769: {
							slidesPerView: slidesPerView834
						},
						// when window width is >= 835px
						835: {
							slidesPerView: slidesPerView1024
						},
						// when window width is >= 1025px
						1025: {
							slidesPerView: slidesPerView1280
						},
						// when window width is >= 1281px
						1281: {
							slidesPerView: slidesPerView1366
						},
						// when window width is >= 1367px
						1367: {
							slidesPerView: slidesPerView1368
						},
						// when window width is >= 1369px
						1369: {
							slidesPerView: slidesPerView1440
						},
						// when window width is >= 1441px
						1441: {
							slidesPerView: slidesPerView
						}
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									$sliderHolder.addClass( 'qodef-swiper--initialized' );
								},
								1500
							);

							if ( sliderScroll ) {
								var scrollStart = false;

								$sliderHolder.on(
									'mousewheel',
									function ( e ) {
										e.preventDefault();

										if ( ! scrollStart ) {
											scrollStart = true;

											if ( e.deltaY < 0 ) {
												$swiper.slideNext();
											} else {
												$swiper.slidePrev();
											}

											setTimeout(
												function () {
													scrollStart = false;
												},
												1000
											);
										}
									}
								);
							}
						}
					},
				}
			);
		}
	};

	qodefCore.shortcodes[shortcode]                        		 = {};
	qodefCore.shortcodes[shortcode].qodefProductListIndentSlider = qodefProductListIndentSlider;

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefDropDownCart.init();
		}
	);

	var qodefDropDownCart = {
		init: function () {
			var $holder = $( '.qodef-widget-dropdown-cart-content' );

			if ( $holder.length ) {
				$holder.off().each(
					function () {
						var $thisHolder = $( this );

						qodefDropDownCart.trigger( $thisHolder );

						qodefCore.body.on(
							'added_to_cart removed_from_cart',
							function () {
								qodefDropDownCart.init();
							}
						);
					}
				);
			}
		},
		trigger: function ( $holder ) {
			var $items = $holder.find( '.qodef-woo-mini-cart' );
			if ( $items.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $items );
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaCart.init();
		}
	);

	var qodefSideAreaCart = {
		init: function () {
			var $holder = $( '.qodef-widget-side-area-cart-inner' );

			if ( $holder.length ) {
				$holder.off().each(
					function () {
						var $thisHolder = $( this );

						if ( qodefCore.windowWidth > 680 ) {
							qodefSideAreaCart.trigger( $thisHolder );
							qodefSideAreaCart.start( $thisHolder );

							qodefCore.body.on(
								'added_to_cart removed_from_cart',
								function () {
									qodefSideAreaCart.init();
								}
							);
						}
					}
				);
			}
		},
		trigger: function ( $holder ) {
			var $items = $holder.find( '.qodef-woo-side-area-cart' );
			if ( $items.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $items );
			}
		},
		start: function ( $holder ) {
			$holder.on(
				'click',
				'.qodef-m-opener',
				function ( e ) {
					e.preventDefault();

					if ( ! $holder.hasClass( 'qodef--opened' ) ) {
						qodefSideAreaCart.openSideArea( $holder );
						qodefSideAreaCart.trigger( $holder );

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideAreaCart.closeSideArea( $holder );
								}
							}
						);
					} else {
						qodefSideAreaCart.closeSideArea( $holder );
					}
				}
			);

			$holder.on(
				'click',
				'.qodef-m-close',
				function ( e ) {
					e.preventDefault();
					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		openSideArea: function ( $holder ) {
			qodefCore.qodefScroll.disable();

			$holder.addClass( 'qodef--opened' );
			$( '#qodef-page-wrapper' ).prepend( '<div class="qodef-woo-side-area-cart-cover"/>' );

			$( '.qodef-woo-side-area-cart-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();

					qodefSideAreaCart.closeSideArea( $holder );
				}
			);
		},
		closeSideArea: function ( $holder ) {
			if ( $holder.hasClass( 'qodef--opened' ) ) {
				qodefCore.qodefScroll.enable();

				$holder.removeClass( 'qodef--opened' );
				$( '.qodef-woo-side-area-cart-cover' ).remove();
			}
		}
	};

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_clients_list = {};

	$( window ).load(
		function () {
			qodefVideoInfoSlider.init();
		}
	);

	var qodefVideoInfoSlider = {
		init: function () {
			this.holder = $( '.qodef-clients-list.qodef-layout--video-info-slider' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this );

						qodefVideoInfoSlider.initItem( $thisHolder );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var sliderOptions     = typeof $holder.data( 'options' ) !== 'undefined' ? $holder.data( 'options' ) : {},
				sliderScroll      = sliderOptions.sliderScroll !== undefined && sliderOptions.sliderScroll !== '' ? sliderOptions.sliderScroll : false,
				loop              = sliderOptions.loop !== undefined && sliderOptions.loop !== '' ? sliderOptions.loop : true,
				autoplay          = sliderOptions.autoplay !== undefined && sliderOptions.autoplay !== '' ? sliderOptions.autoplay : false,
				speed             = sliderOptions.speed !== undefined && sliderOptions.speed !== '' ? parseInt( sliderOptions.speed, 10 ) : 5000,
				speedAnimation    = sliderOptions.speedAnimation !== undefined && sliderOptions.speedAnimation !== '' ? parseInt( sliderOptions.speedAnimation, 10 ) : 800,
				slideAnimation    = sliderOptions.slideAnimation !== undefined && sliderOptions.slideAnimation !== '' ? sliderOptions.slideAnimation : '';

			if ( autoplay !== false && speed !== 5000 ) {
				autoplay = {
					delay: speed
				};
			}

			var $swiperHolderTop  = $holder.find( '.qodef-images-holder' ),
				$paginationTop    = $holder.find( '.qodef-images-holder .swiper-pagination' ),
				slidesPerView 	   = 1;

			var $swiperTop = new Swiper(
				$swiperHolderTop,
				{
					direction: 'horizontal',
					effect: 'fade',
					fadeEffect: {
						crossFade: true
					},
					runCallbacksOnInit: true,
					slidesPerView: slidesPerView,
					centeredSlides: false,
					spaceBetween: 0,
					sliderScroll: sliderScroll,
					autoplay: autoplay,
					loop: loop,
					loopedSlides: 4,
					speed: speedAnimation,
					/*pagination: {
						el: $paginationTop,
						type: 'bullets',
						clickable: true,
					},*/
					on: {
						init: function () {
							setTimeout(
								function () {
									if ( ! $holder.hasClass( 'qodef-swiper--initialized' ) ) {
										$holder.addClass( 'qodef-swiper--initialized' );
									}
								},
								1500
							);
						}
					},
				}
			);

			var $swiperHolderBottom  = $holder.find( '.qodef-thumbnails-holder' ),
				$paginationBottom    = $holder.find( '.qodef-thumbnails-holder .swiper-pagination' ),
				nextNavigationBottom = $swiperHolderBottom.find( '.swiper-button-next' ),
				prevNavigationBottom = $swiperHolderBottom.find( '.swiper-button-prev' ),
				slidesPerViewBottom	 = 7,
				slidesPerView1440Bottom = 5,
				slidesPerView1368Bottom = 5,
				slidesPerView1366Bottom = 5,
				slidesPerView1280Bottom = 5,
				slidesPerView1024Bottom = 3,
				slidesPerView768Bottom  = 3,
				slidesPerView680Bottom  = 1,
				slidesPerView480Bottom  = 1;

			var $swiperBottom = new Swiper(
				$swiperHolderBottom,
				{
					direction: 'horizontal',
					runCallbacksOnInit: true,
					slidesPerView: slidesPerViewBottom,
					centeredSlides: true,
					spaceBetween: 69,
					sliderScroll: sliderScroll,
					touchRatio: 0.2,
					slideToClickedSlide: true,
					autoplay: false, // induct option controll here
					loop: loop,
					loopedSlides: 4,
					speed: speedAnimation,
					//navigation: { nextEl: nextNavigationBottom, prevEl: prevNavigationBottom },
					/*pagination: {
						el: $paginationBottom,
						type: 'bullets',
						clickable: true,
					},*/
					breakpoints: {
						// when window width is < 481px
						0: {
							slidesPerView: slidesPerView480Bottom
						},
						// when window width is >= 481px
						481: {
							slidesPerView: slidesPerView680Bottom
						},
						// when window width is >= 681px
						681: {
							slidesPerView: slidesPerView768Bottom
						},
						// when window width is >= 769px
						769: {
							slidesPerView: slidesPerView1024Bottom
						},
						// when window width is >= 1025px
						1025: {
							slidesPerView: slidesPerView1280Bottom
						},
						// when window width is >= 1281px
						1281: {
							slidesPerView: slidesPerView1366Bottom
						},
						// when window width is >= 1367px
						1367: {
							slidesPerView: slidesPerView1368Bottom
						},
						// when window width is >= 1369px
						1369: {
							slidesPerView: slidesPerView1440Bottom
						},
						// when window width is >= 1441px
						1441: {
							slidesPerView: slidesPerViewBottom
						}
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									if ( ! $holder.hasClass( 'qodef-swiper--initialized' ) ) {
										$holder.addClass( 'qodef-swiper--initialized' );
									}
								},
								1500
							);
						}
					},
				}
			);

			$swiperTop.controller.control = $swiperBottom;
			$swiperBottom.controller.control = $swiperTop;
		}
	};

	qodefCore.shortcodes.corsen_core_clients_list.qodefVideoInfoSlider = qodefVideoInfoSlider;
	qodefCore.shortcodes.corsen_core_clients_list.qodefSwiper 		 = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'corsen_core_portfolio_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'corsen_core_team_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.corsen_core_testimonials_list = {};

	$( window ).load(
		function () {
			qodefTestimonialsSliderPredefined.init();
		}
	);

	var qodefTestimonialsSliderPredefined = {
		init: function () {
			this.holder = $( '.qodef-testimonials-list.qodef-hide-client-images--no.qodef-swiper-container.qodef-col-num--1' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this );

						qodefTestimonialsSliderPredefined.initItem( $thisHolder );
					}
				);
			}
		},
		initItem: function ( $holder ) {
			var sliderOptions  = typeof $holder.data( 'options' ) !== 'undefined' ? $holder.data( 'options' ) : {},
				sliderScroll   = sliderOptions.sliderScroll !== undefined && sliderOptions.sliderScroll !== '' ? sliderOptions.sliderScroll : false,
				loop           = sliderOptions.loop !== undefined && sliderOptions.loop !== '' ? sliderOptions.loop : true,
				autoplay       = sliderOptions.autoplay !== undefined && sliderOptions.autoplay !== '' ? sliderOptions.autoplay : true,
				speed          = sliderOptions.speed !== undefined && sliderOptions.speed !== '' ? parseInt( sliderOptions.speed, 10 ) : 5000,
				speedAnimation = sliderOptions.speedAnimation !== undefined && sliderOptions.speedAnimation !== '' ? parseInt( sliderOptions.speedAnimation, 10 ) : 1200,
				slideAnimation = sliderOptions.slideAnimation !== undefined && sliderOptions.slideAnimation !== '' ? sliderOptions.slideAnimation : '';

			if ( autoplay !== false && speed !== 5000 ) {
				autoplay = {
					delay: speed
				};
			} else if ( autoplay !== false ) {
				autoplay = {
					disableOnInteraction: false
				}
			}

			var $swiperHolderTop  = $holder.find( '.qodef-text-holder' ),
				nextNavigationTop = $holder.find( '.swiper-button-next' ),
				prevNavigationTop = $holder.find( '.swiper-button-prev' ),
				paginationTop     = $holder.find( '.swiper-pagination' ),
				slidesPerView     = 1;

			var $swiperTop = new Swiper(
				$swiperHolderTop,
				{
					direction: 'horizontal',
					effect: slideAnimation,
					fadeEffect: {
						crossFade: true
					},
					runCallbacksOnInit: true,
					slidesPerView: slidesPerView,
					centeredSlides: false,
					spaceBetween: 0,
					sliderScroll: sliderScroll,
					autoplay: autoplay,
					loop: loop,
					loopedSlides: 4,
					speed: speedAnimation,
					navigation: { nextEl: nextNavigationTop, prevEl: prevNavigationTop },
					pagination: { el: paginationTop, type: 'bullets', clickable: true },
					on: {
						init: function () {
							setTimeout(
								function () {
									if ( ! $holder.hasClass( 'qodef-swiper--initialized' ) ) {
										$holder.addClass( 'qodef-swiper--initialized' );
									}
								},
								1500
							);
						}
					},
				}
			);

			var $swiperHolderBottom     = $holder.find( '.qodef-thumbnails-holder' ),
				slidesPerViewBottom     = 5,
				slidesPerView1440Bottom = 5,
				slidesPerView1368Bottom = 5,
				slidesPerView1366Bottom = 5,
				slidesPerView1280Bottom = 5,
				slidesPerView1024Bottom = 3,
				slidesPerView768Bottom  = 3,
				slidesPerView680Bottom  = 1,
				slidesPerView480Bottom  = 1;

			var $swiperBottom = new Swiper(
				$swiperHolderBottom,
				{
					direction: 'horizontal',
					runCallbacksOnInit: true,
					slidesPerView: slidesPerViewBottom,
					centeredSlides: true,
					spaceBetween: 69,
					sliderScroll: sliderScroll,
					touchRatio: 0.2,
					slideToClickedSlide: true,
					autoplay: false, // induct option controll here
					loop: loop,
					loopedSlides: 4,
					speed: speedAnimation,
					breakpoints: {
						// when window width is < 481px
						0: {
							slidesPerView: slidesPerView480Bottom
						},
						// when window width is >= 481px
						481: {
							slidesPerView: slidesPerView680Bottom
						},
						// when window width is >= 681px
						681: {
							slidesPerView: slidesPerView768Bottom
						},
						// when window width is >= 769px
						769: {
							slidesPerView: slidesPerView1024Bottom
						},
						// when window width is >= 1025px
						1025: {
							slidesPerView: slidesPerView1280Bottom
						},
						// when window width is >= 1281px
						1281: {
							slidesPerView: slidesPerView1366Bottom
						},
						// when window width is >= 1367px
						1367: {
							slidesPerView: slidesPerView1368Bottom
						},
						// when window width is >= 1369px
						1369: {
							slidesPerView: slidesPerView1440Bottom
						},
						// when window width is >= 1441px
						1441: {
							slidesPerView: slidesPerViewBottom
						}
					},
					on: {
						init: function () {
							setTimeout(
								function () {
									if ( ! $holder.hasClass( 'qodef-swiper--initialized' ) ) {
										$holder.addClass( 'qodef-swiper--initialized' );
									}
								},
								1500
							);
						}
					},
				}
			);

			$swiperTop.controller.control    = $swiperBottom;
			$swiperBottom.controller.control = $swiperTop;
		}
	};

	qodefCore.shortcodes.corsen_core_testimonials_list.qodefSwiper                       = qodef.qodefSwiper;
	qodefCore.shortcodes.corsen_core_testimonials_list.qodefTestimonialsSliderPredefined = qodefTestimonialsSliderPredefined;
})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseInteractiveList.init();
		}
	);

	var qodefInteractiveLinkShowcaseInteractiveList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--interactive-list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseInteractiveList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $links            = $currentItem.find( '.qodef-m-item' ),
				x                 = 0,
				y                 = 0,
				currentXCPosition = 0,
				currentYCPosition = 0;

			if ( $links.length ) {
				$links.on(
					'mouseenter',
					function () {
						$links.removeClass( 'qodef--active' );
						$( this ).addClass( 'qodef--active' );
					}
				).on(
					'mousemove',
					function ( event ) {
						var $thisLink         = $( this ),
							$followInfoHolder = $thisLink.find( '.qodef-e-follow-content' ),
							$followImage      = $followInfoHolder.find( '.qodef-e-follow-image' ),
							$followImageItem  = $followImage.find( 'img' ),
							followImageWidth  = $followImageItem.width(),
							followImagesCount = parseInt( $followImage.data( 'images-count' ), 10 ),
							followImagesSrc   = $followImage.data( 'images' ),
							$followTitle      = $followInfoHolder.find( '.qodef-e-follow-title' ),
							itemWidth         = $thisLink.outerWidth(),
							itemHeight        = $thisLink.outerHeight(),
							itemOffsetTop     = $thisLink.offset().top - qodefCore.scroll,
							itemOffsetLeft    = $thisLink.offset().left;

						x = (event.clientX - itemOffsetLeft) >> 0;
						y = (event.clientY - itemOffsetTop) >> 0;

						if ( x > itemWidth ) {
							currentXCPosition = itemWidth;
						} else if ( x < 0 ) {
							currentXCPosition = 0;
						} else {
							currentXCPosition = x;
						}

						if ( y > itemHeight ) {
							currentYCPosition = itemHeight;
						} else if ( y < 0 ) {
							currentYCPosition = 0;
						} else {
							currentYCPosition = y;
						}

						if ( followImagesCount > 1 ) {
							var imagesUrl    = followImagesSrc.split( '|' ),
								itemPartSize = itemWidth / followImagesCount;

							$followImageItem.removeAttr( 'srcset' );

							if ( currentXCPosition < itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[0] );
							}

							// -2 is constant - to remove first and last item from the loop
							for ( var index = 1; index <= (followImagesCount - 2); index++ ) {
								if ( currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1) ) {
									$followImageItem.attr( 'src', imagesUrl[index] );
								}
							}

							if ( currentXCPosition >= itemWidth - itemPartSize ) {
								$followImageItem.attr( 'src', imagesUrl[followImagesCount - 1] );
							}
						}

						$followImage.css(
							{
								'top': itemHeight / 2,
							}
						);
						$followTitle.css(
							{
								'transform': 'translateY(' + -(parseInt( itemHeight, 10 ) / 2 + currentYCPosition) + 'px)',
								'left': -(currentXCPosition - followImageWidth / 2),
							}
						);
						$followInfoHolder.css( { 'top': currentYCPosition, 'left': currentXCPosition } );
					}
				).on(
					'mouseleave',
					function () {
						$links.removeClass( 'qodef--active' );
					}
				);
			}

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.corsen_core_interactive_link_showcase.qodefInteractiveLinkShowcaseInteractiveList = qodefInteractiveLinkShowcaseInteractiveList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseList.init();
		}
	);

	var qodefInteractiveLinkShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseList.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' ),
				$links  = $currentItem.find( '.qodef-m-item' );

			$images.eq( 0 ).addClass( 'qodef--active' );
			$links.eq( 0 ).addClass( 'qodef--active' );

			$links.on(
				'touchstart mouseenter',
				function ( e ) {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						e.preventDefault();
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			).on(
				'touchend mouseleave',
				function () {
					var $thisLink = $( this );

					if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
						$links.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
						$images.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
					}
				}
			);

			$currentItem.addClass( 'qodef--init' );
		},
	};

	qodefCore.shortcodes.corsen_core_interactive_link_showcase.qodefInteractiveLinkShowcaseList = qodefInteractiveLinkShowcaseList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseSlider.init();
		}
	);

	var qodefInteractiveLinkShowcaseSlider = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--slider' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefInteractiveLinkShowcaseSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $images = $currentItem.find( '.qodef-m-image' );

			var $swiperSlider = new Swiper(
				$currentItem.find( '.swiper-container' ),
				{
					loop: true,
					slidesPerView: 'auto',
					centeredSlides: true,
					speed: 1400,
					mousewheel: true,
					init: false
				}
			);
			qodef.qodefWaitForImages.check(
				$currentItem,
				function () {
					$swiperSlider.init();
				}
			);

			$swiperSlider.on(
				'init',
				function () {
					$images.eq( 0 ).addClass( 'qodef--active' );
					$currentItem.find( '.swiper-slide-active' ).addClass( 'qodef--active' );

					$swiperSlider.on(
						'slideChangeTransitionStart',
						function () {
							var $swiperSlides    = $currentItem.find( '.swiper-slide' ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							$images.removeClass( 'qodef--active' ).eq( $activeSlideItem.data( 'swiper-slide-index' ) ).addClass( 'qodef--active' );
							$swiperSlides.removeClass( 'qodef--active' );

							$activeSlideItem.addClass( 'qodef--active' );
						}
					);

					$currentItem.find( '.swiper-slide' ).on(
						'click',
						function ( e ) {
							var $thisSwiperLink  = $( this ),
								$activeSlideItem = $currentItem.find( '.swiper-slide-active' );

							if ( ! $thisSwiperLink.hasClass( 'swiper-slide-active' ) ) {
								e.preventDefault();
								e.stopImmediatePropagation();

								if ( e.pageX < $activeSlideItem.offset().left ) {
									$swiperSlider.slidePrev();
									return false;
								}

								if ( e.pageX > $activeSlideItem.offset().left + $activeSlideItem.outerWidth() ) {
									$swiperSlider.slideNext();
									return false;
								}
							}
						}
					);

					$currentItem.addClass( 'qodef--init' );
				}
			);
		},
	};

	qodefCore.shortcodes.corsen_core_interactive_link_showcase.qodefInteractiveLinkShowcaseSlider = qodefInteractiveLinkShowcaseSlider;

})( jQuery );

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
