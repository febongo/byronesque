(function (settings) {
	function ShipmentMetaBox(settings)
	{
		this.settings = settings;
		this.labelLoaderPage = new LabelLoaderPage(settings.id);

		this.fieldsSelector =
			'#' + this.settings.metaBoxContentsId + ' :input,' +
			' .' + this.settings.id + '.itemsInParcel :input,' +
			' :input.' + this.settings.id + '.itemsInParcel';

		this.itemsInParcelElements =
			'table td.' + this.settings.id + '.itemsInParcel' +
			' ,table th.' + this.settings.id + '.itemsInParcel' +
			' ,table input.' + this.settings.id + '.itemsInParcel';

		this.orderPageElementsSelector =
			'.wc-order-item-name, .wc-order-item-sku, .wc-order-item-variation' +
			' ,th.item_cost, #order_line_items td.item_cost' +
		// exclude quantity, so customers can see the original quantity
		//	' ,th.quantity:not(.itemsInParcel), #order_line_items td.quantity:not(.itemsInParcel)' +
			' ,th.line_cost, #order_line_items td.line_cost' +
			' ,th.line_tax, #order_line_items td.line_tax' +
			' ,th.item_quantity, td.wcfm_item_qty'
			', #order_line_items table.display_meta';

		jQuery(window).on('load', this.onReady.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .showAddShipment', this.onShowAddShipmentForm.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .showLinkShipment', this.onShowLinkShipmentForm.bind(this));
		jQuery(document).on('change', '#' + this.settings.metaBoxContentsId + ' .addShipmentForm:not(.skipFetchShippingRates) :input, .' + this.settings.id + '.itemsInParcel :input', this.onChange.bind(this));
		jQuery(document).on('change', '#' + this.settings.metaBoxContentsId + ' .addShipmentForm [name="' + this.settings.id + '_package[parcelIdx]"]', this.onParcelChange.bind(this));
		jQuery(document).on('change', '#' + this.settings.metaBoxContentsId + ' .addShipmentForm [name="' + this.settings.id + '_package[cod]"]', this.onCodChange.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .fetchShippingRates', this.onFetchRates.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .refundShipment', this.onRefundShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .cancelCreateShipment', this.onCancelCreateShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .createShipment', function (event) {
			this.confirmShipmentDetails(event, this.onCreateShipment.bind(this)); }.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .buyShipment:not([data-shipment_id])', function (event) {
			this.confirmShipmentDetails(event, this.onBuyShipment.bind(this)); }.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .buyShipment[data-shipment_id]', this.onBuyShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .cancelShipment', this.onCancelShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .unlinkShipment', this.onUnlinkShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .refreshShipment', this.onRefreshShipment.bind(this));
		jQuery(document).on('click', '#' + this.settings.metaBoxContentsId + ' .linkShipment', this.onLinkShipment.bind(this));
		jQuery(document).on('change', '.' + this.settings.id + '.itemsInParcel :input', this.onItemsInParcelChange.bind(this));
	}

	ShipmentMetaBox.prototype.block = function (event) {
		event.preventDefault();

		jQuery('#' + this.settings.metaBoxContentsId + '').block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});
	};

	ShipmentMetaBox.prototype.unblock = function () {
		jQuery('#' + this.settings.metaBoxContentsId + '').unblock();
		this.scrollTop();
	};

	ShipmentMetaBox.prototype.getRequestData = function (action, data) {
		return 'action=' + this.settings.id + '_' + action
				+ '&orderId=' + this.settings.orderId
				+ '&settingsKey=' + this.settings.settingsKey
				+ '&' + this.settings.id + '_nonce=' + jQuery('#' + this.settings.id + '_nonce').val()
				+ '&' + data;
	};

	ShipmentMetaBox.prototype.clearErrors = function () {
		jQuery('#' + this.settings.metaBoxContentsId + ' .error').remove();
	};

	ShipmentMetaBox.prototype.switchFormToFetchRates = function () {
		jQuery('#' + this.settings.id + '_package\\[service\\]').parents('tr').remove();
		jQuery('#' + this.settings.metaBoxContentsId + ' button.fetchShippingRates').show();

		jQuery('#' + this.settings.metaBoxContentsId + ' button.createShipment').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' button.buyShipment').hide();
	};

	ShipmentMetaBox.prototype.switchFormToCreate = function () {
		jQuery('#' + this.settings.metaBoxContentsId + ' button.fetchShippingRates').hide();

		jQuery('#' + this.settings.metaBoxContentsId + ' button.createShipment').show();
		jQuery('#' + this.settings.metaBoxContentsId + ' button.buyShipment').show();
	};

	ShipmentMetaBox.prototype.hideAllForms = function () {
		if (jQuery('.addShipmentForm').hasClass('skipFetchShippingRates')) {
			this.switchFormToCreate();
		} else {
			this.switchFormToFetchRates();
		}

		if (this.canCreateShipment()) {
			jQuery('#' + this.settings.metaBoxContentsId + ' .showAddShipment').show();
			jQuery('#' + this.settings.metaBoxContentsId + ' .showLinkShipment').show();
		}

		jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentDetails').show();

		jQuery('#' + this.settings.metaBoxContentsId + ' .linkShipmentForm').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .addShipmentForm').hide();

		jQuery('table .' + this.settings.id + '.itemsInParcel').hide();

		this.showOrderPageElements();
	};

	ShipmentMetaBox.prototype.canCreateShipment = function () {
		if (this.settings.allowMultipleShipments != 'no' || jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentDetails').length == 0) {
			return true;
		}

		return false;
	};

	ShipmentMetaBox.prototype.cancelOthersShipmentForms = function () {
		jQuery('.shipmentMetaBoxForm').not('#' + this.settings.metaBoxContentsId + ' .shipmentMetaBoxForm').find('.cancelShipment:visible').click();
	};

	ShipmentMetaBox.prototype.showItemsInParcel = function () {
		jQuery(this.itemsInParcelElements).show();
		this.hideOrderPageElements();
	};

	ShipmentMetaBox.prototype.hideOrderPageElements = function () {
		jQuery(this.orderPageElementsSelector).hide();
	};

	ShipmentMetaBox.prototype.showOrderPageElements = function () {
		jQuery(this.orderPageElementsSelector).show();
	};

	ShipmentMetaBox.prototype.showAddShipmentForm = function () {
		this.cancelOthersShipmentForms();
		this.showItemsInParcel();
		jQuery('#' + this.settings.metaBoxContentsId + ' .addShipmentForm').show();

		jQuery('#' + this.settings.metaBoxContentsId + ' .showAddShipment').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .showLinkShipment').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentDetails').hide();

		jQuery('#' + this.settings.id + '_package\\[cod\\]').trigger('change');
		jQuery('#' + this.settings.id + '_package\\[parcelIdx\\]').trigger('change');

		this.selectFirstOptionOfSelectElements();
	};

	ShipmentMetaBox.prototype.selectFirstOptionOfSelectElements = function () {
		let elements = jQuery('#' + this.settings.metaBoxContentsId + ' select');
		for (element of elements) {
			this.selectFirstOptionOfSelectElement(element);
		}
	};

	ShipmentMetaBox.prototype.selectFirstOptionOfSelectElement = function (element) {
		if (element.options.length === 0) {
			return;
		}

		let selectedIndex = element.selectedIndex >= 0 ? element.selectedIndex : 0;
		let option = element.options[selectedIndex];

		option.selected = false;
		option.selected = 'selected';
	};

	ShipmentMetaBox.prototype.showLinkShipmentForm = function () {
		jQuery('#' + this.settings.id + '_shipment_id').val('');

		jQuery('#' + this.settings.metaBoxContentsId + ' .showAddShipment').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .showLinkShipment').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentDetails').hide();
		jQuery('#' + this.settings.metaBoxContentsId + ' .addShipmentForm').hide();

		jQuery('#' + this.settings.metaBoxContentsId + ' .linkShipmentForm').show();
	};

	ShipmentMetaBox.prototype.cancelShipmentDetails = function (shipmentId) {
		jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentDetails[data-shipment_id="' + shipmentId + '"]').remove();
	};

	ShipmentMetaBox.prototype.isResponseOk = function (response) {
		let responseElement = jQuery('<div>' + response + '</div>');
		if (responseElement.find('.error').length == 0 || responseElement.find('.shipmentDetails').length > 0) {
			return true;
		}

		return false;
	};

	ShipmentMetaBox.prototype.displayResponse = function (response) {
		if (response.trim() == '0') {
			return;
		}

		let contentsElement = jQuery('#' + this.settings.metaBoxContentsId);
		contentsElement.prepend(response);
		contentsElement.trigger('updated');
	};

	ShipmentMetaBox.prototype.buildTemplate = function (contents, placeholders) {
		for (let idx = 0; idx < placeholders.length; ++idx) {
			let placeholder = placeholders[idx];

			contents = contents.replace('{' + placeholder.placeholder + '}', placeholder.value);
		}

		contents = contents.replace(/\{[^\}]+\}/g, '');

		return contents;
	};

	ShipmentMetaBox.prototype.preparePlaceholders = function (elements) {
		let placeholders = [];
		let _this = this;
		jQuery(elements).filter('[name]').each(function () {
			let target = jQuery(this);
			let placeholder = target.attr('name').replace(_this.settings.id + '_', '');

			let value = target.val();

			if (target.is('select')) {
				value = target.find('option:selected').text();
			} else if (target.is('input[type=checkbox]')) {
				if (target.is(':checked')) {
					value = 'Y';
				} else {
					value = 'N';
				}
			}

			placeholders.push({'placeholder': placeholder, 'value': value});
		});

		return placeholders;
	}

	ShipmentMetaBox.prototype.buildConfirmationContents = function (address) {
		let placeholders = [];

		for (let key in address) {
			let placeholder = '';
			if (key == 'address') {
				placeholder = '_shipping_address_1';
			} else if (key == 'address_2') {
				placeholder = '_shipping_address_2';
			} else if (key == 'phone') {
				placeholder = '_billing_phone';
			} else {
				placeholder = '_shipping_' + key;
			}

			let value = address[key];

			placeholders.push({'placeholder': placeholder, 'value': value});
		}
		placeholders.push({'placeholder': '_shipping_first_name', 'value': ''});
		placeholders.push({'placeholder': '_shipping_last_name', 'value': ''});

		placeholders = placeholders.concat(this.preparePlaceholders('#' + this.settings.metaBoxContentsId + ' :input'));

		return this.buildTemplate(this.settings.confirmShipmentDetailsTemplate, placeholders);
	};

	ShipmentMetaBox.prototype.confirmShipmentDetails = function (event, callback) {
		if (this.settings.requireToConfirmShipmentDetails == 'no') {
			return callback(event);
		}

		let target = jQuery('<div id="shipmentMetaBox_confirmShipmentDetails"/>');
		let contents = null;
		if (jQuery('input[name="' + this.settings.id + '_package[return]"]').is(':checked')) {
			contents = this.buildConfirmationContents(this.settings.origin);
		}

		if (contents === null) {
			contents = this.buildConfirmationContents(this.settings.destination);
		}

		target.html(contents);

		jQuery('body').append(target);

		target.dialog({
			title: this.settings.confirmShipmentDetailsTitle,
			modal: true,
			width: 600,
			height: 'auto',
			resizable: false,
			close: function () {
				jQuery('<div id="shipmentMetaBox_confirmShipmentDetails"/>').remove();
			},
			buttons: [
				{
					text: this.settings.confirmButtonText,
					'class': 'button',
					click: function () {
						callback(event);
						target.dialog('close');
					}
			},
				{
					text: this.settings.cancelButtonText,
					'class': 'button',
					click: function () {
						target.dialog('close');
					}
			}
			]
		});

		jQuery('.ui-dialog-buttonset button').attr('class', 'button');
		jQuery('.ui-dialog-titlebar').removeClass('ui-widget-header ui-corner-all');

		return false;
	};

	ShipmentMetaBox.prototype.onReady = function () {
		jQuery('body').addClass('shipmentMetaBox');

		jQuery('#' + this.settings.metaBoxContentsId + ' [type=checkbox]').switchify();

		if (jQuery('#' + this.settings.metaBoxContentsId + ' .addShipmentForm.shipmentMetaBoxForm ').css('display') === 'block') {
			this.showItemsInParcel();
		}
	};

	ShipmentMetaBox.prototype.onShowAddShipmentForm = function (event) {
		event.preventDefault();
		this.showAddShipmentForm();
	};

	ShipmentMetaBox.prototype.onShowLinkShipmentForm = function (event) {
		event.preventDefault();
		this.showLinkShipmentForm();
	};

	ShipmentMetaBox.prototype.onItemsInParcelChange = function (event) {
		let parcelValue = 0;
		let itemValueElements = jQuery('.' + this.settings.id + '.itemsInParcel.value :input[data-item-id]');
		for (let nIdx = 0; nIdx < itemValueElements.length; ++nIdx) {
			let itemValueElement = jQuery(itemValueElements[nIdx]);
			let itemId = itemValueElement.data('item-id');

			let itemQuantityElement = jQuery('.' + this.settings.id + '.itemsInParcel.quantity :input[data-item-id=' + itemId + ']')

			let value = parseFloat(itemValueElement.val()) * parseFloat(itemQuantityElement.val());
			if (value > 0) {
				parcelValue += value;
			}
		}

		if (itemValueElements.length > 0) {
			jQuery('#' + this.settings.id + '_package\\[value\\]').val(parcelValue.toFixed(2));
			jQuery('#' + this.settings.id + '_package\\[cod_amount\\]').val(parcelValue.toFixed(2));
		}
	};

	ShipmentMetaBox.prototype.onParcelChange = function (event) {
		let parcels = this.settings.parcels;
		let parcelIdx = parseInt(jQuery('#' + this.settings.id + '_package\\[parcelIdx\\]').val());

		if (typeof parcels[parcelIdx] == 'undefined') {
			return;
		}

		let field = jQuery();
		let parcel = parcels[parcelIdx];

		// fill shipmentbox
		for (let key in parcel) {
			field = jQuery('[name="' + this.settings.id + '_package[' + key + ']"]');

			if (field.length > 0 && key !== 'currency') {
				field.val(parcel[key]);
			}
		}

		// fill items in parcel
		jQuery('.' + this.settings.id + '.itemsInParcel.quantity :input').val('0');

		for (let itemId in parcel['items']) {
			let itemInParcel = parcel['items'][itemId];

			field = jQuery('[name="' + this.settings.id + '_package[items][' + itemId + '][quantity]"]');
			field.val(itemInParcel['quantity']);
		}

		this.onItemsInParcelChange(event);
	};

	ShipmentMetaBox.prototype.onCodChange = function (event) {
		let target = jQuery(event.target);
		let isChecked = target.is(':checked');

		target.parents('table.form-table').find('.cod_field').each(function (idx, element) {
			let row = jQuery(element).parents('tr');
			if (isChecked) {
				row.removeClass('hide');
			} else {
				row.addClass('hide');
			}
		});
	};

	ShipmentMetaBox.prototype.onChange = function (event) {
		if (this.settings.requireToFetchShippingRates == 'no') {
			return;
		}

		let target = jQuery(event.target);
		if (target.attr('id') === (this.settings.id + '_package[service]')) {
			return;
		}

		this.switchFormToFetchRates();
	};

	ShipmentMetaBox.prototype.onFetchRates = function (event) {
		this.block(event);
		let data = this.getRequestData('fetchShippingRates', this.getSerializedFormData());

		let _this = this;
		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onFetchRatesResponse(response);
		});
	};

	ShipmentMetaBox.prototype.onFetchRatesResponse = function (response) {
		this.clearErrors();


		let element = jQuery('<table>').html(response);
		let errorElement = element.find('.error');
		if (errorElement.length > 0) {
			let errorResponse = jQuery('<div>').append(errorElement.clone()).html();
			errorElement.remove();
			this.displayResponse(errorResponse);
		}

		if (element.find('tr').length > 0) {
			this.switchFormToCreate();

			jQuery('#' + this.settings.metaBoxContentsId + ' .shipmentMetaBoxForm:visible table > tbody').prepend(element.html());
		}

		this.unblock();
	};

	ShipmentMetaBox.prototype.onRefundShipment = function (event) {
		if (!confirm(this.settings.confirmRefundText)) {
			return;
		}

		this.block(event);

		let shipmentId = jQuery(event.target).data('shipment_id');
		let data = this.getRequestData('refundShipment', 'shipmentId=' + shipmentId);

		let _this = this;
		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onShipmentResponse(shipmentId, response);
		});
	};

	ShipmentMetaBox.prototype.onCancelCreateShipment = function (event) {
		this.block(event);

		let data = this.getRequestData('cancelCreateShipment', '');

		let _this = this;
		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onCreateOrCancelResponse(response);
		});
	};

	ShipmentMetaBox.prototype.onCreateShipment = function (event) {
		this.block(event);

		let form = jQuery(event.target).closest('.addShipmentForm');

		let data = this.getRequestData('createShipment', this.getSerializedFormData());

		let _this = this;
		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onCreateOrCancelResponse(response);
		});
	};

	ShipmentMetaBox.prototype.onCreateOrCancelResponse = function (response) {
		this.clearErrors();

		this.displayResponse(response);

		if (this.isResponseOk(response)) {
			this.hideAllForms();
		}

		this.unblock();
	};

	ShipmentMetaBox.prototype.onBuyShipment = function (event) {
		this.block(event);

		let data = '';
		let target = jQuery(event.target);

		let shouldDownload = target.hasClass('download');
		if (shouldDownload) {
			this.labelLoaderPage.open();
		}

		let shipmentId = target.data('shipment_id');
		if (shipmentId) {
			data = 'shipmentId=' + shipmentId;
		} else {
			data = this.getSerializedFormData();
		}

		data = this.getRequestData('buyShipment', data);
		jQuery.post(this.settings.ajaxurl, data, function (response) {
			this.onShipmentResponse(shipmentId, response, shouldDownload);
		}.bind(this));
	};

	ShipmentMetaBox.prototype.onShipmentResponse = function (shipmentId, response, shouldDownload) {
		this.clearErrors();

		let isResponseOk = this.isResponseOk(response);

		if (isResponseOk) {
			this.cancelShipmentDetails(shipmentId);
		}

		this.displayResponse(response);

		if (isResponseOk && !shipmentId) {
			shipmentId = jQuery(response).data('shipment_id');
		}

		if (isResponseOk && shouldDownload) {
			let url = jQuery('a[data-shipment_id="' + shipmentId + '"].download').attr('href');
			if (url) {
				this.labelLoaderPage.navigate(url);
			} else {
				this.labelLoaderPage.close();
			}
		}

		if (isResponseOk) {
			this.hideAllForms();
		} else {
			this.labelLoaderPage.close();
		}

		this.unblock();
	};

	ShipmentMetaBox.prototype.onCancelShipment = function (event) {
		if (!confirm(this.settings.confirmDeleteText)) {
			return;
		}

		this.block(event);

		let shipmentId = jQuery(event.target).data('shipment_id');

		let data = this.getRequestData('cancelShipment', 'shipmentId=' + shipmentId);
		let _this = this;

		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onShipmentResponse(shipmentId, response);
		});
	};

	ShipmentMetaBox.prototype.onUnlinkShipment = function (event) {
		if (!confirm(this.settings.confirmUnlinkText)) {
			return;
		}

		this.block(event);

		let shipmentId = jQuery(event.target).data('shipment_id');

		let data = this.getRequestData('unlinkShipment', 'shipmentId=' + shipmentId);
		let _this = this;

		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onShipmentResponse(shipmentId, response);
		});
	};

	ShipmentMetaBox.prototype.onRefreshShipment = function (event) {
		let shipmentId = jQuery(event.target).data('shipment_id');

		this.refreshShipment(shipmentId);
	};

	ShipmentMetaBox.prototype.onLinkShipment = function (event) {
		let shipmentId = jQuery('#' + this.settings.id + '_shipment_id').val();

		this.refreshShipment(shipmentId);
	};

	ShipmentMetaBox.prototype.refreshShipment = function (shipmentId) {
		this.block(event);

		let data = this.getRequestData('refreshShipment', 'shipmentId=' + shipmentId);
		let _this = this;

		jQuery.post(this.settings.ajaxurl, data, function (response) {
			_this.onShipmentResponse(shipmentId, response);
		});
	};

	ShipmentMetaBox.prototype.scrollTop = function () {
		let offsetTop = jQuery('#' + this.settings.metaBoxContentsId).offset().top;

		let targetElement = jQuery('[name="' + this.settings.id + '_package[service]"]');
		if (targetElement.length > 0) {
			offsetTop = targetElement.offset().top;
			targetElement.focus();
		}

		// reduce on the average height of the sticky header
		offsetTop -= 300;

		jQuery([document.documentElement, document.body]).animate({
			scrollTop: offsetTop
		});
	};

	ShipmentMetaBox.prototype.getSerializedFormData = function () {
		let elements = jQuery(this.fieldsSelector).not('button');

		// some plugins can change value of unchecked checkboxes to NO
		elements.filter('[type="checkbox"]:checked').val('1');

		return elements.serialize();
	};

	new ShipmentMetaBox(settings);
})(shipmentmetabox_settings);
