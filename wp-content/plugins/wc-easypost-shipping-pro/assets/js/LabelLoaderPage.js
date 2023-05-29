if (typeof LabelLoaderPage === 'undefined') {
	var LabelLoaderPage;
}

LabelLoaderPage = LabelLoaderPage || class
{
	constructor(id)
	{
		this.id = id;
		this.targetWindow = null;
	}

	open()
	{
		this.close();
		this.targetWindow = window.open(this.getPageLoaderUrl(), '');
	}

	close()
	{
		if (this.targetWindow != null) {
			this.targetWindow.close();
			this.targetWindow = null;
		}
	}

	navigate(url)
	{
		if (url && url.length > 0 && this.targetWindow != null) {
			this.targetWindow.location.href = url;
		}
	}

	getPageLoaderUrl()
	{
		let url = window.location.href;
		let pos = url.indexOf('?');
		if (pos >= 0) {
			url = url.substring(0, pos);
		}
		url += '?page=' + this.id + '_label_loader';

		return url
	};
}