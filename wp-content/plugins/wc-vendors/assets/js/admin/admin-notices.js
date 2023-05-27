(function($) {
	$(document).ready(function() {
		var reviewNoticeDiv = $('#wcv-review-notice');
		var isDelay = 'no';
		var noticeKey  = reviewNoticeDiv.data('notice-key');
		reviewNoticeDiv.on('click', function(event) {
			event.preventDefault();
			let allowClickOnClass = ['notice-dismiss', 'wcv-dismiss-notice-delay', 'wcv-dismiss-notice' ];
			if (allowClickOnClass.indexOf(event.target.className) === -1) {
				return false;
			}
			if (event.target.tagName === 'A') {
				let href = event.target.getAttribute('href');
				if (href === '#') {
					isDelay = event.target.classList.contains('wcv-dismiss-notice-delay') ? 'yes' : 'no';
				} else {
					window.open(href, '_blank');
				}
			}

			//Ajax call to dismiss notice.
			$.ajax({
				url: wcv_admin_notice.ajax_url,
				type: 'POST',
				data: {
					action: 'wcvendors_dismiss_notice',
					is_delay: isDelay,
					nonce: wcv_admin_notice.nonce,
					notice_key: noticeKey
				},
				success: function(response) {
					if (response.success) {
						reviewNoticeDiv.hide(500);
					}
				}
			});
		});
	});
})(jQuery);
