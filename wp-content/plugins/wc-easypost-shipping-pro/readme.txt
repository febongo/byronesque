=== EasyPost Shipping PRO for WooCommerce ===
Contributors: OneTeamSoftware
Tags: woocommerce, EasyPost, cart, shipping, ebay, amazon, marketplace, woocommerce shipping, EasyPost shipping, woocommerce EasyPost shipping, cart shipping rate, shipping rate
Text Domain: wc-easypost-shipping
Requires at least: 5.6
Tested up to: 6.2
Requires PHP: 7.3
Stable tag: 2.1.7
WC requires at least: 6.0
WC tested up to: 7.6
Copyright: © 2023 FlexRC, 3-7170 Ash Cres, V6P 3K7, Canada. Voice 604 800-7879 
License: Any usage / copying / extension or modification without prior authorization is prohibited

Multi-Carrier EasyPost Shipping PRO plugin for WooCommerce displays live shipping rates at cart / checkout pages based on the store or Marketplace / Dokan vendor’s location, streamlines creation of shipping labels, displays tracking history to WooCommerce admins and customers, automatically emails shipment status updates to the customers.

== Description ==
EasyPost Shipping PRO for WooCommerce plugin is the most flexible shipping solution on the market that lets your WooCommerce store to easily integrate with 100+ carriers worldwide by automatically packing items into boxes, displaying accurate real-time shipping rates at the cart / checkout pages, automating creation of shipping labels, providing easy access to the tracking information and automatically sending shipment tracking updates for USPS, Canada Post, Fedex, UPS, Pulorator, DHL and many other carriers. 


== Features ==
* Support of 100+ carriers worldwide
* Live shipping rates at WooCommerce cart & checkout
* Require valid shipping address, before allowing to place an order
* Use WooCoommerce store or Marketplace / Dokan vendor’s location as the originating address for accurate shipping rates
* Dimension and weight based packing of the items into configurable boxes
* Ability to combine parcels to get better shipping rates
* Accommodate your packaging and marketing material with flexible package weight adjustments
* Charge extra handling fee or implement currency conversion with flexible shipping rate adjustments
* Include Insurance and Request Signature service
* Display different name for selected shipping services
* Allow all or only selected shipping services
* Configurable purchase postage workflow
* Create return shipping labels
* Buy shipping labels in one click per order or in bulk
* Link previously created shipments to orders
* Easy access to tracking history for admins and customers
* Automatically notify customers about progress of their shipment
* Test your setup before going into production by running in the sandbox
* Easily find issues by enabling debug mode
* Speed up your website by caching and re-using previously found rates

== Supported Carriers ==
* AmazonMws
* APC
* Aramex
* ArrowXL
* Asendia
* Australia Post
* AxlehireV3
* BorderGuru
* Cainiao
* Canada Post
* Canpar
* CDL Last Mile Solutions
* Chronopost
* Colis Privé
* Colissimo
* Couriers Please
* Dai Post
* Deliv
* Deutsche Post
* Deutsche Post UK
* DHL eCommerce Asia
* DHL Express
* DHL Freight
* DHL Germany
* DHL eCommerce
* DHL eCommerce International
* Dicom
* Direct Link
* Doorman
* DPD
* DPD UK
* China EMS
* Estafeta
* Estes
* Fastway
* FedEx
* FedEx Mailview
* FedEx SameDay City
* FedEx UK
* FedEx SmartPost
* FirstMile
* Globegistics
* GSO
* Hermes
* Hong Kong Post
* Interlink Express
* Janco Freight
* JP Post
* Kuroneko Yamato
* La Poste
* LaserShipV2
* Latvijas Pasts
* Liefery
* Loomis Express
* LSO
* Network4
* Newgistics
* Norco			
* OmniParcel
* OnTrac
* OnTrac DirectPost
* Orange DS
* Osm Worldwide
* Parcelforce
* Passport
* Pilot
* PostNL
* Posten
* PostNord
* Purolator
* Royal Mail
* RR Donnelley
* Seko
* Singapore Post
* Spee-Dee
* SprintShip
* StarTrack
* Toll
* TForce
* UDS
* Ukrposhta
* UPS i-parcel
* UPS Mail Innovations
* UPS
* USPS
* Veho
* Yanwen
* Yodel


