<?php
$disabled = empty($this->params) ? 'disabled="disabled" ' : '';
$readonly = isset($this->params['etalon']) && $this->params['etalon'] ? 'readonly="readonly" ' : '';?>
<div class="wcuRowFlex">
	<?php
	echo htmlWcu::selectbox("{$this->dbPrefix}[exchange_fee_sign][]", array(
		'value' => isset($this->params['exchange_fee_sign']) ? $this->params['exchange_fee_sign'] : 0,
		'options' => $this->options,
		'attrs' => $disabled . 'class="wcuExchangeFeeSign"',
	));
	echo htmlWcu::input("{$this->dbPrefix}[exchange_fee][]", array(
		'type' => 'text',
		'value' => !empty($this->params['exchange_fee']) ? $this->params['exchange_fee'] : 0,
		'attrs' => $disabled . 'class="wcuExchangeFee wcuOnlyNumbers"' . $readonly,
	));?>
</div>