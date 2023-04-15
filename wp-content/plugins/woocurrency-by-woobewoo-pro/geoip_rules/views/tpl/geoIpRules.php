<table>
    <thead>
        <tr>
            <th><?php echo __('Currency name', WCU_LANG_CODE);?></th>
            <th><?php echo __('Currency country list', WCU_LANG_CODE);?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->currencyList as $currency) { ?>

			<?php
            $name = isset($currency['name']) ? $currency['name'] : '';
            $title = isset($currency['title']) ? $currency['title'] : '';
            $symbol = isset($this->currencySymbolsArr[$currency['symbol']])  ? $this->currencySymbolsArr[$currency['symbol']] : '';
            ?>
			<?php
				if ( !empty($name) && !empty( $this->optionsPro['geoip_rules']['currency_list'][$name] ) ) {
					$value = $this->optionsPro['geoip_rules']['currency_list'][$name];
				} else {
					$value = isset($this->currencyCountryListArr[$name]) ? $this->currencyCountryListArr[$name] : '';
				}
			?>
            <tr>
                <td style="min-width:150px">
                    <strong>[<?php echo $name; ?>]</strong> <?php echo $title; ?> <?php echo $symbol; ?>
                </td>
                <td>
                    <?php echo htmlWcu::selectlist("{$this->dbPrefix}[geoip_rules][currency_list][{$currency['name']}]", array(
                        'value' => $value,
                        //'data-def' => $this->params['name'],
                        'options' => $this->getCountryNameListArr,
                        'attrs' => 'class="wcuGeoIpRulesCurrenciesList"',
                    ))?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