== Installation ==
1. Go to Wordpress -> Plugins -> Add New
2. Hit **Upload Plugin** button
3. Hit **Choose File** button and select zip file with the plugin
4. Hit **Install Now** button
5. Hit **Activate** link
6. Installation complete

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==
= 2.1.7 2023-05-21 =
* Fixed the plugin to utilize the "default shipping service" when purchasing shipping labels in bulk for orders that do not have a shipping service selected.
= 2.1.6 2023-05-18 =
* Updated the plugin to retain shipment data even when tracking services are temporarily unavailable or inaccessible. This enhancement prevents the removal of shipments due to intermittent service disruptions.
= 2.1.5 2023-05-12 =
* Enhanced functionality with the integration of support for U.S. military addresses
* Resolved issues related to address validation for improved data accuracy
* Discontinued the page condition feature due to instability and challenges in feasible optimization
* Optimized system efficiency by decreasing default import/export timeouts to 1 hour
= 2.1.4 2023-04-15 =
* Updated to cache results even when no shipping rates are returned. This change prevents repetitive API requests for invalid addresses, optimizing the overall performance.
= 2.1.3 2023-04-07 =
* Resolved an issue where the tracking information on the "My Account" page was not displaying the correct date.
* Modified the email template for guest users so that it directs them to the carrier's tracking page instead of their account page.
* Rectified an issue where disabled shipping zone fields were still being processed, which has now been fixed.
= 2.1.2 2023-03-17 =
* Fixed overwriting of the country of origin when printing a shipping label from woocommerce admin.
= 2.1.1 2023-03-12 =
* Fixed an issue where error messages weren't displaying properly when you saved your settings.
* Added a link to the plugin installation services in the settings of the plugin.
* Now you can view the original quantity of the products in the order details when preparing a shipping label.
= 2.1.0 2023-02-18 =
* The plugin settings are now organized into separate tabs for better usability.
* Added a "Use Vendor Settings" option to the plugin. This option enables administrators to print labels using vendor-specific settings from our "Shipping Labels for WCFM/Dokan" add-ons.
= 2.0.19 2023-01-26 =
* Some cases were not having insurance purchased. This issue has now been fixed.
* The problem of printing shipping labels for orders with items from different vendors has been resolved.
* The problem of errors not being communicated when printing label has failed has been fixed.
* Improved compatibility with Shipping Labels for WCFM and Dokan plugins.
= 2.0.18 2023-01-21 =
* Fixed services matching issue when multiple conditions are specified
= 2.0.17 2023-01-18 =
* Updated compatibility and security
* Updated language file
= 2.0.16 2022-12-29 =
* Fixed product attribute conditions for the services
= 2.0.15 2022-12-24 =
* Improved compatibility with other plugins
* Changed default cache expiration to 24 hours
= 2.0.14 2022-12-17 =
* Improved backward compatibility with PHP v7.3
* Added possibility to download debug log with a single click
= 2.0.13 2022-11-29 =
* Updated plugin to use the latest rules library
* Changed to remove empty properties when interacting with API to avoid possible misinterpretation of them by some carriers
* Fixed missing Delivery Time option in the settins of the plugin
* Added support for customization of the product name for customs
* Added ability to multiply rate cost by zero to achieve free shipping
* Changed so that resulting rate cost after adding an adjustment value to it won't go below zero
* Added possibility to specify order processing time
= 2.0.12 2022-11-09 =
* Changed to send empty Signature attribute when No Signature is selected, so CanadaPost won't international shipments won't be affected
= 2.0.11 2022-11-03 =
* Use COMPANY name for the name when NAME field is blank, it is required by some carriers to work and plugin can't know in advance which ones require it
* Updated language file
* Various improvements and bug fixes
= 2.0.10 2022-10-20 =
* Fixed packing when items and boxes has dimensions/weight/volume with the precision more than 2
= 2.0.9 2022-10-08 =
* Renamed Add Shipment to Create Shipping Label
* Fixed a bug that Validate Products was always enabled
* Added notifications when certain advanced settings are enabled
* Various other improvements
= 2.0.8 2022-08-26 =
* Improved compatibility with the plugins that use outdated GuzzleHttp library
* Improved handling of corrupted order entries
= 2.0.7 2022-08-19 =
* Added support for ZPL and EPL2 label formats
= 2.0.6 2022-07-30 =
* Bug fixed
= 2.0.5 2022-07-21 =
* Bug fixed
= 2.0.4 2022-07-20 =
* Bug fixes
= 2.0.3 2022-07-16 =
* Bug fixes
= 2.0.2 2022-07-07 =
* Fixed logger message format to avoid possible issues from invalid string
= 2.0.1 2022-07-06 =
* Fixed so that disabled boxes won't be picked up for packing
= 2.0.0 2022-07-01 =
* Minimal PHP requirement has been changed to v7.3
* All addons have to be updated in order to stay compatible with the new version of this plugin
* A lot of code optimization and refactoring
* Changed to use Asynchronious HTTP requests which dramatically increases speed with which bulk shipments are created
* Advanced settings will be hidden by default but can be enabled by checking Advanced Settings checkbox
* Changed checkboxes to toggles
* Regroupped settings to be more clear
* Added possibility to print shipping label in a single click
* Added condition for when Signature service will be requested
* Added support for Saturday Delivery
* Added support for Cash on Delivery
* Added support for shipping alcohol with condition for which products contain Alcohol
= 1.8.8 2021-11-12 =
* EasyPost API requires to use dots for decimal values, so plugin will convert all numeric values to match that format
* Display tracking table at the top of My Account -> Order page
* Display tracking number even when we don't have tracking URL
* Track button will be displaye donly where there are any tracking events
* Better handling of displaying of the service name (postage description)
= 1.8.7 2021-11-02 =
* Ability to set company as required field during checkout. It might be useful for some carriers that don't return rates without a company name.
= 1.8.6 2021-10-23 =
* Proxy requests to WooCommerce Objects to gracefully handle possibility that they were not initialized
* Always display contents and description field in the shipment creation form
* Fixed to use shipping full name instead of billing
* Use ---Residential--- as a company name when it is not specified, the reason for that is that some carriers require company name and won't accept something like --
= 1.8.5 2021-10-13 =
* Use shipping full name in labels
* Use latest origin and destination addresses when printing labels in bulk
= 1.8.4 2021-10-09 =
* Fixed ability to link shipments by ID
= 1.8.3 2021-10-07 =
* Add vendor / seller ID to rate meta, so Dokan will pick up chosen shipping methods in children orders
* Better communication of selected rate, so then it will be automatically pre-selected when printing a label
* Removed borders from shipment box cells
* Fixed: Vendors were able to purchase label more expensive than customer paid due to inclusion of the taxes
= 1.8.2 2021-10-06 =
* Plugin will keep vendor's address, when Use Seller Address is enabled, even when it is not set. It might prevent it from printing labels, but it will avoid printing labels with FROM address of the marketplace.
* Fixed issue that caused fatal error when new order has been created, it was caused by create date being null
= 1.8.1 2021-10-04 =
* Customs Info should only contain ASCII characters, other characters will be replaced with ??
* Instance settings will be loaded only when Shipping Zones are enabled
= 1.8.0 =
* Updated language template file
* Use different event ids for import, update and create cron events
* Check variation and its parent for detection of Vendor ID
* Validate if owner of a product is an active vendor
* Added confirmation dialog before unlink, refund and cancel actions
* Gracefully handle lack of support for phar and compression by displaying admin error notice in this case
* Added minified css and js files
* Use Cube Dimensions will only work when Combine All Boxes is enabled, so it won't affect pre-configured box sizes
* Improved address validation so it won't be possible to bypass it
* Various minor bug fixes
= 1.7.4 =
* Improved page detection for Page Condition setting
* Centralized handling of logging to make sure that all log messages will be recorded when debug mode is enabled
* Improved calculation of maximum allowed shipping total
* Force calculation of the shipping costs on checkout when Page Condition is set to checkout
* Fixed an issue that plugin was using website currency for live shipping rates even when it isn't supported
* Fixed an issue that shipment can't be refreshed in some cases 
* Fixed parcel data validation in bulk orders form
= 1.7.3 =
* Code refactoring
* Changed files structure
* Communicate customs info only for international shipments
= 1.7.2 =
* Changed multivendor detection to use parent product of a variable product to determine a vendor of a product.
* Fixed ability to add several boxes at once. Plugin user will have to fill only required fields, before next box can be added.
= 1.7.1 =
* Fixed how shipping rates are combined, so only matching rates for all the parcels will be displayed
= 1.7.0 =
* Added more logging message for easier bugging
* Fixed issue that post ID was accessed before post was created when Order is manually added
* Minor HTML fixes
* Changed code to use autoloader instead of including files directly
* Ability to overwrite boxes, services and from address in shipping zone settings
* Fixed issue that broke plugin when weight adjustment was an empty string
* Updated language template file
= 1.6.8 =
* Round default min weight / height / length so they won't generate html5 validation error on save
* New language template file
* Fixed undefined boxes PHP notices
* Fixed header sent warning when validation errors were displayed after plugin settings have been saved
= 1.6.7 =
* Fixed order autocompletion when shipping label has been created
* Added HTML5 min attribute to inputs with steps, like min weight, min height and so on.
* Added support for all RoyalMail services
* Added support for more Fastway services
* Ability to define service rule by custom service id, which is useful when service is not pre-defined in the plugin
= 1.6.6 =
* Display validation errors when getting rates quote, before shipment is created
= 1.6.5 =
* Fixed issue when item name was used instead of a customer name
* Use shipping address when either shipping address 1 or 2 are set
= 1.6.4 =
* Wait until batch is completely created, before continuing in creation of a manifest
* Fixed description displayed in the admin orders
* Allow to change a domain license assign to by setting license to an empty string and then using it at another domain
= 1.6.3 =
* Fixed issue with services not working as expected when shipping zones are enabled
* Added logging of the plugin settings for easier debugging
= 1.6.2 =
* Settings will be loaded and handled more centrally
* Changed how global settings are overwritten by vendor's settings
* Added min length, width, height
* Improved default settings so plugin will be easier setup and use out of the box
* Updated language template
= 1.6.1 =
* Fixed the issue that new debug messages were preventing checkout
* Hide package contents and description for local orders
= 1.6.0 =
* Ability to choose a condition for what pages live rates will be requested
* Support for Shipping Labels for WCFM / Dokan to add/remove and modify boxes / services
* Validate products only when this option is enabled in the settings
* Error messages will be displayed in the cart for admin users when debug mode is enabled
* Updated language template
= 1.5.3 =
* Bug fixes
* Ability to control send request timeout
* Added various hooks for better extensibility
* Removed hardcoded dollar sign from shipment confirmation form
* In order reduce PHP memory requirement product validation has been changed to run in the chunks of 10 products at a time
= 1.5.2 =
* Use TO address as FROM address when return label is requested
* Changed to first create batch and then to create manifest for a batch
* Use invoice price for customs info, so all applied discounts will be included in the price
* Auto tracking will use Status Change Timeout as an additional condition for stopping tracking of delivered / lost packages
* Use billing address when shipping address is not specified
* Ability to receive tracking notifications for any status
= 1.5.1 =
* Fixed removal of services and boxes
* Improved simple and variable product validation when settings are saved
* Changed order in which service name and tracking are displayed in the orders page
* Added ability to use CUBE dimensions for the parcel, it can help to save on shipping when using combine parcels feature or don't have boxes defined
* Add support for the add-on that will allow to group new shipments into batches and create manifests for them
= 1.5.0 =
* Ability to define product conditions that have to be matched for service to be offered during checkout
* Ability to have min and max rate cost requirement for shipping rate to be displayed during checkout
* Changed rounding to 2 decimal places
* Parcel presets in the Order Shipment form will display box dimensions along with the name
* If package contents is undefined then plugin will fallback to using cart contents
* Ability to create shipping label will be available for all shippable orders
* Shipment box will work even when Use Cache is unchecked
* It will be possible to purchase label even when Use Cache is unchecked
* New language template file
= 1.4.4 =
* Fixed removal of Boxes and Services
* Fixed loading of the States in the plugin settings
= 1.4.3 =
* Fixed a bug in handling of local orders
* Minor bug fixes
= 1.4.2 =
* To improve compatibility renamed myaccount/view-order.php to myaccount/tracking-info.php
= 1.4.1 =
* Various bug fixes
= 1.4.0 =
* Display both order id and order number on label reference area
* Bulk purchase and download of shiping labels will use AJAX call and open pop-up window with generated PDF upon completion
* Ability to enable addition of Auto Print script to generated PDF documents
* Fixed sorting of the shipping rates displayed in the cart
* Preserve services when API is not failing to return services after cache has expired
* Improved re-request of services and package types when API has failed before that
* No longer needed to activate integration for Shipping Labels for WCFM to work, it will have to be activated in there instead
* If cache has expired user will have to refresh the page before being able to create shipping label
* Infrastructural code changes to allow futher extension of the plugin
* Improved weight and dimension validation of variable products
= 1.3.5 =
* Display order number on label reference area
= 1.3.4 =
* Moved common purchase postage settings to purchase postage defaults section, they will apply to both bulk and single shipping label purchases
* Added description field to bulk purchase postage form
* Fixed vendor detection when purchasing shipping label
* If vendor's address does not have country or city set then default to sitewide plugin from address
* Extract website / vendor email and communicate it to API
* Changed shipment purchase buttons to occupy entire row
* Added improved styles for jquery dialog for shipment box
* Set parcel value only when elements are included in HTML for shipment box
* Improved support for RoyalMail and customs declaration
= 1.3.3 =
* Changed parcel weight adjustment flow to first multiply weight, then add to weight and then set min weight
* Parcel weight adjustments will be applied to shipping label creation flows too
= 1.3.2 =
* Fixed Fixed weight adjustment for international shipments
= 1.3.1 =
* Various bug fixes
* Improved support for Dokan, WCFM, WCMP, YITH and WC Product Vendors
= 1.3.0 =
* Various bug fixes
* Improved support for the default WooCommerce currency
* Ability to Download PDF Shipping Labels and Forms as one file in bulk from Admin Orders UI
* Ability to limit number of shipping rates returned in the cart and checkout pages
* Improved handling of refunds
* Updated language template file
= 1.2.8 =
* Added Order ID to created shipping label
* Do not cache address when it was not validated by Shippo, because Shippo won't be storing it anyways
* Renamed Admin settings labels to use statements instead of questions. Also made labels and descriptions easier to understand.
* Do not cache validation result of the products
* Moved Settings link before Deactivate link on the plugins page
* Updated language template file
= 1.2.7 =
* Pre-fill from address with the default WooCommerce address
* Display actual amount paid in the order details instead of product price
* Pre-select website currency in the shipment box
* Improve product validation to include only simple products that are not virtual
= 1.2.6 =
* Fixed CRON scheduler
* Synchronized shared library
= 1.2.5 =
* Improved input sanitization for input data from checkout page
* Deactivate free plugin earlier to avoid possible compatibility issues
= 1.2.4 =
* Improved caching of the object IDs returned by EasyPost API
= 1.2.3 =
* Fixed PHP notice
= 1.2.2 =
* Improved how destination address is extracted during checkout process, which should improve reliability of live shipping rates
= 1.2.1 =
* Fixed name of the plugin in WooCommerce Settings
= 1.2.0 =
* Ability to integrate with upcoming MultiVendor Shipping Labels plugin
* Ability to turn off caching, which is useful for debugging and reseting corrupted cache
* Changed to have combine boxes enabled by default
* Changed Email notifications to work only for selected statuses and be disabled by default
* Changed to Update Shipments feature to be disabled by default
* Added notification when Shipping Zones is getting checked
* Try to use full customer address for live shipping rates when customer is registered
* Fixed default phone number to be 10000000000
* Plugin will validate API settings when settings are saved
* Plugin will validate that products match dimension/weight requirements when settings are saved
* Plugin will validate From address
* Plugin will validate that it has been added to Shipping Zones when Shipping Zones feature is enabled
* Improved styling of tracking history in the Shipment box of an order
* Added versioning for CSS and JS to work around possible caching when they are changed
* Parcel packer will communicate SKU of the products
= 1.1.25 =
* Added path to debug log in the settings of the plugin
* Change to check for Seller ID with only one method, so if YITH is enabled then it will use it and won't fallback to other methods
* Added support for WCFM Multi Vendor plugin
= 1.1.24 =
* Added support for YITH Multi Vendor plugin
* Fixed adjustment of package weight for custom items
= 1.1.23 =
* Changed debug to use WooCommerce -> Status -> Logs instead of the messages in the Cart
= 1.1.22 =
* Fixed bug that second address line wasn't used in return labels
* Fixed order actions when bulk orders aren't enabled
* Other minor bug fixes
= 1.1.21 =
* Fixed PHP warning
* Synchronized shared library code
* Added links to Free Shipping and Flexible Shipping plugins
= 1.1.20 =
* Synchronized with the latest code changes
* Use - for the company name when it is not provided
* Fixed PHP warnings and notices
= 1.1.19 =
* Added support for predefined parcels
* Included language template (.pot) file
= 1.1.18 =
* Order custom fields need to have step attribute in order to support decimal values
= 1.1.17 =
* Improved compatibility with Dokan
* If no services are configured and Use Service Settings for Bulk orders is enabled, we will display all services
* If address has no name, but has a company name then use it for both name and company fields
= 1.1.16 =
* Trim all address fields because some WooCommerce installs can have randome spaces, so then EasyPost API will refuse them
= 1.1.15 =
* Don't filter out services when nothing is configured and checkbox is unchecked
* Use Resident as a name when one isn't set
= 1.1.14 =
* Allow to domain of the license by deactivating plugin on the old domain and activating it on the new domain
* Use customer's name as a company when company is not set
= 1.1.13 =
* Use from 9am to 16am of a weekday as the label date, so GSO will return shipping rates during the weekend and out of business hours
= 1.1.12 =
* Added instruction that products should have weight and dimensions
* Synchronized with the latest version of library
= 1.1.11 =
* GSO carrier requires label_date to be set in order to return rates
= 1.1.10 =
* Fixed tracking location handling
* Synchronized with the latest version of library
= 1.1.9 =
* Bug fixes
* Use company name from the order for the destination
* Synchronized with the latest version of library
= 1.1.8 =
* Bug fixes
= 1.1.7 =
* Improved backward compatibility with older PHP
* Fixed shipping label creation issue when error message is returned along with the rates
* Synchronized with the latest version of dependencies
* Changed to use receipient name as a company name, when it is not set and when nothing is set then use Resident for the name and - for the company name
* Ability to choose default service for bulk shipping creation form
* Ability to limit selection of shipping services in bulk shipping creation form based on the plugin settings 
* Auto complete order for configured shipment statuses
* Added Troubleshooting tips in the plugin settings
* Revert back to free plugin when license is invalid or not provided
= 1.1.6 =
* Bug fixes
= 1.1.5 =
* Disable bulk shipping label form fields when search request is submitted
* Mark address as residential when address does not have company name set
* DHL requires phone number, so depending on the what information we have we will either use customer's billing phone number of store's phone number or a fake phone number, so we can get the rates
* Always pass customer name, so we can get the quotes from all carriers that require it
= 1.1.4 =
* Return rates even when error message is present
* Allow to create shipping label despite possible error messages
= 1.1.3 =
* Improvements to form filtering
= 1.1.2 =
* Updated to use new form filter that is used for Admin settings
* Changed to round weight, length, height, width values up to precision 3
= 1.1.1 =
* Bug fixes
* Updated to include logo with the plugin
= 1.1.0 =
* Added ability to create return shipping label
* Added ability to validate address before allowing customers to pay for their order
* Fixed shipment confirmation close button location
* Don't display customs items for local orders
* Many other minor improvements and fixes
= 1.0.15 =
* Enable / Disable Live Shipping Rates should only be available in PRO version
* Synchronized changes with fixes in Free version of the plugin
= 1.0.14 =
* Menu entry renamed to EasyPost Shipping (without PRO suffix)
* Synchronized changes with fixes in Free version of the plugin
= 1.0.13 =
* Fixed displaying of validation errors in shipment label generation box
* Added OneTeamSoftware menu
= 1.0.12 =
* Ability to specify label size
* Display PDF or PNG label only file extension matches label type
= 1.0.11 =
* Fixed cases when default product origin wasn't correctly passed to customs info
* Fixed PHP notices
= 1.0.10 =
* Fixed warning in the admin
= 1.0.9 =
* Adjusted a note in the plugin settings about EasyPost API fees
= 1.0.8 =
* Adjusted a note in the plugin settings about EasyPost API fees
= 1.0.7 =
* Fixed that insurance was always included with the rate
= 1.0.6 =
* Easy way to enable/disable live shipping rates in the cart/checkout pages
* Cache address/parcel/customs info to reduce number of API requests and reduce possible EasyPost fees
* Added explanation of EasyPost fees and link to register account page
* Added possibility to set default tariff and to choose tariff per product during shipping label creation
= 1.0.5 =
* Display notice when order has been updated in the Orders UI and switch Add button to Update
= 1.0.4 =
* Fixed notice caused by boxes not being set when saving settings
= 1.0.3 =
* Rearranged notification settings to be more clear
* Updated language file
= 1.0.2 =
* Phone might be returned as an array, in this case use the first value
= 1.0.1 =
* Improved parcel packer so it will additionally check that product dimensions can fit into a box
* Fixed issue with customs items
* Fixed Media Mail setting
= 1.0 =
* Initial release.

== Upgrade Notice ==
= 1.3.1 =
* Dokan and WCFM integration will use store address instead of the admin's address
* WooCommerce Product Vendors integration will use address of the first store admin
* YITH and WCMP integrations will use store admin's address