<?php

/*********************************************************************
 *  PROGRAM          FlexRC                                          *
 *  PROPERTY         3-7170 Ash Cres                                 *
 *  OF               Vancouver BC   V6P 3K7                          *
 *  				 Voice 604 800-7879                              *
 *                                                                   *
 *  Any usage / copying / extension or modification without          *
 *  prior authorization is prohibited                                *
 *********************************************************************/

if (!defined('ABSPATH')) {
	exit;
}

$id = $id ?? '';
$shipments = $shipments ?? [];
$viewOrderUrl = $viewOrderUrl ?? '';

if (false === empty($shipments)) {
	echo '=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=';
	echo "\n";
	echo __('TRACKING INFORMATION', $id);
	echo "\n";
	echo '=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=';
	echo "\n\n";

	foreach ($shipments as $shipment) {
		if (false === empty($shipment['service']) && false === empty($shipment['rates'][$shipment['service']])) {
			$rate = $shipment['rates'][$shipment['service']];
			echo sprintf("%s: %s\n", __('Postage Type', $id), esc_html(apply_filters($id . '_service_name', $rate['postage_description'], $rate['service'])));
			echo "\n";
		}

		if (false === empty($shipment['carrier_tracking_code']) && false === empty($shipment['tracking_url'])) {
			echo sprintf(
				"%s: %s\n%s\n",
				__('Tracking Number', $id),
				esc_html($shipment['carrier_tracking_code']),
				$shipment['tracking_url']
			);
			echo "\n";
		}

		$statusName = '';
		if (false === empty($shipment['status_name'])) {
			$statusName = $shipment['status_name'];
		} elseif (false === empty($shipment['status'])) {
			$statusName = $shipment['status'];
		}

		if (false === empty($statusName)) {
			echo sprintf("%s: %s\n", __('Status', $id), esc_html($statusName));
			echo "\n";
		}
	}
	echo "\n";

	if (is_user_logged_in()) {
		echo sprintf('%s: %s', __('Track', $id), $viewOrderUrl);
		echo "\n\n";
	}

	echo '=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=';
	echo "\n\n";
}
