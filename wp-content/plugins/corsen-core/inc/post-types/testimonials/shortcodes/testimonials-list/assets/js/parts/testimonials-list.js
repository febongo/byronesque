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
