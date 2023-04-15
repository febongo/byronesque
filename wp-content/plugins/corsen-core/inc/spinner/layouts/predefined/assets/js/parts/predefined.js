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
