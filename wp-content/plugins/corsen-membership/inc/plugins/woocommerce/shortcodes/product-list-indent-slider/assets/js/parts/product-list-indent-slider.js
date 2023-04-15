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
