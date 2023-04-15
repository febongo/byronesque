<?php
foreach ($this->designTab as $p) {
    // create variable like param name with param value
    ${$p} = $this->optionsParams['currency_tooltip']['design_tab'][$p]['params']['value'];
}
foreach ($this->displayRulesTab as $p) {
    // create variable like param name with param value
    ${$p} = $this->optionsParams['currency_tooltip']['display_rules_tab'][$p]['params']['value'];
}
?>

<style>
<?php if ($show_on_screen && $show_on_screen_compare && $show_on_screen_value) {
    ?>
	<?php if ($show_on_screen_compare === 'less') {
        $show_on_screen_compare = 'max-width';
    } else {
        $show_on_screen_compare = 'min-width';
    } ?>
	#wcuCurrencyTooltip {
		display:none !important;
	}
	@media (<?php echo $show_on_screen_compare ?>:<?php echo $show_on_screen_value?>px) {
		#wcuCurrencyTooltip {
			display:inline-block !important;
		}
<?php
}?>
    #wcuCurrencyTooltip {
        position: absolute;
        display: inline-block;
        padding: 10px;
        white-space:nowrap;
        font-size: <?php echo $ct_text_size ?>px;
        color: <?php echo $ct_text_color ?>;
        background: <?php echo $ct_bg_color ?>;
        <?php if ($ct_show_border) {?>
            border:1px solid <?php echo $ct_border_color ?>;
        <?php }?>
        border-radius:<?php echo $ct_border_radius.$ct_border_radius_dimension?>;
        text-align:left;
        cursor:pointer;
        z-index:9999;
        font-weight:normal;
		pointer-events: none;
    }
    .wcuCurrencyTooltipRelative {
        position:relative;
        display:inline;
    }
	.woocommerce-Price-amount {
		position:relative;
	}
    <?php if ($ct_side === 'left') { ?>
        #wcuCurrencyTooltip {
            transform:translate(-120%, -50%);
        }
        #wcuCurrencyTooltip::after {
            display:inline-block;
            position:absolute;
            right:-20px;
            top:50%;
            -webkit-transform: translate(-0%, -50%);
            -ms-transform: translate(-0%, -50%);
            transform:translate(0,-50%);
            content:"";
            border: 10px solid black;
            border-left-color: <?php echo $ct_bg_color ?>;
            border-right-color: transparent;
            border-top-color: transparent;
            border-bottom-color: transparent;
        }
    <?php }?>
    <?php if ($ct_side === 'right') { ?>
        #wcuCurrencyTooltip {
            -webkit-transform: translate(20%, -50%);
            -ms-transform: translate(20%, -50%);
            transform:translate(20%, -50%);
        }
        #wcuCurrencyTooltip::after {
            display:inline-block;
            position:absolute;
            left:-20px;
            top:50%;
            -webkit-transform: translate(0%, -50%);
            -ms-transform: translate(0%, -50%);
            transform:translate(0,-50%);
            content:"";
            border: 10px solid black;
            border-left-color: transparent;
            border-right-color: <?php echo $ct_bg_color ?>;
            border-top-color: transparent;
            border-bottom-color: transparent;
        }
    <?php }?>
    <?php if ($ct_side === 'top') { ?>
        #wcuCurrencyTooltip {
            -webkit-transform: translate(-50%, -130%);
            -ms-transform: translate(-50%, -130%);
            transform:translate(-50%, -130%);
        }
        #wcuCurrencyTooltip::after {
            display:inline-block;
            position:absolute;
            bottom:-20px;
            left:50%;
            -webkit-transform: translate(-50%, -0%);
            -ms-transform: translate(-50%, -0%);
            transform:translate(-50,-50%);
            content:"";
            border: 10px solid black;
            border-left-color: transparent;
            border-right-color: transparent;
            border-top-color: <?php echo $ct_bg_color ?>;
            border-bottom-color: transparent;
        }
    <?php }?>
    <?php if ($ct_side === 'bottom') { ?>
        #wcuCurrencyTooltip {
            -webkit-transform: translate(-50%, 30%);
            -ms-transform: translate(-50%, 30%);
            transform:translate(-50%, 30%);
        }
        #wcuCurrencyTooltip::after {
            display:inline-block;
            position:absolute;
            top:-20px;
            left:50%;
            -webkit-transform: translate(-50%, -0%);
            -ms-transform: translate(-50%, -0%);
            transform:translate(-50,-50%);
            content:"";
            border: 10px solid black;
            border-left-color: transparent;
            border-right-color: transparent;
            border-top-color: transparent;
            border-bottom-color: <?php echo $ct_bg_color ?>;;
        }
    <?php }?>
    .woocommerce-Price-amount {
        cursor:pointer;
    }
	<?php if ($show_on_screen) { ?>
	}
	<?php }?>
</style>



