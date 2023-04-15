jQuery(document).ready(function(){
	jQuery('#wcuLicenseForm').submit(function(){
		jQuery(this).sendFormWcu({
			btn: jQuery(this).find('button.button-primary')
		,	onSuccess: function(res) {
				if(!res.error) {
					toeReload();
				}
			}
		});
		return false;
	});
});
