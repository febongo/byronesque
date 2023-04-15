<?php
class custom_cssWcu extends moduleWcu {

	public $currencyDbOpt = 'wcu_options_pro';

	public function init() {
        parent::init();
		add_action('wp_footer', array($this, 'drawCustomCss'));
	}

	public function drawCustomCss() {
		$this->getView()->getCustomCss();
	}

	public function getDefaultOptions() {
		return array(
			'toggle_css' => '',
			'field_css' => '',
		);
	}

	public function getOptionsParams() {
		return array(
			'toggle_css' => array(
				'html' => 'checkboxHiddenVal',
				'row_classes' => '',
				'row_show' => 'all',
				'row_hide' => '',
				'tooltip' => __('Customize your CSS for WooCurrency.', WCU_LANG_CODE),
				'label' => __('Enable custom CSS', WCU_LANG_CODE),
				'params' => array(
					'value'=>'1',
				),
			),
			'field_css' => array(
				'html' => 'textarea',
				'row_classes' => '',
				'row_show' => 'all',
				'row_hide' => '',
				'tooltip' => __('Type your custom CSS in this field.', WCU_LANG_CODE),
				'label' => __('Custom CSS', WCU_LANG_CODE),
				'params' => array(
					'attrs' => 'style="min-height:100px; font-size:12px;"',
				),
			),
		);
	}
}
