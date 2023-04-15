<?php
foreach ($this->designTab as $p) {
    // create variable like param name with param value
    ${$p} = $this->optionsParams['currency_converter']['design_tab'][$p]['params']['value'];
}
foreach ($this->displayRulesTab as $p) {
    // create variable like param name with param value
    ${$p} = $this->optionsParams['currency_converter']['display_rules_tab'][$p]['params']['value'];
}
?>

<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?php echo $cc_btn_font;?>"> -->

<style>

<?php $cc_template_design_button = !empty($cc_template_design) ? 'button' : '' ?>

<?php if ($show_on_screen && $show_on_screen_compare && $show_on_screen_value) {
    ?>
	<?php if ($show_on_screen_compare === 'less') {
        $show_on_screen_compare = 'max-width';
    } else {
        $show_on_screen_compare = 'min-width';
    } ?>
	#wcuCurrencyConverter {
		display:none !important;
	}
	@media (<?php echo $show_on_screen_compare ?>:<?php echo $show_on_screen_value?>px) {
		#wcuCurrencyConverter {
			display:inline-block !important;
		}
<?php
}?>
	<?php if (!wp_is_mobile()) {
        ?>
		.wcuCurrencyConverter.left, .wcuCurrencyConverter.right {
			top: <?php echo $cc_vertical_offset_desktop?><?php echo $cc_vertical_offset_desktop_dimension?> !important;
		}
		.wcuCurrencyConverter.top {
			top:0px;
			left: <?php echo $cc_horizontal_offset_desktop?><?php echo $cc_horizontal_offset_desktop_dimension?> !important;
		}
		.wcuCurrencyConverter.bottom {
			bottom:0px;
			left: <?php echo $cc_horizontal_offset_desktop?><?php echo $cc_horizontal_offset_desktop_dimension?> !important;
		}
	<?php
    } else {
        ?>
		.wcuCurrencyConverter.left, .wcuCurrencyConverter.right {
			top: <?php echo $cc_vertical_offset_mobile?><?php echo $cc_vertical_offset_mobile_dimension?> !important;
		}
		.wcuCurrencyConverter.top {
			top:0px;
			left: <?php echo $cc_horizontal_offset_mobile?><?php echo $cc_horizontal_offset_mobile_dimension?> !important;
		}
		.wcuCurrencyConverter.bottom {
			bottom:0px;
			left: <?php echo $cc_horizontal_offset_mobile?><?php echo $cc_horizontal_offset_mobile_dimension?> !important;
		}
	<?php
    } ?>
    .wcuCurrencyConverter {
        color:<?php echo $cc_panel_txt_color ?>;
        max-width:<?php echo $cc_width ?>px;
    }

	.wcuCurrencyConverter .dd .ddTitle, .wcuCurrencyConverter .dd .ddChild li, .wcuCurrencyConverter .dd .ddChild li .ddlabel,.wcuCurrencyConverter input, .wcuCurrencyConverter select {
		color:<?php echo $cc_panel_txt_color ?>;
	}
	<?php if ( empty($cc_template_design) ) { ?>
	    .wcuCurrencyConverter .wcuCurrencyConvertBtn {
	        background:<?php echo $cc_convert_btn_bg_color ?>;
	        color:<?php echo $cc_convert_btn_txt_color ?>;
	    }
	    .wcuCurrencyConverter .wcuCurrencyConvertBtn:hover {
	        background:<?php echo $cc_convert_btn_color_h ?>;
	    }
	<?php }?>
    .wcuCurrencyConverter.wcuCurrencyConverterShowOuterBorder_1 {
        border:1px solid <?php echo $cc_outer_border_color ?>;
    }
    .wcuCurrencyConverter.wcuCurrencyConverterBtnShowOuterBorder_1 .wcuCurrencyConverterButton {
        border:1px solid <?php echo $cc_btn_border_color ?>;
    }
    .wcuCurrencyConverter .wcuCurrencyConverterButton {
        background:<?php echo $cc_btn_bg_color ?> !important;
        color:<?php echo $cc_btn_txt_color ?> !important;
        border-radius:<?php echo $cc_btn_border_radius.$cc_btn_border_radius_dimension ?>;
    }
    .wcuCurrencyConverter .wcuExchangeIcon {
        color: <?php echo $cc_convert_btn_bg_color ?>;
    }
    .wcuCurrencyConverter .wcuExchangeIcon:hover{
        color:<?php echo $cc_convert_btn_color_h ?>;
    }
    .wcuCurrencyConverter.wcuCurrencyConverterToggleClick .wcuCurrencyConverterButtonClose {
        background:<?php echo $cc_convert_btn_bg_color ?> !important;
        color:<?php echo $cc_convert_btn_txt_color ?>;
    }
    .wcuCurrencyConverter.wcuCurrencyConverterToggleClick .wcuCurrencyConverterButtonClose:hover {
        background:<?php echo $cc_convert_btn_color_h ?>  !important;
    }
    .wcuCurrencyConverter .wcuCurrencyConverterButton {
		<?php if ( empty($cc_template_design) ) { ?>
			font-family:'<?php echo $cc_btn_font ?>', sans-serif !important;
			font-size:<?php echo $cc_btn_size ?>px !important;
			<?php if (!empty($cc_btn_bold)) {?>
				font-weight:bold !important;
			<?php }?>
			<?php if (!empty($cc_btn_italic)) {?>
				font-style:italic !important;
			<?php }?>
		<?php }?>
    }
	.wcuCurrencyConverter .wcuHeader {
		<?php if ( empty($cc_template_design) ) { ?>
			font-family:'<?php echo $cc_panel_header_font ?>', sans-serif !important;
			font-size:<?php echo $cc_panel_header_size ?>px !important;
			<?php if (!empty($cc_panel_header_bold)) {?>
				font-weight:bold !important;
			<?php }?>
			<?php if (!empty($cc_panel_header_italic)) {?>
				font-style:italic !important;
			<?php }?>
		<?php }?>
		background:<?php echo $cc_panel_header_bg_color ?> !important;
	    color:<?php echo $cc_panel_header_txt_color ?> !important;

	}
	.wcuCurrencyConverter input, .wcuCurrencyConverter select, .wcuCurrencyConverter .dd  {
		<?php if ( empty($cc_template_design) ) { ?>
			font-family:'<?php echo $cc_panel_txt_font ?>', sans-serif !important;
			font-size:<?php echo $cc_panel_txt_size ?>px !important;
			<?php if (!empty($cc_panel_txt_bold)) {?>
				font-weight:bold !important;
			<?php }?>
			<?php if (!empty($cc_panel_txt_italic)) {?>
				font-style:italic !important;
			<?php }?>
		<?php }?>
	}
	.wcuCurrencyConverter .wcuCurrencyConvertBtn {
		<?php if ( empty($cc_template_design) ) { ?>
			font-family:'<?php echo $cc_convert_btn_font ?>', sans-serif !important;
			font-size:<?php echo $cc_convert_btn_size ?>px !important;
			<?php if (!empty($cc_convert_btn_bold)) {?>
				font-weight:bold !important;
			<?php }?>
			<?php if (!empty($cc_convert_btn_italic)) {?>
				font-style:italic !important;
			<?php }?>
		<?php }?>
	}
	.wcuCurrencyConverter .wcuCurrencyConverterButton {
		opacity:<?php echo $cc_opacity_button*0.01 ?>;
		transition:.4s;
	}
	.wcuCurrencyConverter:hover .wcuCurrencyConverterButton {
		opacity:1;
	}
    .wcuCurrencyConverter .wcuCurrencyConverterShell {
        background:<?php echo $cc_panel_bg_color ?>;
        padding-top:10px;
    }
	.wcuCurrencyConverter .wcuHeader,
	.wcuCurrencyConverter .wcuCurrencyConverterShell,
	.wcuCurrencyConverter .wcuCurrencyConverterButtonClose {
		opacity:<?php echo $cc_opacity_panel*0.01 ?>;
		transition:.4s;
	}

	.wcuCurrencyConverter:hover .wcuHeader,
	.wcuCurrencyConverter:hover .wcuCurrencyConverterShell,
	.wcuCurrencyConverter:hover .wcuCurrencyConverterButtonClose {
		opacity:1;
	}

	<?php if ($show_on_screen) { ?>
	}
	<?php }?>
