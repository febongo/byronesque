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

if (false === empty($shipments)) : ?>
<h2><?php _e('Tracking Information', $id); ?></h2>

<table class="shop_table shop_table_responsive <?php echo $id; ?>">
	<thead>
		<tr>
			<th><span class="nobr"><?php _e('Postage Type', $id); ?></span></th>
			<th><span class="nobr"><?php _e('Tracking Number', $id); ?></span></th>
			<th><span class="nobr"><?php _e('Status', $id); ?></span></th>
			<th><span class="nobr"><?php _e('Date', $id); ?></span></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($shipments as $shipment) {
		?>
		<tr>
			<td data-title="<?php _e('Postage Type', $id); ?>">
			<?php
			if (false === empty($shipment['service']) && false === empty($shipment['rates'][$shipment['service']])) {
				$rate = $shipment['rates'][$shipment['service']];
				echo esc_html(apply_filters($id . '_service_name', $rate['postage_description'], $rate['service']));
			} else {
				echo '-';
			}
			?>
			</td>
			<td data-title="<?php _e('Tracking Number', $id); ?>">
			<?php
			if (false === empty($shipment['carrier_tracking_code']) && false === empty($shipment['tracking_url'])) {
				echo sprintf(
					'<div><a href="%s" target="_blank">%s</a></div>',
					$shipment['tracking_url'],
					esc_html($shipment['carrier_tracking_code'])
				);
			} else {
				echo '-';
			}
			?>
			</td>
			<td data-title="<?php _e('Status', $id); ?>">
			<?php
				$statusName = '-';
			if (false === empty($shipment['status_name'])) {
				$statusName = $shipment['status_name'];
			} elseif (false === empty($shipment['status'])) {
				$statusName = $shipment['status'];
			}

				echo esc_html($statusName);
			?>
			</td>
			<td data-title="<?php _e('Date', $id); ?>" style="text-align:left; white-space:nowrap;">
				<time datetime="<?php echo date_i18n('Y-m-d', strtotime($shipment['ship_date'])); ?>" title="<?php echo date_i18n('Y-m-d', strtotime($shipment['ship_date'])); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($shipment['ship_date'])); ?></time>
			</td>
			<td style="text-align: center;">
				<button class="button" onclick="jQuery('#shipment_tracking_event_<?php echo esc_attr(preg_replace('/([:\\.])/', '\\\\\\\\$1', $shipment['id'])); ?>').toggle(); return false;"><?php _e('Track', $id); ?></button>
			</td>
		</tr>
		<?php
		if (false === empty($shipment['tracking_events'])) {
			?>
		<tr id="shipment_tracking_event_<?php echo esc_attr($shipment['id']); ?>" style="display: none">
			<td colspan="5">
				<h3><?php _e('Tracking History', $id); ?></h3>
				<table class="shop_table shop_table_responsive">
					<thead>
						<tr>
							<th><?php _e('Event', $id); ?></th>
							<th><?php _e('Description', $id); ?></th>
							<th><?php _e('Date', $id); ?></th>
						</tr>
					</thead>
					<tbody>
			<?php
			foreach ($shipment['tracking_events'] as $event) {
				if (false === empty($event['type']) && strpos($event['type'], 'buy') !== false) {
					continue;
				}
				?>
						<tr>
							<td data-title="<?php _e('Event', $id); ?>"><?php _e($event['title'], $id); ?></td>
							<td data-title="<?php _e('Description', $id); ?>"><?php _e($event['subtitle'], $id); ?></td>
							<td data-title="<?php _e('Date', $id); ?>" style="text-align:left; white-space:nowrap;">
								<time datetime="<?php echo date_i18n('Y-m-d', strtotime($event['created_at'])); ?>" title="<?php echo date_i18n('Y-m-d', strtotime($event['created_at'])); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($event['created_at'])); ?></time>
							</td>
						</tr>
				<?php
			}
			?>
					</tbody>
				</table>
			</td>
		</tr>
			<?php
		}
	}
	?>
	</tbody>
</table>

	<?php
endif;
