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
