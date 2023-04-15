<?php
class currency_ratesWcu extends moduleWcu
{
    public function init() {
        parent::init();
        add_action('wp_footer', array($this, 'showModule'));
    }

	public function showModule() {
		echo $this->drawModule();
	}

    public function drawModule($previewOptions = array()) {
		if (!$previewOptions) {
            $show = frameWcu::_()->getModule('currency')->getShowModule('currency_rates', true);
        } else {
			$show = true;
		}
        if (isset($show) && $show) {
            return $this->getView()->getCurrencyRates($previewOptions);
        }
		return '';
    }
    public function getDefaultOptions() {
        return array(
            'design_tab' => array(
                'enable' => '0',
                'cr_rounding' => '0',
                'cr_decimal' => '2',
				'cr_toggle' => 'on_click',
                'cr_side' => 'bottom',
                'cr_width' => '300',
				'cr_show_dropdown_order' => array('name'),
				'cr_show_list_order' => array('flag_list','name','rate'),
				'cr_btn_text' => 'Currency rates',
				'cr_icon_size' => 'm',
				'cr_btn_txt_color' => '#ffffff',
				'cr_btn_bg_color' => '#1e73be',
                'cr_show_dropdown_flag' => '1',
				'cr_btn_show_border' => '0',
				'cr_btn_border_color' => '#dddddd',
				'cr_btn_border_radius' => '0',
				'cr_btn_border_radius_dimension' => 'px',
				'cr_panel_header_text' => 'Choose currency',
				'cr_panel_header_txt_color' => '#ffffff',
				'cr_panel_header_bg_color' => '#1e73be',
				'cr_panel_txt_color' => '#ffffff',
				'cr_panel_bg_color' => '#1e73be',
				'cr_inner_border_show' => '0',
				'cr_inner_border_color' => '#dddddd',
				'cr_rows_stripping_show' => '1',
				'cr_rows_stripping_color' => '#4184bf',
				'cr_outer_border_show' => '0',
				'cr_outer_border_color' => '#dddddd',
                'cr_horizontal_offset_desktop' => '50',
                'cr_horizontal_offset_desktop_dimension' => '%',
                'cr_horizontal_offset_mobile' => '0',
                'cr_horizontal_offset_mobile_dimension' => 'px',
                'cr_vertical_offset_desktop' => '50',
                'cr_vertical_offset_desktop_dimension' => '%',
                'cr_vertical_offset_mobile' => '0',
                'cr_vertical_offset_mobile_dimension' => 'px',

				'cr_btn_font' => 'sans-serif',
				'cr_btn_size' => '14',
				'cr_btn_bold' => '1',
				'cr_btn_italic' => '0',

				'cr_panel_header_font' => 'sans-serif',
				'cr_panel_header_size' => '14',
				'cr_panel_header_bold' => '1',
				'cr_panel_header_italic' => '0',

				'cr_panel_txt_font' => 'sans-serif',
				'cr_panel_txt_size' => '14',
				'cr_panel_txt_bold' => '1',
				'cr_panel_txt_italic' => '0',

				'cr_opacity_panel' => '100',
				'cr_opacity_button' => '100',

            ),
            'display_rules_tab' => array(
                'show_on' => 'both',
                'show_on_screen' => '0',
                'show_on_screen_compare' => 'more',
                'show_on_screen_value' => '760',
                'display_by_default' => 'enable',
                'pages_to_show' => array(),
				'pages_to_show_checkbox' => '0',
                'product_categories_to_show_checkbox' => '0',
                'custom_post_types_to_show_checkbox' => '0',
				'rates_shortcode' => '<code>[woo-currency-rates]</code>',
				'rates_shortcode_php' => '<code>'.htmlentities("<?php echo do_shortcode('[woo-currency-rates]')?>").'</code>',
                'product_categories_to_show' => array(),
                'custom_post_types_to_show' => array(),
            ),
        );
    }
    public function getOptionsParams()
    {
		$fontFamilyList = frameWcu::_()->getModule('currency')->getFontFamilyList();
        $flagModule = false;
        if (!empty(frameWcu::_()->getModule('flags'))) {
            $flagModule = true;
        }
        // to find params description and hooks @see currencyWcu::getOptionsParams
        return array(
            'design_tab' => array(
                'enable' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Currency Rates allows you to get exchange rates for all currencies in list by selected currency.', WCU_LANG_CODE),
                    'label' => __('Enable', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'cr_rounding' => array(
                    'html' => 'checkboxHiddenVal',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'open',
                    'tooltip' => __('Rounding rates to decimal places.', WCU_LANG_CODE),
                    'label' => __('Rounding rates', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'0',
                    ),
                ),
                'cr_decimal' => array(
                    'html' => 'input',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_attrs' => 'style="padding-left:15px;" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('to decimal places', WCU_LANG_CODE),
                    ),
                ),
                'cr_toggle' => array(
                    'html' => 'radiobuttons',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'row_hide_with_all' => true,
                    'tooltip' => __('Show panel by mouse hover or click.', WCU_LANG_CODE),
                    'label' => __('Toggle panel', WCU_LANG_CODE),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel"',
                        'no_br'	=> true,
                        'options' => array(
                            'on_click' => __('on click', WCU_LANG_CODE),
                            'on_hover' => __('on hover', WCU_LANG_CODE),
							'full_size' => __('full size view', WCU_LANG_CODE),
                        ),
                        'labeled' => array(
                            'on_click' => __('on click', WCU_LANG_CODE),
                            'on_hover' => __('on hover', WCU_LANG_CODE),
							'full_size' => __('full size view', WCU_LANG_CODE),
                        ),
                    ),
                ),
                'cr_width' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose panel width.', WCU_LANG_CODE),
                    'label' => __('Panel width', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput" style="margin-left:0px;"',
                        'labeled' => __('px', WCU_LANG_CODE),
                        'labeled_right' => true,
                    ),
                ),
				'cr_side' => array(
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
				'cr_horizontal_offset_desktop' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Change horizontal panel offset only for bottom and top positions.', WCU_LANG_CODE),
                    'inrow' => 'open',
                    'label' => __('Horizontal offset', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('desktop', WCU_LANG_CODE),
                    ),
                ),
                'cr_horizontal_offset_desktop_dimension' => array(
                    'html' => 'radiobuttons',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
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
                'cr_horizontal_offset_mobile' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_attrs' => 'style="margin-left:30px;" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('mobile', WCU_LANG_CODE),
                    ),
                ),
                'cr_horizontal_offset_mobile_dimension' => array(
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
                'cr_vertical_offset_desktop' => array(
                    'html' => 'input',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Change vertical panel offset only for left and right positions.', WCU_LANG_CODE),
                    'inrow' => 'open',
                    'label' => __('Vertical offset', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('desktop', WCU_LANG_CODE),
                    ),
                ),
                'cr_vertical_offset_desktop_dimension' => array(
                    'html' => 'radiobuttons',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'inrow' => 'middle',
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
                'cr_vertical_offset_mobile' => array(
                    'html' => 'input',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_attrs' => 'style="margin-left:30px;" class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('mobile', WCU_LANG_CODE),
                    ),
                ),
                'cr_vertical_offset_mobile_dimension' => array(
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


				'cr_opacity_panel' => array(
                    'html' => 'input',
                    'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'inrow' => 'open',
                    'tooltip' => __('Change the level of transparency for the panel and opening button.', WCU_LANG_CODE),
                    'label' => __('Transparent', WCU_LANG_CODE),
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('panel', WCU_LANG_CODE),
						'placeholder' => '0 - 100',
                    ),
                ),
				'cr_opacity_button' => array(
                    'html' => 'input',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
                    'inrow' => 'middle',
                    'params' => array(
                        'label_attrs' => 'class="wcuSwitcherInputLabel"',
                        'attrs' => 'class="wcuSwitcherInput"',
                        'labeled' => __('button', WCU_LANG_CODE),
						'placeholder' => '0 - 100',
                    ),
                ),


                'cr_show_dropdown_flag' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Enable currency flag in dropdown select.', WCU_LANG_CODE),
                    'label' => __('Enable dropdown flag', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
                'cr_show_dropdown_order' => array(
                    'html' => 'selectlistsortable',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Set the display order and what to display in the dropdown select list.', WCU_LANG_CODE),
                    'label' => __('Show in currency dropdown', WCU_LANG_CODE),
                    'params' => array(
                        'id' => 'wcuShowCurrencyRatesDropdownOrder',
                        'attrs' => 'style="height:130px;"',
                        'options' => array(
                            'name' => __('Currency codes', WCU_LANG_CODE),
                            'title' => __('Titles', WCU_LANG_CODE),
                            'symbol' => __('Currency symbols', WCU_LANG_CODE),
                        ),
                    ),
                ),
				'cr_show_list_order' => array(
                    'html' => 'selectlistsortable',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Set the display order and what to display in the list.', WCU_LANG_CODE),
                    'label' => __('Show in currency list', WCU_LANG_CODE),
                    'params' => array(
                        'id' => 'wcuShowCurrencyRatesListOrder',
                        'attrs' => 'style="height:130px;"',
                        'options' => $flagModule ? array(
                            'name' => __('Currency codes', WCU_LANG_CODE),
                            'title' => __('Titles', WCU_LANG_CODE),
                            'symbol' => __('Currency symbols', WCU_LANG_CODE),
                            'rate' => __('Currency rates', WCU_LANG_CODE),
                            'flag_list' => __('Flags', WCU_LANG_CODE),
                        ) : array(
                            'name' => __('Currency codes', WCU_LANG_CODE),
                            'title' => __('Titles', WCU_LANG_CODE),
                            'symbol' => __('Currency symbols', WCU_LANG_CODE),
                            'rate' => __('Currency rates', WCU_LANG_CODE),
                        ),
                    ),
                ),
                'cr_btn_text' => array(
                    'html' => 'input',
					'row_classes' => 'hideIfFullSizeView',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Type your text for opening button.', WCU_LANG_CODE),
					'label' => __('Panel opening button text', WCU_LANG_CODE),
                    'params' => array(
                        'attrs' => 'style="width:200px;"',
                    ),
                ),

				'cr_btn_font' => array(
					'html' => 'selectbox',
					'row_classes' => 'hideIfFullSizeView',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Select opening button font setting.', WCU_LANG_CODE),
                    'label' => __('Panel opening button font setting', WCU_LANG_CODE),
                    'params' => array(
						'attrs' => "style='width:100px'",
                        'options' => $fontFamilyList,
                    ),
                ),
                'cr_btn_size' => array(
					'html' => 'input',
					'row_classes' => 'hideIfFullSizeView',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_btn_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'hideIfFullSizeView',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_btn_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => 'hideIfFullSizeView',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),


				'cr_icon_size' => array(
                    'html' => 'radiobuttons',
                    'row_classes' => 'hideIfFullSizeView',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose size for opening button.', WCU_LANG_CODE),
                    'label' => __('Panel opening button size', WCU_LANG_CODE),
                    'params' => array(
                        'attrs' => 'class="wcuSwitcherRadioLabel" ',
                        'no_br'	=> true,
                        'options' => array(
                            's' => __('S', WCU_LANG_CODE),
                            'm' => __('M', WCU_LANG_CODE),
                            'l' => __('L', WCU_LANG_CODE),
                        ),
                        'labeled' => array(
                            's' => __('S', WCU_LANG_CODE),
                            'm' => __('M', WCU_LANG_CODE),
                            'l' => __('L', WCU_LANG_CODE),
                        ),
                    ),
                ),
				'cr_btn_txt_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => 'hideIfFullSizeView',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose text color for opening button.', WCU_LANG_CODE),
                    'label' => __('Text color for opening button', WCU_LANG_CODE),
                ),
				'cr_btn_bg_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => 'hideIfFullSizeView',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose background color for opening button.', WCU_LANG_CODE),
                    'label' => __('Background color for opening button', WCU_LANG_CODE),
                ),
                'cr_btn_show_border' => array(
                    'html' => 'checkboxHiddenVal',
					'row_classes' => 'hideIfFullSizeView',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Show opening button outer border.', WCU_LANG_CODE),
                    'label' => __('Show border', WCU_LANG_CODE),
                    'params' => array(
                        'value'=>'1',
                    ),
                ),
				'cr_btn_border_color' => array(
                    'html' => 'colorpicker',
                    'row_classes' => 'hideIfFullSizeView',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'inrow' => 'close',
                    'params' => array(
                        'label_before' => __('Border color for opening button', WCU_LANG_CODE),
                        'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
                    ),
                ),
                'cr_btn_border_radius' => array(
                    'html' => 'input',
					'row_classes' => 'hideIfFullSizeView',
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
                'cr_btn_border_radius_dimension' => array(
                    'html' => 'radiobuttons',
					'row_classes' => 'hideIfFullSizeView',
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
				'cr_panel_header_text' => array(
                    'html' => 'input',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Type your text for panel title.', WCU_LANG_CODE),
					'label' => __('Panel header text', WCU_LANG_CODE),
                    'params' => array(
                        'attrs' => 'style="width:200px;"',
                    ),
                ),

				'cr_panel_header_font' => array(
					'html' => 'selectbox',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Select panel header font setting.', WCU_LANG_CODE),
                    'label' => __('Panel header font setting', WCU_LANG_CODE),
                    'params' => array(
						'attrs' => "style='width:100px'",
                        'options' => $fontFamilyList,
                    ),
                ),
                'cr_panel_header_size' => array(
					'html' => 'input',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_panel_header_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_panel_header_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),


				'cr_panel_header_txt_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose text color for panel title.', WCU_LANG_CODE),
                    'label' => __('Panel header text color', WCU_LANG_CODE),
                ),
				'cr_panel_header_bg_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose background color for panel title.', WCU_LANG_CODE),
                    'label' => __('Panel header background color', WCU_LANG_CODE),
                ),

				'cr_panel_txt_font' => array(
					'html' => 'selectbox',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Select panel header font setting.', WCU_LANG_CODE),
                    'label' => __('Panel text font setting', WCU_LANG_CODE),
                    'params' => array(
						'attrs' => "style='width:100px'",
                        'options' => $fontFamilyList,
                    ),
                ),

                'cr_panel_txt_size' => array(
					'html' => 'input',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'label_attrs' => 'class="wcuSwitcherInputLabel"',
						'attrs' => 'class="wcuSwitcherInput"',
						'labeled' => __('px', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_panel_txt_bold' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'middle',
					'params' => array(
						'value' => '1',
						'labeled' => '&emsp;'.__('Bold', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),
                'cr_panel_txt_italic' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'value'=>'1',
						'labeled' => '&emsp;'.__('Italic', WCU_LANG_CODE).'&emsp;',
						'labeled_right' => true,
					),
                ),

				'cr_panel_txt_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose text color for panel body.', WCU_LANG_CODE),
                    'label' => __('Panel text color', WCU_LANG_CODE),
                ),
				'cr_panel_bg_color' => array(
                    'html' => 'colorpicker',
					'row_classes' => '',
                    'row_parent' => '',
                    'row_show' => '',
                    'row_hide' => '',
                    'tooltip' => __('Choose background color for panel body.', WCU_LANG_CODE),
                    'label' => __('Panel background color', WCU_LANG_CODE),
                ),
				'cr_inner_border_show' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Show panel inner border.', WCU_LANG_CODE),
					'label' => __('Show inner border', WCU_LANG_CODE),
					'params' => array(
						'value'=>'1',
					),
				),
				'cr_inner_border_color' => array(
					'html' => 'colorpicker',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Choose inner border color.', WCU_LANG_CODE),
					'inrow' => 'close',
					'params' => array(
						'label_before' => __('inner border color', WCU_LANG_CODE),
						'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
					),
				),
				'cr_rows_stripping_show' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'open',
                    'tooltip' => __('Enable background striping in the panel list.', WCU_LANG_CODE),
					'label' => __('Rows stripping', WCU_LANG_CODE),
					'params' => array(
						'value'=>'1',
					),
				),
				'cr_rows_stripping_color' => array(
					'html' => 'colorpicker',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'inrow' => 'close',
					'params' => array(
						'label_before' => __('even rows color', WCU_LANG_CODE),
						'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
					),
				),
				'cr_outer_border_show' => array(
					'html' => 'checkboxHiddenVal',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Show outer border for panel.', WCU_LANG_CODE),
					'inrow' => 'open',
					'label' => __('Show outer border', WCU_LANG_CODE),
					'params' => array(
						'value'=>'1',
					),
				),
				'cr_outer_border_color' => array(
					'html' => 'colorpicker',
					'row_classes' => '',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
                    'tooltip' => __('Choose outer border color for panel.', WCU_LANG_CODE),
					'inrow' => 'close',
					'params' => array(
						'label_before' => __('border color', WCU_LANG_CODE),
						'label_before_attrs' => 'class="wcuColorPickerLabelBefore"',
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
				'rates_shortcode' => array(
					'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'tooltip' => __('The shortcode can take parameters, read more in the documentation.', WCU_LANG_CODE),
					'label' => __('Shortcode', WCU_LANG_CODE),
				),
				'rates_shortcode_php' => array(
					'html' => 'block',
					'row_classes' => 'wcuToShowSelectList wcuShowCheckbox',
					'row_parent' => '',
					'row_show' => '',
					'row_hide' => '',
					'tooltip' => __('The shortcode can take parameters, read more in the documentation.', WCU_LANG_CODE),
					'label' => __('PHP Shortcode', WCU_LANG_CODE),
				),
            ),
        );
    }

    public function getCurrencyModule() {
        return frameWcu::_()->getModule('currency');
    }
}
