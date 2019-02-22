=== Plugin Name ===
Contributors: Houghtelin
Tags: Vacation Rental Platform, Gueststream, VRP Connector, ISILink, HomeAway, Escapia, Barefoot, VRMGR
Requires at least: 3.0.1
Tested up to: 5.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Vacation Rental Platform Connector allows you to display and book your vacation rental properties on your site.

== Description ==
The Vacation Rental Property Connector plugin by Gueststream, Inc. allows you to sync all of your vacation rental
properties from HomeAway, Escapia, ISILink (First Resort, Property Plus, V12) , Barefoot, RNS (Resort Network), VRMGR, RTR and other property management software to your website
allowing potential guests to search, sort, compare and book your rental properties right from your website.

Learn more about the VRPConnector plugin: http://www.gueststream.com/our-software/vrpconnector/

= Example Sites =
 * https://www.grandcaymanvillas.net
 * https://www.plantanacayman.com
 * https://www.epicmauirealty.com
 * https://www.crestedbuttelodging.com
 * https://www.bhhsvail.com
 * https://www.vacationrentalsparkcity.com
 * https://www.aliiresorts.com
 * https://www.beachrentals.mobi
 * https://www.lifestylevillas.net
 * https://www.alpineskiproperties.com
 * https://www.caymanvacation.com
 * https://www.gearhartresort.com
 * https://www.escapelux.com
 * https://www.mauihawaiivacations.com
 * https://www.summitresortgroup.com
 * https://www.waikoloavacationrentals.com
 * https://www.mauiwestside.com
 * https://www.whistlerlodging.com
 * https://scmountainretreats.com
 * http://www.caydirect.com

== Installation ==
1. Install the plugin from the WordPress.org Plugin Directory here https://wordpress.org/plugins/vrpconnector/
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Wordpress Admin > Settings > VRP and enter your Gueststream.net API key
1. Begin adding the available shortcodes to your posts and pages as desired.
The following shortcodes are available for use throughout your website.
To use them simply add them to the page/post content.

* [vrpSearchForm] - Will display an advanced search for users to search your properties.
* [vrpUnits] - Displays a list of all enabled units
* [vrpSearch] - Requires additional attributes to display units according to the values set. This short code effectively produces the results of performing an availability search.

More detailed instructions for using shortcodes, theming the VRP pages and using the plugin can be found
 at the VRPConnector's Wiki page here: https://github.com/Gueststream-Inc/VRPConnector/wiki

 == Support ==
 FREE 2 hours of support. Submit a ticket to support@gueststream.com

== Frequently Asked Questions ==
= What property management software(s) does the VRP Connector support? =

HomeAway, ISILink (First Resort, Property Plus, V12), Escapia, Barefoot, RNS, Streamline VRS, vOffice, VRMGR, and more!

= Does the VRP Connector require an account with Gueststream.net? =
Yes, Gueststream.net provides the back-end service of interfacing with many property management software APIs that allows
you to seamlessly connect your website to your property management software data.

== Screenshots ==
1. Out of the box unit page.

== Changelog ==
= 2.0.1 =
* Reformated default theme
* Added WP option to add google map key (required by google for maps to function)
* Updated default JQuery Version
* Bugfix VRP Results Map - check for lat/long values before address value
* Bugfix VRP Booking selecting country

= 1.5.0 =
* Barefoot Property Management Software support established.

= 1.4.5 =
* Cleaning up code style in Theme files to better match WordPress code style standards.
* Fixing PHP Notice in library on get unit availability request.

= 1.4.4 =
* Added support for Yoast SEO plugin to display page titles and meta descriptions.

= 1.4.3 =
* Added SEO page title & meta description support for complex pages.
* Prevent search engines from indexing search result pages to prevent content duplication.
* Code style changes to built in theme to better meet WordPress code style standards.

= 1.4.2 =
* Bugfix for Admin settings page that was causing PHP 5.4 systems to not display the settings page.

= 1.4.1 =
* Added site home url path to booking form submission path to support alternate install directories.
* Added site url path to booking form confirmation page path.

= 1.4.0 =
* Added new shortcode [vrpUnit pag_slug="my_unit_page_slug"] to turn pages and posts in to unit pages.

= 1.3.5 =
* Fixed bug in [vrpSearch] shortcode to allow guests to override default sort and order.
* Fixed bug in paginator that was creating links to pages that did not exist.

= 1.3.4 =
* Fixed bug in search so when a guest searches without entering an arrival date all units are shown instead of no units due to the broken arrival date.

= 1.3.3 =
* Fixed bug causing the number of adults searched to not persist through search data to hydrate forms.
* Added support for applicable taxes on travel insurance (Escapia)

= 1.3.2 =
* Fixed bug causing WP Admin Page & Post editor search to not show results.  Now, when searching for posts in WP Admin, all searched results will show.

= 1.3.1 =
* Updated search result template file to display errors if they are known.

= 1.3.0 =
* Added Search Form Widget for easier implementation of sidebar search forms.

