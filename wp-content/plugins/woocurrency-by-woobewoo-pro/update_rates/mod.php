<?php
class update_ratesWcu extends moduleWcu {

	public function init() {
		parent::init();
		add_filter('cron_schedules', array($this, 'addCronSchedules'));
		add_action('init', array($this, 'initMainSchedules'), 999);
	}

	public function initMainSchedules() {
		
		$currentFreq = wp_get_schedule('update_rates_schedule');
		$timeFreq = $this->getModel()->getUpdateFreq();

		add_action('update_rates_schedule', array($this, 'updateRates'));

		if ( $timeFreq === 'disabled' ) {
			wp_unschedule_event(wp_next_scheduled('update_rates_schedule'),'update_rates_schedule');
		}

		if ( $timeFreq !== 'disabled' && $currentFreq !== $timeFreq ) {
			wp_unschedule_event(wp_next_scheduled('update_rates_schedule'),'update_rates_schedule');
			if (!wp_next_scheduled('update_rates_schedule')) {
				wp_schedule_event(time(), $timeFreq, 'update_rates_schedule');
			}
		}

	}

	public function updateRates() {
		$this->getModel()->updateRates();
	}

	public function addCronSchedules($param) {
		$min = 60;
		$hour = 60 * $min;
		return array_merge($param, array(
			'one_min' => array(
				'interval' => $min,
				'display' => __('Once every minute', WCU_LANG_CODE)
			),
			'one_hour' => array(
				'interval' => $hour,
				'display' => __('Once every hour', WCU_LANG_CODE)
			),
			'half_day' => array(
				'interval' => 12 * $hour,
				'display' => __('Once every 12 hours', WCU_LANG_CODE)
			),
			'daily' => array(
				'interval' => 24 * $hour,
				'display' => __('Once every day', WCU_LANG_CODE)
			),
			'weekly' => array(
				'interval' => 7 * 24 * $hour,
				'display' => __('Once every week', WCU_LANG_CODE)
			),
		));
	}

}
