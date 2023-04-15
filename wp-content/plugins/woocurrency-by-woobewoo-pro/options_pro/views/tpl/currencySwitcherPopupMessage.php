<?php
$showPopupMessage = !empty($this->params) && isset($this->params['currency_switcher']['display_rules_tab']['show_popup_message'])
	? $this->params['currency_switcher']['display_rules_tab']['show_popup_message']['params']['value'] : 0;

if (!$showPopupMessage) {
	return;
}

if ($this->userCurrency == $this->currentCurrency || empty($this->countryName)) {
	return;
}
?>
<div class="wcuCurrencySwitcherPopup">
	<a href="#closePopup" class="wcuCurrencySwitcherPopupClose">&times;</a>
	<?php echo sprintf(__('Looks like you are in the <strong>%s</strong>. Would you like to change currency?', WCU_LANG_CODE), $this->countryName); ?>
	<div class="wcuCurrencySwitcherPopupCircle"></div>
	<div class="wcuCurrencySwitcherPopupCircle2"></div>
</div>
