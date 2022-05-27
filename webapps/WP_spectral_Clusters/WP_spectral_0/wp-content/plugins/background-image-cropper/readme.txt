=== Background Image Cropper ===
Contributors: celloexpressions, wordpressdotorg
Tags: custom background, background image, cropping, customizer
Requires at least: 4.6
Tested up to: 5.4
Stable tag: 1.2
Description: Adds cropping to backgroud images in the Customizer, like header images have.
License: GPLv2

== Description ==
This plugin is a WordPress core feature-plugin that adds cropping to background images for parity with header images. For this particular feature the implementation is quite simple, but it's starting out as a plugin to gauge user interest in this feature and whether the feature improves the user experience of background images.

This plugin requires WordPress 4.3 Beta 3 or later.

If you're interested in contributing to this project, ping @celloexpressions on <a href="http://chat.wordpress.org/">WordPress core Slack</a>. Please comment on the trac ticket with ideas and feedback: https://core.trac.wordpress.org/ticket/32403.

== Installation ==
1. Take the easy route and install through the WordPress plugin installer OR
1. Download the .zip file and upload the unzipped folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit the Customizer (Appearance -> Customize) to change your background image and be able to crop it after selecting it.

== Screenshots ==
1. New cropping step when adding a background image.

== Changelog ==
= 1.2 =
* Add plugin textdomain for translations.
* Clarify image context handling.

= 1.1 =
* Fix initial display in WordPress 4.6 and later.
* Fix in-control preview of selected image in WordPress 4.6 and later.
* Ensure that the background-image context is set for selected images, so that they're marked as background images in the media library.
* Refine handling in conjunction with the improved background image properties UI in WordPress 4.7.

= 1.0 =
* Fix setting handling.

= 0.9 =
* Initial commit.
* Full functionality pending the completion of https://core.trac.wordpress.org/ticket/29211

== Upgrade Notice ==
= 1.2 =
* Add translations support and clarify internal image handling.

= 1.1 =
* Fixes for recent WordPress core changes.

= 1.0 =
* Fix setting handling.

= 0.9 =
* Initial commit.