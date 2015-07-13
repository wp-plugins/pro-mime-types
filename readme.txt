=== Pro Mime Types ===
Contributors: Cybr
Tags: mime, mimetypes, types, multisite
Requires at least: 3.1.0
Tested up to: 4.2.2
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Pro Mime Types allows you to set allowed upload mime types through a nifty network admin menu and considers WPMUdev's Pro Sites!

== Description ==

= Pro Mime Types =

***This plugin will only work on WordPress MultiSite***

*For the extra Pro Sites functionality you'll need the Pro Sites plugin from WPMUdev, get it here: [Pro Sites by WPMUdev]*

[Pro Sites by WPMUdev]: https://premium.wpmudev.org/project/pro-sites/
	"Get Pro Sites"

**About this plugin:**

This plugin allows you to set allowed mime types to be uploaded throughout your network installation. By default WordPress doesn't allow many mime types to be uploaded.

Within the network admin menu under Settings you can allow or disallow various mime types.
You can also see the list of all active Mime Types on the network.

**When a Mime Type is allowed:**

* Any user can upload the allowed Mime Type through the WordPress Media Uploader.
* If set, only the allowed Pro Level and higher can upload the Mime Type through the WordPress Media Uploader.

**When a Mime Type is disallowed:**

* No one can upload the Mime Type, not even the Pro Level next to it.

== Installation ==

1. Install Pro Mime Types either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Network Activate this plugin through the Network Plugin Manager.
1. Set the allowed mime types in /wp-admin/network/settings.php?page=pmt_admin_page
1. Hover over any blue, orange or red colored mime type to see the reason why it's potentially unwanted
1. Save the settings at the bottom of the page
1. That's it! Enjoy :)

== Changelog ==

= 1.0.2 =
* Now uses Object Cache to determine Pro Site level, updates every 4 hours

= 1.0.1 = 
* Fixed PHP notice
* Loaded global variable $promimes within 'init' instead of 'wp'

= 1.0.0 =
* Initial Release