jQuery(document).ready(function() {
    var currencyConverter = jQuery('#wcuCurrencyConverter');

    if (currencyConverter.length) {
        if (jQuery('#wpadminbar').length && currencyConverter.hasClass('top')) {
            currencyConverter.css('top', '32px')
        }
        currencyConverter.show();

		jQuery('select[name=currency_to] option:eq(1)').attr('selected', 'selected');
        jQuery("#wcuCurrencyConverter .wcuCurrencyConverterDropdown").msDropDown();

        jQuery("#wcuCurrencyConverter .wcuCurrencyConverterButton").click(function(e) {
            e.preventDefault();
            jQuery("#wcuCurrencyConverter").addClass("wcuCurrencyConverterToggleClick");
            return false;
        });

        jQuery("#wcuCurrencyConverter .wcuCurrencyConverterButtonClose").click(function(e) {
            e.preventDefault();
            jQuery("#wcuCurrencyConverter").removeClass("wcuCurrencyConverterToggleClick");
            return false;
        });

        jQuery(document).mouseup(function(e) {
            var container = jQuery("#wcuCurrencyConverter");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.removeClass("wcuCurrencyConverterToggleClick");
            }
        });

        jQuery(document).keyup(function(e){
            if(e.keyCode === 27) {
                jQuery("#wcuCurrencyConverter").removeClass("wcuCurrencyConverterToggleClick");
            }
        });

		jQuery('body').find('.ddChild').css('height', 'auto');

		jQuery('.dd').on('click', function(e){
			jQuery(this).find('.ddChild').css('height', 'auto');
		});

		jQuery("#wcuCurrencyConverter .wcuExchangeIcon").click(function(){
			jQuery(this).toggleClass("wcuRotateAnimation");
			var parent = jQuery(this).closest(".wcuCurrencyConverter");
			var from = parent.find('[name="currency_from"]');
			var to = parent.find('[name="currency_to"]');
			from = from.attr("name","currency_to");
			to = to.attr("name","currency_from");
		});



    }
});