</style>



<div id="wcuCurrencyConverter" class="wcuCurrencyConverter <?php echo $cc_side?> wcuCurrencyConverterIconSize_<?php echo $cc_icon_size ?> wcuCurrencyConverterLayout_<?php echo $cc_layout ?> wcuCurrencyConverterBtnShowOuterBorder_<?php echo $cc_btn_show_border ?> wcuCurrencyConverterShowOuterBorder_<?php echo $cc_outer_border_show?> wcuCurrencyConverterToggle_<?php echo $cc_toggle?> " style="display:none;">

        <?php if ($cc_panel_header_show) {?>
    		<div class="wcuHeader">
                    <div class="wcuHeaderTitle">
                        <?php echo $cc_panel_header_text; ?>
                    </div>
            </div>
        <?php }?>

	    <div class="wcuCurrencyConverterShell container-fluid" style="display:block;position:relative;height:auto;width:auto;">

            <?php if ( !empty($cc_layout) && ( $cc_layout === 'vertical' ) ) {?>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
            				<?php echo htmlWcu::input("amount", array(
            					'type' => 'text',
            					'value' => 1,
            					'attrs' => 'placeholder="results" style="width:100%"',
            				))?>
            				<?php echo htmlWcu::hidden("precision", array(
            					'value' => 4,
            				))?>
            		</div>
                    <div class="clearfix"></div>
                </div>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
                        <select name="currency_from" class="wcuCurrencyConverterDropdown">
                            <?php foreach ($this->currenciesDropdown as $key => $currency) {?>
                                    <?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
                                    <option <?php echo $current?> value="<?php echo $key?>" title="<?php if ($cc_show_dropdown_flag) { echo $currency['flag_dropdown']; }?>">
                                        <?php foreach ($currency as $key => $option) {?>
                                            <?php if ($key === 'flag_dropdown') continue;?>
                                            <?php echo $option;?>
                                        <?php }?>
                                    </option>
                            <?php }?>
                        </select>
            		</div>
                    <div class="wcuCol-md-2 wcuCol-xs-12 wcuMargin">
            			<div class="wcuExchangeIcon" style="text-align: center;">&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i>&nbsp;</div>
            		</div>
                    <div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
            				<select name="currency_to" class="wcuCurrencyConverterDropdown">
								<?php $counter = 0;?>
            					<?php foreach ($this->currenciesDropdown as $key => $currency) {?>
										<?php $current = $counter == 1 ? 'selected' : ''; ?>
                                        <option <?php echo $current?> value="<?php echo $key?>" title="<?php if ($cc_show_dropdown_flag) { echo $currency['flag_dropdown']; }?>">
                                            <?php foreach ($currency as $key => $option) {?>
                                                <?php if ($key === 'flag_dropdown') continue;?>
                                                <?php echo $option;?>
                                            <?php }?>
                                        </option>
										<?php $counter = $counter + 1;?>
            					<?php }?>
            				</select>
            		</div>
                    <div class="clearfix"></div>
                </div>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
            			<?php echo htmlWcu::input("result", array(
            				'type' => 'text',
            				'value' => '',
            				'attrs' => 'placeholder="results"  style="width:100%" readonly=""',
            			))?>
            		</div>
                    <div class="clearfix"></div>
                </div>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
            			<?php echo htmlWcu::button(array(
            				'value' => __('Convert', WCU_LANG_CODE),
            				'attrs' => 'class="wcuCurrencyConvertBtn '.$cc_template_design_button.'" onclick="getCurrencyRate(this); return false;"',
            			))?>
            		</div>
                    <div class="clearfix"></div>
                </div>
            <?php } else { ?>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
                        <?php echo htmlWcu::input("amount", array(
                            'type' => 'text',
                            'value' => 1,
                            'attrs' => 'style="width:100%"',
                        ))?>
                        <?php echo htmlWcu::hidden("precision", array(
                            'value' => 4,
                        ))?>
                        <select name="currency_from" class="wcuCurrencyConverterDropdown">
                            <?php foreach ($this->currenciesDropdown as $key => $currency) { ?>
                                    <?php $current = $key == $this->currentCurrency ? 'selected' : ''; ?>
                                    <option <?php echo $current?> value="<?php echo $key?>" title="<?php if ($cc_show_dropdown_flag) { echo $currency['flag_dropdown']; }?>">
                                        <?php foreach ($currency as $key => $option) {?>
                                            <?php if ($key === 'flag_dropdown') continue;?>
                                            <?php echo $option;?>
                                        <?php }?>
                                    </option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="wcuCol-md-2 wcuCol-xs-12 wcuMargin">
                        <div class="wcuExchangeIcon wcuExchangeIconHorizontal" style="text-align: center;">&nbsp;<i class="fa fa-long-arrow-right" aria-hidden="true"></i>&nbsp;</div>
                    </div>
                    <div class="wcuCol-md-5 wcuCol-xs-12 wcuMargin">
                        <?php echo htmlWcu::input("result", array(
            				'type' => 'text',
            				'value' => 1,
            				'attrs' => 'style="width:100%"
                            ',
            			))?>
                        <select name="currency_to" class="wcuCurrencyConverterDropdown">
							<?php $counter = 0;?>
                            <?php foreach ($this->currenciesDropdown as $key => $currency) {?>
                                    <?php $current = $counter == 1 ? 'selected' : ''; ?>
                                    <option <?php echo $current?> value="<?php echo $key?>" title="<?php if ($cc_show_dropdown_flag) { echo $currency['flag_dropdown']; }?>">
                                        <?php foreach ($currency as $key => $option) {?>
                                            <?php if ($key === 'flag_dropdown') continue;?>
                                            <?php echo $option;?>
                                        <?php }?>
                                    </option>
									<?php $counter = $counter + 1;?>
                            <?php }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="wcuCol-row">
                    <div class="wcuCol-md-12 wcuCol-xs-12 wcuMargin">
                        <?php echo htmlWcu::button(array(
                            'value' => __('Convert', WCU_LANG_CODE),
                            'attrs' => 'class="wcuCurrencyConvertBtn '.$cc_template_design_button.'" onclick="getCurrencyRate(this); return false;"',
                        ))?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <script type="text/javascript">
        			jQuery("#wcuCurrencyConverter .wcuExchangeIconHorizontal").click(function(){
        				var parent = jQuery(this).closest(".wcuCurrencyConverter");
        				var from = parent.find('[name="amount"]');
        				var to = parent.find('[name="result"]');
        				from = from.attr("name","result");
        				to = to.attr("name","amount");
        			});
					jQuery('.ddChild').css('height', 'auto');
        		</script>

            <?php }?>

        </div>

	<?php if ( !empty($cc_toggle) && ($cc_toggle !== 'full_size') ) { ?>

	    <div class="wcuCurrencyConverterButton">
	        <?php if (!empty($cc_btn_text)) { ?>
	                    <div class="wcuCurrencyConverterButtonDiv wcuCurrencyConverterButtonStaticText"><?php echo $cc_btn_text; ?></div>
	        <?php } ?>
	    </div>

	    <div class="wcuCurrencyConverterButtonClose" >
	        <i class="fa fa-times" aria-hidden="true"></i>
	    </div>

	<?php }?>

    <script type="text/javascript">
        function getCurrencyRate(btn) {
            var shell = jQuery(btn).parents('.wcuCurrencyConverterShell:first');
            jQuery.sendFormWcu({
                data: {
                    mod: 'currency_widget',
                    action: 'getCurrencyRate',
                    amount: shell.find('input[name="amount"]').val(),
                    currency_from: shell.find('[name="currency_from"]').val(),
                    currency_to: shell.find('[name="currency_to"]').val()
                },
                onSuccess: function(res) {
                    if (!res.error) {
                        shell.find('[name="result"]').val(res.data.result);
                    }
                }
            });
        }
    </script>

</div>
