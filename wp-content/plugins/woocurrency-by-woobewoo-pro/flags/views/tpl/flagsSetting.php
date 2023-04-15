<style>
	.wcuFlagItem {
		background-color: #ffffff;
		margin-bottom: 10px;
		padding: 10px;
	}
	.wcuCustomFlagCloneWrapper .wcuCurrencyHeader .col-md-1 {
		padding-left:15px;
	}
</style>

<button class="button wcuAddFlagButton page-title-action"><?php echo __('Add custom flag', WCU_LANG_CODE);?></button>

<div class="wcuCustomFlagCloneWrapper" style="display:none;">

	<div class="wcuCustomFlagClone wcuFlagItem row ui-sortable-handle">

		<div class="col-md-1" style="display:none;">
				<?php echo htmlWcu::input("{$this->dbPrefix}[flags][title][]", array(
					'type' => 'text',
					'value' => !empty($title) ? $title : 'CUR_',
					'attrs' => 'class="wcuCustomFlagTitle" disabled readonly style="pointer-events: none;"',
					))?>
		</div>
		<div class="col-md-1" align="center">
			<div class="col-xs-1" style="padding:0px;">
				<i class="fa fa-arrows-v woobewoo-tooltip tooltipstered" title="<?php echo sprintf(__('Hold the cursor on the row to change the position of the flag in list.', WCU_LANG_CODE))?>" style="font-size: 20px; margin-top:5px;"></i>
			</div>
			<div class="col-xs-11" align="center" style="padding:0px;">
				<?php $img = isset($img) ? $img : $this->defFlag; ?>
				<?php if (!empty($img)) { ?>
					<img src="<?php echo $img ?>?time='<?php echo (date('h-m-s'))?>'" style="width:32px;" alt="">
				<?php } ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="col-xs-12" style="padding:0px; padding-top:3px;">

				<button disabled class="button wcuUploadFlagButton page-title-action"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo __('Press "Save changes" before upload', WCU_LANG_CODE);?></button>
				<button class="button wcuRemoveFlagButton page-title-action"><i class="fa fa-minus-circle" aria-hidden="true"></i> <?php echo __('Remove', WCU_LANG_CODE);?></button>

			</div>
		</div>
		<div style="clear: both;"></div>

	</div>

</div>

<?php if (empty($this->flagsList)) {?>
	<p><?php echo __('Click "Add custom flag" to load the first custom flag.', WCU_LANG_CODE);?></p>
<?php }?>

<div class="wcuCurrencyHeader row">
	<div class="col-md-1" style="display:none;"><?php _e('Custom flag code', WCU_LANG_CODE) ?></div>
	<div class="col-md-1" align="center"><?php _e('Custom flag image', WCU_LANG_CODE) ?></div>
	<div class="col-md-1"></div>
	<div style="clear: both;"></div>
</div>

<div class="wcuCustomFlagsList">
	<?php foreach ($this->flagsList as $title => $img) {?>
		<div class="wcuFlagItem row ui-sortable-handle">
			<div class="col-md-1" style="display:none;">
					<?php echo htmlWcu::input("{$this->dbPrefix}[flags][title][]", array(
						'type' => 'text',
						'value' => !empty($title) ? $title : 'CUR_',
						'attrs' => 'class="wcuCustomFlagTitle" readonly style="pointer-events: none;"',
						))?>
			</div>
			<div class="col-md-1" align="center">
				<div class="col-xs-1" style="padding:0px;">
					<i class="fa fa-arrows-v woobewoo-tooltip tooltipstered" title="<?php echo sprintf(__('Hold the cursor on the row to change the position of the flag in list.', WCU_LANG_CODE))?>" style="font-size: 20px; margin-top:5px;"></i>
				</div>
				<div class="col-xs-11" align="center" style="padding:0px;">
					<?php $img = !empty($img) ? $img : $this->defFlag; ?>
					<img src="<?php echo $img?>?time='<?php echo (date('h-m-s'))?>'" style="width:32px;" alt="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-xs-12" style="padding:0px; padding-top:3px;">
					<?php echo htmlWcu::imgGalleryBtn("{$this->dbPrefix}[flags][image][]", array(
						'onChange' => 'wcuGetLoadedImgLinkOnComplete',
						'value' => !empty($img) ? $img : '',
						'attrs' => 'class="button wcuFlagButtonUploadData"',
					))?>
					<button style="margin-top:2px" class="button wcuRemoveFlagButton page-title-action"><i class="fa fa-minus-circle" aria-hidden="true"></i> <?php echo __('Remove', WCU_LANG_CODE);?></button>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	<?php }?>
</div>

<p><?php echo __('We recommend using image format (jpg, png, gif, ico) with a resolution of 32x32 pixels.', WCU_LANG_CODE);?></p>

<div style="display:none">
	<?php
		//Fix for JS Notice when press submit button in Media Manager.
		wp_editor( '', 'wcuFlagUploadTextarea' );
	?>
</div>

<script type="text/javascript">
	function wcuGetLoadedImgLinkOnComplete(attachmentUrl, attachment, buttonId) {
		if (attachment !== null) {
			element = jQuery('body').find('#'+buttonId).closest(".wcuFlagItem");
			random = Math.floor(Math.random()*10);
			var url = attachmentUrl;
			url = url.substring(url.search('/wp-content'));
			element.find('img').attr('src', url+"?time='"+random+"'");
		}
	};
	function findMaxCur() {
		var max = 0;
		jQuery(".wcuCustomFlagsList .wcuFlagItem").each(function() {
			var value = jQuery(this).find(".wcuCustomFlagTitle").val().split('_').pop();
			if (value > max) {
				max = value;
			}
		});
		max = parseInt(max) + 1;
		return max;
	};
	jQuery(".wcuCustomFlagsList").sortable();
	jQuery(".wcuAddFlagButtonRow").click(function(e){
		e.preventDefault();
	});
	jQuery(".wcuAddFlagButton").click(function(e){
		e.preventDefault();
		var clone = jQuery(".wcuCustomFlagClone").first().clone();
		jQuery(".wcuCustomFlagsList").append(clone);
		clone.find("input").each(function(){
			jQuery(this).removeAttr('disabled');
			jQuery(this).prop('disabled',false);
		});
		clone.find(".wcuCustomFlagTitle").val('CUR_'+findMaxCur());
	});
	jQuery('body').on('click', '.wcuRemoveFlagButton', function(e){
		e.preventDefault();
		jQuery(this).closest(".wcuFlagItem").remove();
	});
</script>
