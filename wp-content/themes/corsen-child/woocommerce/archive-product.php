<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>
<div class="qodef-page-title qodef-m qodef-title--standard qodef-alignment--left qodef-vertical-alignment--header-bottom">
		<div class="qodef-m-inner">
		<div class="qodef-m-content qodef-content-full-width ">
	<h6 class="qodef-m-title entry-title">
		Contemporary Vintage	</h6>
	</div>
	</div>
	</div>

<div id="qodef-page-inner" class="qodef-content-grid">
<main id="qodef-page-content" class="qodef-grid qodef-layout--template " role="main">
	<div class="qodef-grid-inner">
		<div class="qodef-grid-item qodef-page-content-section qodef-col--12 qodef-col--content">
			<div data-elementor-type="wp-page" data-elementor-id="5307" class="elementor elementor-5307">
									<section class="elementor-section elementor-top-section elementor-element elementor-element-4952c17 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="4952c17" data-element_type="section">
						<div class="elementor-container elementor-column-gap-no">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e0e2581" data-id="e0e2581" data-element_type="column">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-312765a elementor-widget elementor-widget-qi_addons_for_elementor_section_title" data-id="312765a" data-element_type="widget" data-widget_type="qi_addons_for_elementor_section_title.default">
				<div class="elementor-widget-container">
			<div class="qodef-shortcode qodef-m  qodef-qi-section-title  qodef-decoration--italic   qodef-subtitle-icon--left">
						<h1 class="qodef-m-title">
		Buy it.<br>  Wear it for a long time.<br>  If you want it.<br>  We can find it.	</h1>
			</div>
		</div>
				</div>
					</div>
		</div>
							</div>
		</section>
				
				<section class="elementor-section elementor-top-section elementor-element elementor-element-6a5b7b3 elementor-section-full_width elementor-section-stretched elementor-section-content-middle elementor-section-height-default elementor-section-height-default" data-id="6a5b7b3" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}" style="width: 1585px; left: 0px;">
						<div class="elementor-container elementor-column-gap-no">
					<div class="make-column-clickable-elementor elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5b88c81" style="cursor: pointer;" data-column-clickable="https://byronesque.comcontact/" data-column-clickable-blank="_self" data-id="5b88c81" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-12ab9a4 elementor-widget__width-inherit elementor-widget elementor-widget-qi_addons_for_elementor_text_marquee" data-id="12ab9a4" data-element_type="widget" data-widget_type="qi_addons_for_elementor_text_marquee.default">
				<div class="elementor-widget-container">
			<div class="qodef-shortcode qodef-m ticker qodef-qi-text-marquee qodef-layout--default ">
	<div class="qodef-m-content">
		<div class="qodef-m-text qodef-text--original">
							<span class="qodef-m-text-item elementor-repeater-item-9e2a07c">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-cd6c28c">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-5a56a34">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-8eaed0a">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-a4b1bee">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-b2130be">ASK US QUESTIONS OR SELL WITH US</span>
                					</div>
		<div class="qodef-m-text qodef-text--copy">
							<span class="qodef-m-text-item elementor-repeater-item-9e2a07c">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-cd6c28c">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-5a56a34">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-8eaed0a">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-a4b1bee">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-b2130be">ASK US QUESTIONS OR SELL WITH US</span>
                					</div>
	</div>
</div>
		</div>
				</div>
					</div>
		</div>
							</div>
		</section>
							</div>
		</div>
	</div>
</main>
			</div>
<?php
// this is from custom plugin
echo do_shortcode('[shop-filters]');
?>

<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>


<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>
<section class="elementor-section elementor-top-section elementor-element elementor-element-6a5b7b3 elementor-section-full_width elementor-section-stretched elementor-section-content-middle elementor-section-height-default elementor-section-height-default" data-id="6a5b7b3" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}" style="width: 1585px; left: 0px;">
						<div class="elementor-container elementor-column-gap-no">
					<div class="make-column-clickable-elementor elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5b88c81" style="cursor: pointer;" data-column-clickable="https://byronesque.comcontact/" data-column-clickable-blank="_self" data-id="5b88c81" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
			<div class="elementor-widget-wrap elementor-element-populated">
								<div class="elementor-element elementor-element-12ab9a4 elementor-widget__width-inherit elementor-widget elementor-widget-qi_addons_for_elementor_text_marquee" data-id="12ab9a4" data-element_type="widget" data-widget_type="qi_addons_for_elementor_text_marquee.default">
				<div class="elementor-widget-container">
			<div class="qodef-shortcode qodef-m ticker qodef-qi-text-marquee qodef-layout--default ">
	<div class="qodef-m-content">
		<div class="qodef-m-text qodef-text--original">
							<span class="qodef-m-text-item elementor-repeater-item-9e2a07c">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-cd6c28c">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-5a56a34">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-8eaed0a">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-a4b1bee">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-b2130be">ASK US QUESTIONS OR SELL WITH US</span>
                					</div>
		<div class="qodef-m-text qodef-text--copy">
							<span class="qodef-m-text-item elementor-repeater-item-9e2a07c">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-cd6c28c">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-5a56a34">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-8eaed0a">ASK US QUESTIONS OR SELL WITH US</span>
                							<span class="qodef-m-text-item elementor-repeater-item-a4b1bee">contact  us</span>
                							<span class="qodef-m-text-item elementor-repeater-item-b2130be">ASK US QUESTIONS OR SELL WITH US</span>
                					</div>
	</div>
</div>
		</div>
				</div>
					</div>
		</div>
							</div>
		</section>
<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
