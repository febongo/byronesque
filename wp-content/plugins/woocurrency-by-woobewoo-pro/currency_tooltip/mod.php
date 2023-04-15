<?php
class currency_tooltipWcu extends moduleWcu
{
    public $options;
    public function init() {
        parent::init();
        $this->options = frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();
        add_action('wp_footer', array($this, 'drawCurrencyTooltip'));
    }
    public function addTooltipHiddenField($pricevar) {
        if (!is_admin() && isset($this->options['currency_tooltip']['design_tab']['enable']) && $this->options['currency_tooltip']['design_tab']['enable'] === '1' ) {
    		add_filter('woocommerce_currency_symbol', function($content) use($pricevar) {
    			$wcuDefaultPrice = '<span class="wcuCurrencyTooltipDefaultPrice" data-wcuDefaultPrice="'.$pricevar.'"></span>';
    			if (strpos($content, 'wcuCurrencyTooltipDefaultPrice')) {
    				$content = preg_replace('~<s.+?n>~', $wcuDefaultPrice, $content, 1);
    				return $content;
    			}
    			else {
    				return $wcuDefaultPrice.$content;
    			}
    		}, 99999);
        }
	}
    public function drawCurrencyTooltip() {
        $this->getView()->getCurrencyTooltip();
    }
    public function getDefaultOptions() {
        return array(
            'design_tab' => array(
                'enable' => '0',
                'ct_side' => 'top',
                'ct_text_color' => '#ffffff',
                'ct_text_size' => '14',
                'ct_bg_color' => '#1e73be',
                'ct_show_border' => '1',
                'ct_border_radius' => '4',
                'ct_border_radius_dimension' => 'px',
                'ct_border_color' => '#0b6bbf',
            ),
            'display_rules_tab' => array(
                'show_on' => 'both',
                'show_on_screen' => '0',
                'show_on_screen_compare' => 'more',
                'show_on_screen_value' => '760',
                'display_by_default' => 'enable',
                'pages_to_show' => array(),
                'product_categories_to_show' => array(),
                'custom_post_types_to_show' => array(),
				'pages_to_show_checkbox' => '0',
                'product_categories_to_show_checkbox' => '0',
                'custom_post_types_to_show_checkbox' => '0',
            ),
        );
    }
    public function getOptionsParams() {
        // to find params description and hooks @see currencyWcu::getOptionsParams
        return array(
            'design_tab' => array(
                'enable' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Currency Tooltip allows you to show price cost of product by other currencies.', WCU_LANG_CODE),
                    'label' => __('Enable', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'ct_side' => array(
                    'html' => 'radiobuttons',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose basic position of panel. Set the horizontal and vertical offset value according to the selected position of layout design.', WCU_LANG_CODE),
                    'label' => __('Position', WCU_LANG_CODE),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'left' => __('left', WCU_LANG_CODE),
                            'right' => __('right', WCU_LANG_CODE),
                            'top' => __('top', WCU_LANG_CODE),
                            'bottom' => __('bottom', WCU_LANG_CODE),
                        ),
                        'labeled' => array(
                            'left' => __('left', WCU_LANG_CODE),
                            'right' => __('right', WCU_LANG_CODE),
                            'top' => __('top', WCU_LANG_CODE),
                            'bottom' => __('bottom', WCU_LANG_CODE),
                        ),
                    ),
                ),
                'ct_text_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel text color.', WCU_LANG_CODE),
                    'label' => __('Text color', WCU_LANG_CODE),
                ),
                'ct_text_size' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel text font size.', WCU_LANG_CODE),
                    'label' => __('Text size', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput" style="margin-left:0px;"',
                        'labeled' => __('px', WCU_LANG_CODE),
                        'labeled_right' => true,
                    ),
                ),
				'ct_bg_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel background color.', WCU_LANG_CODE),
                    'label' => __('Background color', WCU_LANG_CODE),
                ),
                'ct_show_border' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Show panel outer border.', WCU_LANG_CODE),
                    'label' => __('Show border', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'ct_border_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('Border color for opening button', WCU_LANG_CODE),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'ct_border_radius' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Set opening button border-radius.', WCU_LANG_CODE),
                    'inrow' => 'open',
                    'label' => __('Border-radius for opening button', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput" style="margin-left:0px"',
                    ),
                ),
                'ct_border_radius_dimension' => array(
                    'html' => 'radiobuttons',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'px' => __('px', WCU_LANG_CODE),
                            '%' => __('%', WCU_LANG_CODE),
                        ),
                        'labeled' => array(
                            'px' => __('px', WCU_LANG_CODE),
                            '%' => __('%', WCU_LANG_CODE),
                        ),
                    ),
                ),
            ),
            'display_rules_tab' => array(
                'show_on' => array(
                    'html' => 'selectbox',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Select the devices on which the panel should be displayed.', WCU_LANG_CODE),
                    'label' => __('Show on', WCU_LANG_CODE),
                    'params' => array(
                        'options' => array(
                            'both' => __('Mobile and Desktop', WCU_LANG_CODE),
                            'mobiles' => __('mobiles', WCU_LANG_CODE),
                            'desktops' => __('desktops', WCU_LANG_CODE),
                        ),
                        'data-target-toggle' => '.wcuSwEnable, .wcuSwRotating',
                    ),
                ),
                'show_on_screen' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('If this option is selected, the panel will be displayed only under the selected conditions.', WCU_LANG_CODE),
                    'label' => __('Show on screen size', WCU_LANG_CODE),
                    'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'show_on_screen_compare' => array(
                    'html' => 'selectbox',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'label' => __('Show on', WCU_LANG_CODE),
                    'params' => array(
                        'options' => array(
                            'less' => __('less', WCU_LANG_CODE),
                            'more' => __('more', WCU_LANG_CODE),
                        ),
                        'labeled_before' => '&emsp;'.__('width', WCU_LANG_CODE),
                        'labeled_after' => __('than', WCU_LANG_CODE),
                        'attrs' => 'style="margin:0px 20px; width:80px;"',
                        'data-target-toggle' => '.wcuSwEnable, .wcuSwRotating',
                    ),
                ),
                'show_on_screen_value' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_attrs' => 'style="" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('px', WCU_LANG_CODE),
                        'labeled_right' => true,
                    ),
                ),
                'display_by_default' => array(
                    'html' => 'selectbox',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => 'all',
                    'row_hide' => '',
                    'tooltip' => __('Select pages from the list on which you want to display the panel or select "Enable" to display the panel on each page.', WCU_LANG_CODE),
                    'label' => __('Display everywhere', WCU_LANG_CODE),
                    'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'options' => array(
                            'enable' => __('Enable', WCU_LANG_CODE),
                            'disable' => __('Disable', WCU_LANG_CODE),
                        ),
                    ),
                ),
				'pages_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Select pages from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', WCU_LANG_CODE),
					'inrow' => 'open',
                    'label' => __('Pages', WCU_LANG_CODE),
					'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'pages_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Pages', WCU_LANG_CODE),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllPagesListForSelectByType('page'),
                    ),
                ),
				'product_categories_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Select product categories from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', WCU_LANG_CODE),
					'inrow' => 'open',
                    'label' => __('Product categories', WCU_LANG_CODE),
					'attrs' => 'style="margin-right: 10px;"',
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'product_categories_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Product categories', WCU_LANG_CODE),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllProductCategories(),
                    ),
                ),
				'custom_post_types_to_show_checkbox' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'tooltip' => __('Custom post type from the list on which you want to hide or display module. If you turn Display everywhere on - module will be hidden on selected pages. If Display everywhere off - module will be displayed only on the selected pages.', WCU_LANG_CODE),
					'inrow' => 'open',
                    'label' => __('Custom post types', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'custom_post_types_to_show' => array(
                    'html' => 'selectlist',
					'row_classes' => 'wcuToShowSelectList',
					'row_parent' => '',
					'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'close',
                    'label' => __('Custom post types', WCU_LANG_CODE),
                    'params' => array(
                        'options' => frameWcu::_()->getModule('currency')->getAllPostTypes(),
                    ),
                ),

            ),
        );
    }

    public function getCurrencyModule() {
        return frameWcu::_()->getModule('currency');
    }
}
