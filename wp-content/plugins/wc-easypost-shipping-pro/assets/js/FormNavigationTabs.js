class FormNavigationTabs
{
	/**
	 * @type {string}
	 * @private
	 */
	firstTabId = null;

	/**
	 * @type {HTMLElement}
	 * @private
	 */
	currentTab = null;

	/**
	 * @type {string}
	 * @private
	 */
	pageHeaderSelector = '.wrap > form > H2';

	/**
	 * @type {string}
	 * @private
	 */
	tabContentHeaderSelector = 'H3.tab';

	/**
	 * @type {string}
	 * @private
	 */
	navigationTabsContainerClassName = 'nav-tab-wrapper';

	/**
	 * @type {string}
	 * @private
	 */
	tabClassName = 'nav-tab';

	/**
	 * @type {string}
	 * @private
	 */
	activeTabClassName = 'nav-tab-active';

	/**
	 * creates form navigation tabs
	 *
	 * @returns {void}
	 * @public
	 */
	create()
	{
		this.addTabNavigation();
		this.showTabSelectedInUrl();
	}

	/**
	 * handles click on a tab
	 *
	 * @param {Event} event
	 * @returns {void}
	 * @public
	 */
	onTabClick(event)
	{
		event.preventDefault();

		if (this.target === this.currentTab) {
			return;
		}

		if (this.currentTab) {
			this.hideTab(this.currentTab);
		}

		this.showTab(event.target);
		this.currentTab = event.target;

		history.pushState(null, null, event.target.getAttribute('href'));
	}

	/**
	 * shows the tab that is selected in the URL
	 *
	 * @returns {void}
	 * @private
	 */
	showTabSelectedInUrl()
	{
		let currentTabId = window.location.hash.replace('#', '');
		if (!currentTabId || currentTabId.length === 0) {
			currentTabId = this.firstTabId;
		}

		document.querySelector(`a.${this.tabClassName}.${currentTabId}`).click();
	}

	/**
	 * creates tab navigation
	 *
	 * @returns {void}
	 * @private
	 */
	addTabNavigation()
	{
		const tabHeaders = this.createListOfTabHeaders();
		if (tabHeaders.length === 0) {
			return;
		}

		this.firstTabId = tabHeaders[0].id;

		const navigationTabs = this.addTabNavigationContainer();

		tabHeaders.forEach((tabHeader) => {
			const tab = this.createTabElement(tabHeader);
			navigationTabs.appendChild(tab);

			this.hideTab(tab);
		});
	}

	/**
	 * adds a tab navigation container
	 *
	 * @returns {HTMLDivElement} tab navigation container
	 * @private
	 */
	addTabNavigationContainer()
	{
		const h2 = document.querySelector(this.pageHeaderSelector);
		if (!h2) {
			return;
		}

		const elementAfterH2 = h2.nextElementSibling;
		if (elementAfterH2.classList.contains(this.navigationTabsContainerClassName)) {
			return elementAfterH2;
		}

		const navigationTabs = document.createElement('div');
		navigationTabs.classList.add(this.navigationTabsContainerClassName);

		h2.parentNode.insertBefore(navigationTabs, elementAfterH2);

		return navigationTabs;
	}

	/**
	 * creates a list of tab headers
	 *
	 * @returns {Array} list of tabs
	 * @private
	 */
	createListOfTabHeaders()
	{
		const tabContentHeaders = document.querySelectorAll(this.tabContentHeaderSelector);
		const tabs = [];

		tabContentHeaders.forEach((tab) => {
			tabs.push({
				id: tab.id,
				text: tab.textContent,
			});
		});

		return tabs;
	}

	/**
	 * creates a tab navigation
	 *
	 * @param {object} tab {id: string, text: string}
	 * @returns {HTMLAnchorElement} tab element
	 * @private
	 */
	createTabElement(tab)
	{
		const tabElement = document.createElement('a');

		tabElement.setAttribute('href', `#${tab.id}`);
		tabElement.classList.add(this.tabClassName);
		tabElement.classList.add(tab.id);
		tabElement.textContent = tab.text;
		tabElement.addEventListener('click', this.onTabClick.bind(this));

		return tabElement;
	}

	/**
	 * shows a tab
	 *
	 * @param {HTMLAnchorElement} tabId
	 * @returns {void}
	 * @private
	 */
	showTab(tab)
	{
		tab.classList.add(this.activeTabClassName);

		const tabContentHeader = document.getElementById(this.getTabId(tab));
		this.showTabContent(tabContentHeader);
	}

	/**
	 * hides a tab
	 *
	 * @param {HTMLAnchorElement} tabId
	 * @returns {void}
	 * @private
	 */
	hideTab(tab)
	{
		tab.classList.remove(this.activeTabClassName);

		const tabContentHeader = document.getElementById(this.getTabId(tab));
		this.hideTabContent(tabContentHeader);
	}

	/**
	 * returns the id of a tab
	 *
	 * @param {HTMLAnchorElement} tab
	 * @returns {string} tab id
	 * @private
	 */
	getTabId(tab)
	{
		return tab.getAttribute('href').replace('#', '');
	}

	/**
	 * shows tab content
	 *
	 * @param {HTMLElement} tabContentHeader
	 * @returns {void}
	 * @private
	 */
	showTabContent(tabContentHeader)
	{
		let nextElement = tabContentHeader;

		while (nextElement) {
			this.showElement(nextElement);

			nextElement = nextElement.nextElementSibling;

			if (this.isNextTabContentHeader(nextElement)) {
				return;
			}
		}
	}

	/**
	 * hides tab content
	 *
	 * @param {HTMLElement} tabContentHeader
	 * @returns {void}
	 * @private
	 */
	hideTabContent(tabContentHeader)
	{
		let nextElement = tabContentHeader;

		while (nextElement) {
			this.hideElement(nextElement);

			nextElement = nextElement.nextElementSibling;

			if (this.isNextTabContentHeader(nextElement)) {
				return;
			}

			if (nextElement.classList.contains('submit')) {
				return;
			}
		}
	}

	/**
	 * checks if an element is a tab content header
	 *
	 * @param {HTMLElement} nextElement
	 * @returns {boolean}
	 * @private
	 */
	isNextTabContentHeader(nextElement)
	{
		return (
			nextElement &&
			nextElement.matches(this.tabContentHeaderSelector)
		);
	}

	/**
	 * shows an element
	 *
	 * @param {HTMLElement} element
	 * @returns {void}
	 * @private
	 */
	showElement(element)
	{
		element.style.display = '';
	}

	/**
	 * hides an element
	 *
	 * @param {HTMLElement} element
	 * @returns {void}
	 * @private
	 */
	hideElement(element)
	{
		element.style.setProperty('display', 'none', 'important');
	}
}