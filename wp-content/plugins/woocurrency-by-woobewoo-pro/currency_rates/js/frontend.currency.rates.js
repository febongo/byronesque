jQuery(document).ready(function() {
    var currencyRates = jQuery('#wcuCurrencyRates');

    if (currencyRates.length) {

        if (jQuery('#wpadminbar').length && currencyRates.hasClass('top')) {
            currencyRates.css('top', '32px')
        }
        currencyRates.show();

        jQuery("#wcuCurrencyRates .wcuCurrencyRatesButton").click(function(e) {
            e.preventDefault();
            jQuery("#wcuCurrencyRates").addClass("wcuCurrencyRatesToggleClick");
            return false;
        });

        jQuery("#wcuCurrencyRates .wcuCurrencyRatesButtonClose").click(function(e) {
            e.preventDefault();
            jQuery("#wcuCurrencyRates").removeClass("wcuCurrencyRatesToggleClick");
            return false;
        });

        jQuery(document).mouseup(function(e) {
            var container = jQuery("#wcuCurrencyRates");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                container.removeClass("wcuCurrencyRatesToggleClick");
            }
        });

        jQuery(document).keyup(function(e){
            if(e.keyCode === 27) {
                jQuery("#wcuCurrencyRates").removeClass("wcuCurrencyRatesToggleClick");
            }
        });

    }

	jQuery('body').find('.ddChild').css('height', 'auto');

	jQuery('.dd').on('click', function(e){
		jQuery(this).find('.ddChild').css('height', 'auto');
	});

    jQuery(".wcuCurrencyRatesSelectDropdown").msDropDown();

    var select = jQuery('#wcuCurrencyRates [name="wcu_currency_rates"]'),
        list = jQuery('.wcuCurrencyRatesTableCurrencies tr');

    select.on('change', function() {
        var shell = jQuery(this).closest('.wcuCurrencyRates'),
            current = shell.find('[name="wcu_currency_rates"]').val();
        list.removeClass("wcuCurrencyRatesTrActive").removeClass("wcuCurrencyRatesTrActiveOdd");
        list.find('.wcuCurrencyRateVal').html('loading...');
        jQuery.sendFormWcu({
            data: {
                mod: 'currency_widget',
                action: 'getCurrencyRatesList',
                current: current
            },
            onSuccess: function(res) {
                if (!res.error) {
                    list.each(function() {
                        var self = jQuery(this);

                        if (self.data('currency') == current) {
                            self.hide();
                        } else {
                            self.show();
                            self.addClass('wcuCurrencyRatesTrActive');
                        }
                        self.find('.wcuCurrencyRateVal').html(res.data.rates[self.data('currency')]);
                    });
                    var list2 = jQuery(".wcuCurrencyRatesTrActive");
                    list2.each(function(index) {
                        if (index % 2 == 0) {
                            var self = jQuery(this);
                            self.addClass("wcuCurrencyRatesTrActiveOdd");
                        }
                    });

                }
            }
        });
    });

    select.trigger('change');

});
