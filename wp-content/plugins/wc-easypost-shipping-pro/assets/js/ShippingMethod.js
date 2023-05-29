(function () {
	function ShippingMethod()
	{
		jQuery(document).on('change', '.advanced-settings-toggle', function (event) {
			this.syncAdvancedSettingsWith(event.target);
		}.bind(this));

		jQuery(document).ready(function () {
			this.onReady();
		}.bind(this));

		jQuery(document).on('switchify', function () {
			jQuery('[type=checkbox]').not('.switchified,[class=my-check-column] input[type=checkbox]').switchify();
		});
	}

	ShippingMethod.prototype.syncAdvancedSettingsWith = function (toggleElement) {
		if (jQuery(toggleElement).is(':checked')) {
			jQuery('body').addClass('display-advanced-settings');
		} else {
			jQuery('body').removeClass('display-advanced-settings');
		}
	};

	ShippingMethod.prototype.onReady = function () {
		jQuery(document).trigger('switchify');

		jQuery('.advanced-setting').each(function () {
			let target = jQuery(this);
			let parent = target.parents('tr');
			if (parent.length > 0) {
				target.removeClass('advanced-setting');
				parent.addClass('advanced-setting');
			}
		});

		this.syncAdvancedSettingsWith(jQuery('.advanced-settings-toggle'));
	};

	(new ShippingMethod());
})();