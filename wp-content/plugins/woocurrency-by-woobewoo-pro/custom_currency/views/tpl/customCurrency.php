<style>
.wcuCustomCurrencyItem  {
    background-color: #ffffff;
    margin-bottom: 10px;
    padding: 10px;
}
</style>

<button class="button wcuAddCustomCurrencyButton page-title-action"><?php echo __('Add custom currency', WCU_LANG_CODE);?></button>

<div class="wcuCustomCurrencyCloneWrapper" style="display:none;">

	<div class="wcuCustomCurrencyClone wcuCustomCurrencyItem row ui-sortable-handle">

		<div class="col-md-1">
			<div class="col-xs-1" style="padding:0px;">
				<i class="fa fa-arrows-v woobewoo-tooltip tooltipstered" title="<?php echo sprintf(__('Hold the cursor on the row to change the position of the custom currency in list.', WCU_LANG_CODE))?>" style="font-size: 20px; margin-top:5px;"></i>
			</div>
			<div class="col-xs-11" align="center" style="padding:0px;">
				<?php echo htmlWcu::input("{$this->dbPrefix}[custom_currency][code][]", array(
					'type' => 'text',
					'value' => !empty($code) ? $code : '',
					'attrs' => 'class="wcuCustomCurrencyCode" disabled style="width:120px"',
					'placeholder' => 'Currency code',
				))?>
			</div>
		</div>
		<div class="col-md-1" align="center">
			<div class="col-xs-12" align="center" style="padding:0px;">
				<?php echo htmlWcu::input("{$this->dbPrefix}[custom_currency][symbol][]", array(
					'type' => 'text',
					'value' => !empty($symbol) ? $symbol : '',
					'attrs' => 'class="wcuCustomCurrencySymbol" disabled style="width:120px"',
					'placeholder' => 'Currency symbol',
				))?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="col-xs-12" style="padding:0px; padding-top:3px;">
				<button class="button wcuRemoveCustomCurrencyButton page-title-action"><i class="fa fa-minus-circle" aria-hidden="true"></i> <?php echo __('Remove', WCU_LANG_CODE);?></button>
			</div>
		</div>
		<div style="clear: both;"></div>

	</div>

</div>

<?php if (empty($this->customCurrenciesList)) {?>
	<p><?php echo __('Click "Add custom currency" to load the first custom currency.', WCU_LANG_CODE);?></p>
<?php }?>

<div class="wcuCurrencyHeader row">

	<div class="col-md-1" align="center"><?php _e('Currency code', WCU_LANG_CODE) ?></div>
	<div class="col-md-1" align="center"><?php _e('Currency symbol', WCU_LANG_CODE) ?></div>
	<div class="col-md-1"></div>
	<div style="clear: both;"></div>

</div>

<div class="wcuCustomCurrencyList">
	<?php foreach ($this->customCurrenciesList as $code => $symbol) {?>

		<div class="wcuCustomCurrencyItem row ui-sortable-handle">

			<div class="col-md-1">
				<div class="col-xs-1" style="padding:0px;">
					<i class="fa fa-arrows-v woobewoo-tooltip tooltipstered" title="<?php echo sprintf(__('Hold the cursor on the row to change the position of the custom currency in list.', WCU_LANG_CODE))?>" style="font-size: 20px; margin-top:5px;"></i>
				</div>
				<div class="col-xs-11" align="center" style="padding:0px;">
					<?php echo htmlWcu::input("{$this->dbPrefix}[custom_currency][code][]", array(
						'type' => 'text',
						'value' => !empty($code) ? $code : '',
						'attrs' => 'class="wcuCustomCurrencyCode" style="width:120px"',
						'placeholder' => 'Currency code',
					))?>
				</div>
			</div>
			<div class="col-md-1" align="center">
				<div class="col-xs-12" align="center" style="padding:0px;">
					<?php echo htmlWcu::input("{$this->dbPrefix}[custom_currency][symbol][]", array(
						'type' => 'text',
						'value' => !empty($symbol) ? $symbol : '',
						'attrs' => 'class="wcuCustomCurrencySymbol" style="width:120px"',
						'placeholder' => 'Currency symbol',
					))?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-xs-12" style="padding:0px; padding-top:3px;">
					<button class="button wcuRemoveCustomCurrencyButton page-title-action"><i class="fa fa-minus-circle" aria-hidden="true"></i> <?php echo __('Remove', WCU_LANG_CODE);?></button>
				</div>
			</div>
			<div style="clear: both;"></div>

		</div>

	<?php }?>
</div>

<script type="text/javascript">
	jQuery(".wcuCustomCurrencyList").sortable();
	jQuery(".wcuAddCustomCurrencyButton").click(function(e){
		e.preventDefault();
		var clone = jQuery(".wcuCustomCurrencyClone").first().clone();
		jQuery(".wcuCustomCurrencyList").append(clone);
		clone.find("input").each(function(){
			jQuery(this).removeAttr('disabled');
			jQuery(this).prop('disabled',false);
		});
	});
	jQuery('body').on('change', '.wcuCustomCurrencyCode', function(e){
		jQuery(this).val().toUpperCase();
	});
	jQuery('body').on('click', '.wcuRemoveCustomCurrencyButton', function(e){
		e.preventDefault();
		wcuCustomCurrencyItem = jQuery(this).closest(".wcuCustomCurrencyItem").remove();
	});
</script>
