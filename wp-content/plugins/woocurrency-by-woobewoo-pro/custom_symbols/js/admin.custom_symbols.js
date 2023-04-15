jQuery(document).ready(function() {
    jQuery(".wcuCurrencySymbolEdit").on('click', function (e) {
        if (jQuery(this).closest(".wcuCurrencyCol").find(".wcuCurrencyUserSymbol").is(":hidden")) {
            jQuery(this).removeClass("dashicons-edit").addClass("dashicons-no-alt");
            jQuery(this).parent(".wcuCurrencyCol").find(".wcuCurrencySymbol").hide()
            jQuery(this).parent(".wcuCurrencyCol").find(".wcuCurrencyUserSymbol").show();
        } else {
            jQuery(this).addClass("dashicons-edit").removeClass("dashicons-no-alt");
            jQuery(this).parent(".wcuCurrencyCol").find(".wcuCurrencySymbol").show()
            jQuery(this).parent(".wcuCurrencyCol").find(".wcuCurrencyUserSymbol").hide();
        }
    });
});
