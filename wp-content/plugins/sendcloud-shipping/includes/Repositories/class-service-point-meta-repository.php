<?php

namespace Sendcloud\Shipping\Repositories;

use Sendcloud\Shipping\Models\Service_Point_Meta;

class Service_Point_Meta_Repository {
	const SERVICE_POINT_META_FIELD_NAME = 'sendcloudshipping_service_point_meta';

	/**
	 * Get service point based on order id
	 *
	 * @param $order_id
	 *
	 * @return Service_Point_Meta|null
	 */
	public function get( $order_id ) {
		$data = get_post_meta( $order_id, self::SERVICE_POINT_META_FIELD_NAME );
		if ( ! $data ) {
			return null;
		}

		return Service_Point_Meta::from_array( $data[0] );
	}

	/**
	 * Update service point
	 *
	 * @param $order_id
	 * @param Service_Point_Meta $service_point
	 *
	 */
	public function save( $order_id, $service_point ) {
		update_post_meta(
			$order_id,
			self::SERVICE_POINT_META_FIELD_NAME,
			$service_point->to_array()
		);
	}
}
