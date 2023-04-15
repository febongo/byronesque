jQuery(document).ready(function(){
	jQuery(document).on('click', '.supsystic-pro-notice.wcu-notification .notice-dismiss', function(){
		jQuery.sendFormWcu({
			msgElID: 'noMessages'
		,	data: {mod: 'license', action: 'dismissNotice'}
		});
	});
});
