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
