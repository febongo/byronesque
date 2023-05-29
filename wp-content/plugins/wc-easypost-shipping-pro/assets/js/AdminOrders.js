(function (settings) {
	function AdminOrders(settings)
	{
		this.settings = settings;
		this.lastNoticeElement = jQuery();
		this.labelLoaderPage = new LabelLoaderPage(settings.id);

		jQuery(document).on('submit', '#posts-filter', this.onFormSubmit.bind(this));
		jQuery(document).on('click', '#doaction, #doaction2', this.onActionButtonClick.bind(this));
		jQuery(document).on('click', '.' + this.settings.id + '.adminOrders input', this.onClick.bind(this));
		jQuery(document).on('click', '.' + this.settings.id + '.adminOrders', this.onClick.bind(this));
		jQuery(document).on('click', '.' + this.settings.id + '.adminOrders button.submit', this.onUpdateOrder.bind(this));
	}

	AdminOrders.prototype.onFormSubmit = function () {
		this.setUpdateOrderFieldsDisabled(true);
	};

	AdminOrders.prototype.onActionButtonClick = function (event) {
		this.lastNoticeElement.remove();

		var form = jQuery('#posts-filter');
		var action = form.find('[name=action]').val();
		if (action == "-1") {
			action = form.find('[name=action2]').val();
		}

		if (action.indexOf(this.settings.id) >= 0) {
			if (action.indexOf('download') >= 0) {
				this.labelLoaderPage.open();
			}
			this.submitAction(event, action);

			form.find('[name=action]').val('-1');
			form.find('[name=action2]').val('-1');
			form.find('[name="post[]"]').prop("checked", false);

			return false;
		}

		return true;
	};

	AdminOrders.prototype.onClick = function (event) {
		event.preventDefault();
		event.stopPropagation();

		return false;
	};

	AdminOrders.prototype.submitAction = function (event, action) {
		this.setUpdateOrderFieldsDisabled(true);

		var form = jQuery('#posts-filter');
		var data = this.getRequestData(action, form.find(':input').not('button,:disabled,[name=action],[name=action2]').serialize());

		this.block(jQuery('.wrap'));
		var _this = this;
		jQuery.post(ajaxurl, data, function (response) {
			_this.onSubmitActionResponse(response);
		});
	}

	AdminOrders.prototype.onSubmitActionResponse = function (response) {
		var responseElement = jQuery('<div>' + response + '</div>');

		var dataElement = responseElement.find('a[href].postageLabelsAndForms.' + this.settings.id);
		if (dataElement.length > 0) {
			var url = dataElement.attr('href');
			if (url && url.length > 0) {
				this.labelLoaderPage.navigate(url);
			}
		} else {
			this.labelLoaderPage.close();
		}

		if (responseElement.find('.notice').length > 0) {
			jQuery(window).scrollTop(0);
			this.lastNoticeElement = responseElement.find('.notice');
			this.lastNoticeElement.insertBefore(jQuery('.subsubsub').prev('h2.screen-reader-text'));
		} else {
			this.lastNoticeElement = jQuery();
		}

		this.displayAllOrderShipments(responseElement.find('[data-order_id].orderShipments.' + this.settings.id));

		this.setUpdateOrderFieldsDisabled(false);

		this.unblock(jQuery('.wrap'));
	};


	AdminOrders.prototype.displayAllOrderShipments = function (orderShipmentsElements) {
		var _this = this;
		orderShipmentsElements.each(function (idx, orderShipmentsElement) {
			_this.displayOrderShipments(jQuery(orderShipmentsElement));
		});
	};

	AdminOrders.prototype.displayOrderShipments = function (orderShipmentsElement) {
		var orderId = orderShipmentsElement.data('order_id');
		var targetElement = jQuery('[data-order_id="' + orderId + '"].orderShipments.' + this.settings.id);
		if (targetElement.length > 0) {
			var _this = this;
			orderShipmentsElement.find('[data-order_id][data-shipment_id].orderShipment.' + this.settings.id).each(function (idx, orderShipmentElement) {
				_this.displayOrderShipment(jQuery(orderShipmentElement));
			});
		} else {
			var cellElement = jQuery('#post-' + orderId).find('.shipment_tracking');
			cellElement.find('.' + this.settings.id + '.adminOrders').remove();
			cellElement.append(orderShipmentsElement.prop('outerHTML'));
		}
	};

	AdminOrders.prototype.displayOrderShipment = function (orderShipmentElement) {
		var orderId = orderShipmentElement.data('order_id');
		var shipmentId = orderShipmentElement.data('shipment_id');

		var targetElement = jQuery('[data-order_id="' + orderId + '"][data-shipment_id="' + shipmentId + '"].orderShipment.' + this.settings.id);
		if (targetElement.length > 0) {
			targetElement.html(orderShipmentElement.html());
		} else {
			targetElement = jQuery('[data-order_id="' + orderId + '"].orderShipments.' + this.settings.id);
			if (targetElement.length > 0) {
				targetElement.append(orderShipmentElement);
			}
		}
	};

	AdminOrders.prototype.onUpdateOrder = function (event) {
		jQuery('.adminOrders > .error, .adminOrders > .updated').remove();

		var form = jQuery(event.target).closest('.adminOrders');
		var data = this.getRequestData(this.settings.id + '_updateOrders', form.find(':input').not('button').serialize());

		this.block(form);

		var _this = this;
		jQuery.post(ajaxurl, data, function (response) {
			_this.onUpdateOrderResponse(event, response);
		});

		return false;
	};

	AdminOrders.prototype.onUpdateOrderResponse = function (event, response) {
		var form = jQuery(event.target).closest('.adminOrders');
		if (response.length > 0) {
			form.prepend(response);

			if (jQuery(response).hasClass('updated')) {
				form.find('.add.submit.button').css({'display': 'none'});
				form.find('.update.submit.button').css({'display': 'inline-block'});
			}
		}

		this.unblock(form);
	};

	AdminOrders.prototype.getRequestData = function (action, data) {
		return 'action=' + action
				+ '&' + this.settings.id + '_nonce=' + jQuery('#_wpnonce').val()
				+ '&' + data;
	};

	AdminOrders.prototype.block = function (target) {
		target.block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});
	};

	AdminOrders.prototype.unblock = function (target) {
		target.unblock();
	};

	AdminOrders.prototype.setUpdateOrderFieldsDisabled = function (disabled) {
		var inputFields = jQuery('.adminOrders :input');
		inputFields.prop('disabled', disabled);
	};

	new AdminOrders(settings);
})(adminorders_settings);	