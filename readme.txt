=== WP SSL Redirect ===
Contributors: rehmatworks
Tags: wordpress, ssl, 301, redirect, force, ssl
Requires at least: 3.95
Tested up to: 6.1
Stable tag: 1.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A very tiny plugin to force SSL on WordPress websites (via 301 redirects for SEO purpose).

== Description ==
WP SSL Redirect simply forces the SSL on your WordPress website by applying a 301 redirect from the HTTP path to HTTPS path. Please note that this plugin doesn't install or configure any SSL certificate, instead it simply applies a 301 redirect to force the SSL on a WordPress website where a valid SSL is already properly installed.

== Frequently Asked Questions ==

= Does this plugin install or configure SSL? =
No.

= Does this plugin make any changes to the file system or database? =
No changes are made to file system or the database.

= How does WP SSL Redirect perform the redirect? =
The plugin makes use of <code>$_SERVER</code> array to check either the URL is accessed over HTTPS or HTTP. If the request is made over HTTP, then the plugin sends a 301 redirect header and performs the redirect to the HTTPS version of the same URL.

= 301 Redirect is Not Working =
If <code>WP_SITEURL</code> and <code>WP_HOME</code> are hardcoded in your WordPress website's <code>wp-config.php</code> file, then uncomment or delete these two constants, otherwise WP SSL Redirect's 301 redirect may not work properly.

== Screenshots ==
none

== Upgrade Notice ==
none

== Changelog ==
== 1.3 ==
* Added options to force www or non-www
== 1.3.1 ==
* A minor bug fix regarding query vars
== 1.3.2 ==
* Fixed a major bug related to sub-directory installations
== 1.4 ==
* Rewrote the redirection code to make it even simpler
* Disabled the website URL update in the database
== 1.5 ==
* Bug fixes
== 1.6 ==
* Compatibility test with WordPress 6.1