<script type="text/javascript">
var currencies = [
    <?php foreach ($this->currencies as $key => $currency) {?> {
        "name": "<?php echo $currency['name']?>",
        "symbol": "<?php echo $currency['symbol']?>",
        "decimals": "<?php echo $currency['decimals']?>",
        "rate": "<?php echo $currency['rate']?>",
        "position": "<?php echo $currency['position']?>"
    },
    <?php }?>
];
var mouseOnPrice = false;
var lastElement;

jQuery('body').on('mouseover','.woocommerce-Price-amount',function(e){
	var currentElement = jQuery(this);
	if (currentElement !== lastElement) {
		jQuery("body").find("#wcuCurrencyTooltip").remove();
	}
	if ( jQuery(this).find('.wcuCurrencyTooltipDefaultPrice').length && jQuery("body").find("#wcuCurrencyTooltip").length < 1) {
		var defaultPriceArray = [];
		defaultPrice = jQuery(this).parent().parent();
		stock = jQuery(this).closest("del");
		if (!stock.length) {
			stock = jQuery(this).closest("ins");
		}
		if (stock.length) {
			defaultPrice = jQuery(this).parent().parent().parent();
		}
		defaultPrice.closest("body").find(defaultPrice).find(".wcuCurrencyTooltipDefaultPrice").each(function (index) {
			value = jQuery(this).attr('data-wcuDefaultPrice');
			if (typeof value == "string") {
				defaultPriceArray.push(value);
			}
		});
		minPrice = defaultPriceArray[0];
		maxPrice = minPrice;
		for (i = 1; i < defaultPriceArray.length; ++i) {
			if (defaultPriceArray[i] > maxPrice) maxPrice = defaultPriceArray[i];
			if (defaultPriceArray[i] < minPrice) minPrice = defaultPriceArray[i];
		}
		if (minPrice === maxPrice) {
			var wcuTooltipEl = '<div id="wcuCurrencyTooltip">';
			for (var x = 0; x < currencies.length; x++) {
				if (currencies[x].name === '<?php echo $this->currentCurrency?>') continue;
				var out = '';
				space = ' ';
				price = (currencies[x].rate * maxPrice).toFixed(currencies[x].decimals);
				symbol = currencies[x].symbol;
				switch (currencies[x].position) {
					case 'left':
						out += symbol + price;
						break;
					case 'right':
						out += price + symbol;
						break;
					case 'left_space':
						out += symbol + space + price;
						break;
					case 'right_space':
						out += price + space + symbol;
						break;
					default:
						break;
				}
				out += '<br>';
				wcuTooltipEl += out;
			}
			wcuTooltipEl += '</div>';
		} else {
			var wcuTooltipEl = '<div id="wcuCurrencyTooltip">';
			for (var x = 0; x < currencies.length; x++) {
				if (currencies[x].name === '<?php echo $this->currentCurrency?>') continue;
				var out = '';
				if (stock.length) {
					out += '<del style="opacity:.75;">';
				}
				space = ' ';
				symbol = currencies[x].symbol;
				if (stock.length) {
					price = (currencies[x].rate * maxPrice).toFixed(currencies[x].decimals);
				} else {
					price = (currencies[x].rate * minPrice).toFixed(currencies[x].decimals);
				}
				switch (currencies[x].position) {
					case 'left':
						out += symbol + price;
						break;
					case 'right':
						out += price + symbol;
						break;
					case 'left_space':
						out += symbol + space + price;
						break;
					case 'right_space':
						out += price + space + symbol;
						break;
					default:
						break;
				}
				if (stock.length) {
					out += '</del>&nbsp;';
				} else {
					out += ' - ';
				}
				if (stock.length) {
					price = (currencies[x].rate * minPrice).toFixed(currencies[x].decimals);
				} else {
					price = (currencies[x].rate * maxPrice).toFixed(currencies[x].decimals);
				}
				switch (currencies[x].position) {
					case 'left':
						out += symbol + price;
						break;
					case 'right':
						out += price + symbol;
						break;
					case 'left_space':
						out += symbol + space + price;
						break;
					case 'right_space':
						out += price + space + symbol;
						break;
					default:
						break;
				}
				out += '<br>';
				wcuTooltipEl += out;
			}
			wcuTooltipEl += "</div>";
		}
		
		
		jQuery('body').append(wcuTooltipEl);
		var wcuCurTooltip = jQuery('body').find("#wcuCurrencyTooltip");
		jQuery(wcuCurTooltip).attr('style', getMousePosition(e.pageX, e.pageY));
		mouseOnPrice = true;
		lastElement = jQuery(this);
	}
});
jQuery('body').on('mouseout','.woocommerce-Price-amount',function(e){
	if (mouseOnPrice == true) {
		setTimeout(function(){
			jQuery("#wcuCurrencyTooltip").remove();
			wcuTooltipEl = '';
		}, 50);
	}
	mouseOnPrice = false;
});

// event handler function
function getMousePosition(pageX, pageY) {
        var style = 'left: ' + pageX + 'px; top: ' + pageY + 'px;';
        return style;
}



</script>
