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
