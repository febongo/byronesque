					<?php echo htmlWcu::input("{$this->dbPrefixSymbols}[user_symbol_".$this->currName."]", array(
								'type' => 'text',
								'value' => !empty($this->currenciesSymbols["user_symbol_".$this->currName.""]) ? $this->currenciesSymbols["user_symbol_".$this->currName.""] : '',
								'attrs' => 'class="wcuCurrencyUserSymbol" style="display:none"',
					))?>
