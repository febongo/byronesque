<?php
    foreach ($this->designTab as $p) {
        // create variable like param name with param value
        ${$p} = $this->optionsParams['currency_rates']['design_tab'][$p]['params']['value'];
    }
    foreach ($this->displayRulesTab as $p) {
        // create variable like param name with param value
        ${$p} = $this->optionsParams['currency_rates']['display_rules_tab'][$p]['params']['value'];
    }
    ?>
<style>
    <?php if ($show_on_screen && $show_on_screen_compare && $show_on_screen_value) {
        ?>
    <?php if ($cr_show_on_screen_compare === 'less') {
        $show_on_screen_compare = 'max-width';
        } else {
        $show_on_screen_compare = 'min-width';
        } ?>
    #wcuCurrencyRates {
        display:none !important;
    }
    @media (<?php echo $show_on_screen_compare ?>:<?php echo $show_on_screen_value?>px) {
    #wcuCurrencyRates {
        display:inline-block !important;
    }
    <?php
        }?>
    <?php if (!wp_is_mobile()) {
        ?>
    .wcuCurrencyRates.left, .wcuCurrencyRates.right {
        top: <?php echo $cr_vertical_offset_desktop?><?php echo $cr_vertical_offset_desktop_dimension?> !important;
    }
    .wcuCurrencyRates.top {
        top:0px;
        left: <?php echo $cr_horizontal_offset_desktop?><?php echo $cr_horizontal_offset_desktop_dimension?> !important;
    }
    .wcuCurrencyRates.bottom {
        bottom:0px;
        left: <?php echo $cr_horizontal_offset_desktop?><?php echo $cr_horizontal_offset_desktop_dimension?> !important;
    }
    <?php
        } else {
            ?>
    .wcuCurrencyRates.left, .wcuCurrencyRates.right {
        top: <?php echo $cr_vertical_offset_mobile?><?php echo $cr_vertical_offset_mobile_dimension?> !important;
    }
    .wcuCurrencyRates.top {
        top:0px;
        left: <?php echo $cr_horizontal_offset_mobile?><?php echo $cr_horizontal_offset_mobile_dimension?> !important;
    }
    .wcuCurrencyRates.bottom {
        bottom:0px;
        left: <?php echo $cr_horizontal_offset_mobile?><?php echo $cr_horizontal_offset_mobile_dimension?> !important;
    }
    <?php
        } ?>
    .wcuCurrencyRates {
        max-width: <?php echo $cr_width?>px;
    }
    .wcuCurrencyRates .wcuCurrencyRatesButton table.wcuCurrencyRatesTableButton tr td {
        background-color: <?php echo $cr_btn_bg_color?>;
        color: <?php echo $cr_btn_txt_color?>;
        border-radius: <?php echo $cr_btn_border_radius.$cr_btn_border_radius_dimension?>;
    }
    .wcuCurrencyRates.wcuCurrencyRatesBtnShowBorder_1 .wcuCurrencyRatesButton table.wcuCurrencyRatesTableButton tr td {
        border:1px solid <?php echo $cr_btn_border_color?>;
    }
    .wcuCurrencyRates .wcuCurrencyRatesButtonClose {
        background: <?php echo $cr_panel_header_bg_color?> !important;
        color: <?php echo $cr_panel_header_txt_color?>;
    }
    .wcuCurrencyRates .wcuHeader table tr td {
        background-color: <?php echo $cr_panel_header_bg_color?> !important;
        color: <?php echo $cr_panel_header_txt_color?>;
    }
	.wcuCurrencyRates .wcuHeader {
		background-color: <?php echo $cr_panel_header_bg_color?> !important;
	}
    .wcuCurrencyRates table tr td {
        vertical-align:middle;
    }
    .wcuCurrencyRates table.wcuCurrencyRatesTableCurrencies tbody tr td {
		background-color: <?php echo $cr_panel_bg_color?>;
        color: <?php echo $cr_panel_txt_color?>;
    }
    .wcuCurrencyRates {
        color: <?php echo $cr_panel_txt_color?>;
    }
    .wcuCurrencyRates.wcuCurrencyRatesShowStripping_1 table.wcuCurrencyRatesTableCurrencies tr.wcuCurrencyRatesTrActive.wcuCurrencyRatesTrActiveOdd td {
        background-color: <?php echo $cr_rows_stripping_color?>;
    }
    .wcuCurrencyRates.wcuCurrencyRatesShowOuterBorder_1 .wcuCurrencyRatesTableCurrencies {
        border: 1px solid  <?php echo $cr_outer_border_color?>;
    }
    .wcuCurrencyRates.wcuCurrencyRatesShowInnerBorder_1 .wcuCurrencyRatesTableCurrencies td, .wcuCurrencyRates.wcuCurrencyRatesShowOuterBorder_1 .wcuCurrencyRatesTableCurrencies th {
        border: 1px solid <?php echo $cr_inner_border_color?>;
    }
	.wcuCurrencyRates .wcuCurrencyRatesButton {
		opacity:<?php echo $cr_opacity_button*0.01 ?>;
		transition:.4s;
	}
	.wcuCurrencyRates:hover .wcuCurrencyRatesButton {
		opacity:1;
	}

	.wcuCurrencyRates .wcuHeader,
	.wcuCurrencyRates .wcuCurrencyRatesTableCurrencies,
	.wcuCurrencyRates .wcuCurrencyRatesButtonClose {
		opacity:<?php echo $cr_opacity_panel*0.01 ?>;
		transition:.4s;
	}

	.wcuCurrencyRates:hover .wcuHeader,
	.wcuCurrencyRates:hover .wcuCurrencyRatesTableCurrencies,
	.wcuCurrencyRates:hover .wcuCurrencyRatesButtonClose {
		opacity:1;
	}


	.wcuCurrencyRates .wcuCurrencyRatesButton {
		font-family:'<?php echo $cr_btn_font ?>', sans-serif !important;
		font-size:<?php echo $cr_btn_size ?>px !important;
		<?php if (!empty($cr_btn_bold)) {?>
			font-weight:bold !important;
		<?php }?>
		<?php if (!empty($cr_btn_italic)) {?>
			font-style:italic !important;
		<?php }?>
	}
	.wcuCurrencyRates .wcuHeader {
		font-family:'<?php echo $cr_panel_header_font ?>', sans-serif !important;
		font-size:<?php echo $cr_panel_header_size ?>px !important;
		<?php if (!empty($cr_panel_header_bold)) {?>
			font-weight:bold !important;
		<?php }?>
		<?php if (!empty($cr_panel_header_italic)) {?>
			font-style:italic !important;
		<?php }?>
		background:<?php echo $cr_panel_header_bg_color ?> !important;
		color:<?php echo $cr_panel_header_txt_color ?> !important;
	}
	.wcuCurrencyRates input, .wcuCurrencyRates select, .wcuCurrencyRates .dd, .wcuCurrencyRates .wcuCurrencyRatesTableCurrencies  {
		font-family:'<?php echo $cr_panel_txt_font ?>', sans-serif !important;
		font-size:<?php echo $cr_panel_txt_size ?>px !important;
		<?php if (!empty($cr_panel_txt_bold)) {?>
			font-weight:bold !important;
		<?php }?>
		<?php if (!empty($cr_panel_txt_italic)) {?>
			font-style:italic !important;
		<?php }?>
	}

    <?php if ($show_on_screen) { ?>
    }
    <?php }?>
