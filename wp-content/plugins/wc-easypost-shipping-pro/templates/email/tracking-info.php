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

if ($shipments) :
	?>
<h2><?php echo __('Tracking Information', $id); ?></h2>
<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<thead>
		<tr>
			<th scope="col" class="td" style="text-align: left;"><?php _e('Tracking Number', $id); ?></th>
			<th scope="col" class="td" style="text-align: left;"><?php _e('Status', $id); ?></th>
			<th scope="col" class="td" style="text-align: left;"><?php _e('Date', $id); ?></th>
			<th scope="col" class="td" style="text-align: left;">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($shipments as $shipment) {
		?>
		<tr>
			<td data-title="<?php _e('Tracking Number', $id); ?>" class="td" style="text-align: left;">
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
			<td data-title="<?php _e('Status', $id); ?>" class="td" style="text-align: left;">
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
			<td data-title="<?php _e('Date', $id); ?>" class="td" style="text-align: left;">
				<time datetime="<?php echo date_i18n('Y-m-d', strtotime($shipment['ship_date'])); ?>" title="<?php echo date_i18n('Y-m-d', strtotime($shipment['ship_date'])); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($shipment['ship_date'])); ?></time>
			</td>
			<td data-title="<?php _e('Track', $id); ?>" class="td" style="text-align: left;">
				<a href="<?php echo esc_url((is_user_logged_in() || empty($shipment['tracking_url'])) ? $viewOrderUrl : $shipment['tracking_url']); ?>" target="_blank"><?php _e('Track', $id); ?></a>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>
<br/>
	<?php
endif;