= 1.2.4 =
* Hotfix for backward compatibility breaking issue introduced in version 1.2.3 - setting header application/json.

= 1.2.3 =
* Added datepicker functionality on unit page availability check & pricing request to make booked dates un-selectable.
* Beginning to compartmentalize javascripts breaking them down by theme file starting with the unit page theme file.
* Removed popup map and unit description from result list.

= 1.2.2 =
* Unit Page availability check now displays rate breakdown next to 'book now' link.
* Unit page styling cleaned up to better use namespaced bootstrap classes.
* Added captions to unit page photos.
* Unit page rate table now displays daily, weekly and monthly rates for all listed rate seasons (Previously only daily rates were displayed).
* Added support for checking availability of a unit using a promo code to see the resulting rate change.
* Result list 'add to favorites' button fixed to no longer incorrectly scroll the page up.
* Purged a lot of depreciated/unused JavaScript.
* Set 'terms and conditions' link on checkout to open modal with rental agreement.
* Fixed unit type drop down selection on advanced search form.

= 1.2.1 =
* Making bathrooms search value session stored
* Added calendar icons to arrival & departure input fields.
* Storing user favorites in Cookies as well as php session to persist favorites for 30 days.
* Travel Insurance option (if present) requires user to select yes or not rather than defaulting to one or the other.
* Unit page map now pins unit location based on latitude and longitude if the data is present otherwise it pins the unit based on geocoded address.
* Search result pagination fix.
* Removed unused pagination and sort link generator functions.

= 1.2.0 =
* Added search result map with pins on the map for all results.

= 1.1.4 =
* Adding support to book with Pets using the Escapia Property Management System

= 1.1.3 =
* Fixed default sort order for [vrpUnits] short code.
* changing travel insurance acceptance default to 'no'
* Added travel insurance ID for better Escapia support.
* Fixed use of address field 1 on unit page for map geolocating.
* Stopped VRP pages from overwriting the posts so widgets and other items can list posts on VRP pages.
* Disable the default behavior of scrolling zoom on the unit page map.
* Fixed reviews to display in default theme.
* Fixed PHP Warning when using [vrpSearch] shortcode with no attributes.

= 1.1.2 =
* Fixed bug to allow using 'Featured=true' in vrpSearch shortcode to display only units that are set as featured.
* Fixed pagination function so the current page is no longer listed outside the list of pages.

= 1.1.1 =
* Fixed favorites display bug that resulted in some sites always showing 'no favorites saved yet' page even if favorites were saved.

= 1.1.0 =
* Added iCal unit availability calendar support. /vrp/ical/unit_page_slug
* Fixed XML site map output.

= 1.0.8 =
* Fixed unit permalink on Featured Unit shortcode templates.
* Added single quotes to unit thumbnail photos in the result listing to allow URLs with spaces to function properly.
* Added support for the 'Unit Page Views' module.
* Fixed url path bug in JS causing favorites to not work when the site is installed in a sub directory.

= 1.0.7 =
* Automatically login to gueststream.net from settings page

= 1.0.6 =
* Search options now support filters.

= 1.0.5 =
* Fixed Parse Error for PHP 5.2 and enhanced PHP version notice.

= 1.0.4 =
* Plugin settings link (visible after VRPConnector plugin is activated) added to plugins list.
* Shortcode examples added to installation documentation.
* Settings page renamed from VRP to VRPConnector

= 1.0.3 =
* ShortCodes can be used in Widget Text
* Advanced Search Form posts to regular search instead of complex search by default.
* Unit Thumbnail photos with URL's containing spaces %20 in them now display correctly.

= 1.0.2 =
* Fixed var declaration inside of a hash map.

= 1.0.1 =
* Fixed bug in unit page mapping JS.

= 1.0.0 =
* Better support for Specials themes and added [vrpSpecials] shortcode.

= 0.09 =
* Added ability for users to favorite units, view & share their list of favorites.

= 0.08 =
* Added caching for all API calls
* Removed requirement for custom permalink structure.

= 0.06 =
* Added [vrpFeaturedUnit] short code support.

= 0.01 =
* Initial Release

== Upgrade Notice ==
= 2.0.1 =
* Added new VRP Theme Option! Cleaner VRP format out of the box.

= 1.4.4 =
* Added Yoast Support! Now VRPConnector plays well with Yoast and All-in-one SEO plugins.

= 1.4.0 =
* [vrpUnit page_slug="my_awesome_property"] shortcode added. You can not place unit data on any page of your site!

= 1.3.5 =
* [vrpSearch] shortcode sort order override bugfix.

= 1.3.2 =
* WP Admin post search bug fix.

= 1.3.0 =
* New Search Widget feature added.

= 0.10 =
* Display Specials by category or individually with the use of shortcodes.

= 0.09 =
* Users can now build a list of favorite units.

= 0.08 =
* Now custom permalink structures work!
* Established caching for a much faster guest experience.

= 0.07 =
* Added [vrpFeaturedUnit] shortcode support.