</style>
<div id="wcuCurrencyRates" class="wcuCurrencyRates <?php echo $cr_side?>  wcuCurrencyRatesIconSize_<?php echo $cr_icon_size?> wcuCurrencyRatesToggle_<?php echo $cr_toggle?> wcuCurrencyRatesBtnShowBorder_<?php echo $cr_btn_show_border?> wcuCurrencyRatesShowInnerBorder_<?php echo $cr_inner_border_show?> wcuCurrencyRatesShowStripping_<?php echo $cr_rows_stripping_show?> wcuCurrencyRatesShowOuterBorder_<?php echo $cr_outer_border_show?> " style="display:none;">
    <div class="wcuHeader">
        <table>
            <tr>
                <td nowrap>
                    <div class="wcuHeaderTitle">
                        <?php echo $cr_panel_header_text; ?>
                    </div>
                </td>
                <td>
                    <div class="wcuCurrencyRatesSelectFlagDropdownWrapper">
                        <select name="wcu_currency_rates" class="wcuCurrencyRatesSelectDropdown">
                            <?php foreach ($this->currenciesDropdown as $key => $currency) {?>
                            <?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
                            <option <?php echo $current?> value="<?php echo $key?>" title="<?php if ($this->showFlagDropdown) { echo $currency['flag_dropdown']; } ?>">
                                <?php foreach ($currency as $key => $option) { ?>
                                <?php if ($key === 'flag_dropdown') continue;?>
                                <?php echo $option ?>
                                <?php } ?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <table class="wcuCurrencyRatesTableCurrencies" cellspacing="0" cellpadding="0">
        <tbody>
            <?php foreach ($this->currenciesList as $key => $currency) { ?>
                <?php $current = $key == $this->currentCurrency ? 'wcuCurrent' : ''; ?>
                <tr class="<?php echo $current?>" data-currency="<?php echo $key?>">
                    <?php foreach ($currency as $key => $option) { ?>
                        <?php if ($key === 'rate') {?>
                            <td class="wcuCurrencyRatesTdRate">
                                <div class="wcuCurrencyRatesDiv wcuCurrencyRatesListRate">
                                    <div class="wcuCurrencyRateVal"></div>
                                </div>
                            </td>
                        <?php continue; }?>
                        <td>
                            <div class="wcuCurrencyRatesDiv wcuCurrencyRates_<?php echo $key ?>">
                                <?php echo $option ?>
                            </div>
                        </td>
                    <?php } ?>
                </tr>
            <?php }?>
        </tbody>
    </table>
	<?php if ( !empty($cr_toggle) && ($cr_toggle !== 'full_size') ) { ?>
    <div class="wcuCurrencyRatesButton">
        <table class="wcuCurrencyRatesTableButton" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <?php if (!empty($cr_btn_text)) { ?>
                        <td nowrap>
                            <div class="wcuCurrencyRatesButtonDiv wcuCurrencyRatesButtonStaticText">
                                <?php echo $cr_btn_text; ?>
                            </div>
                        </td>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="wcuCurrencyRatesButtonClose" style="display:none;">
        <i class="fa fa-times" aria-hidden="true"></i>
    </div>
	<?php }?>
</div>

<script type="text/javascript">
	jQuery('.ddChild').css('height', 'auto');
</script>
