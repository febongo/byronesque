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
