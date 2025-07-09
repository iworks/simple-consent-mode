=== Simple Consent Mode ===
Contributors: iworks
Donate link:
Tags: PLUGIN_TAGS
Requires at least: PLUGIN_REQUIRES_WORDPRESS
Tested up to: PLUGIN_TESTED_WORDPRESS
Stable tag: PLUGIN_VERSION
Requires PHP: PLUGIN_REQUIRES_PHP
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

PLUGIN_TAGLINE

== Description ==

The **Simple Consent Mode** plugin helps seamlessly integrate Google Tag Manager's (GTM) Consent Mode v2 on your website, ensuring compliance with privacy regulations like GDPR. This lightweight plugin automatically configures Consent Mode and manages user consent for analytics and marketing cookies.

With Simple Consent Mode, you can dynamically adjust the behavior of your tags based on whether the user has granted or denied consent, while still gathering anonymous data when consent is not provided. The plugin makes it easy to implement, providing a simple interface for enabling and configuring consents, without needing to manually adjust code.

= Key Features =
* **Automatic Consent Mode Configuration**: Integrates GTM Consent Mode v2 with no need for complex manual setup.
* **Granular Consent Control**: Allows users to opt in or out of specific types of cookies (e.g., analytics, marketing).
* **GTM Tag Support**: Works seamlessly with Google Analytics, Google Ads, and other GTM tags that rely on user consent.
* **GDPR and Privacy Compliant**: Helps ensure compliance with global privacy regulations by allowing proper consent tracking.
* **Lightweight & Easy Setup**: Minimal configuration required.

This plugin simplifies the process of integrating and managing GTM’s Consent Mode v2, giving site owners better control over cookie usage while respecting user privacy preferences.

= GitHub =

The Simple Consent Mode plugin is available also on [GitHub - Simple Consent Mode](https://github.com/iworks/simple-consent-mode).

== Installation ==

There are 3 ways to install this plugin:

= The super-easy way =

1. Navigate to WPA > the Plugins and click the `Add New` button.
1. Search for `Simple Consent Mode`.
1. Click to install.
1. Activate the plugin.
1. A new menu `Simple Consent Mode` will appear in your Admin.

= The easy way =

1. Download the plugin (.zip file) on the right column of this page
1. Navigate to WPA > the Plugins and click the `Add New` button.
1. Select button `Upload Plugin`.
1. Upload the .zip file you just downloaded.
1. Activate the plugin.
1. A new menu `Simple Consent Mode` will appear in your Admin.

= The old and reliable way (FTP) =

1. Upload `simple-consent-mode` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. A new menu `Simple Consent Mode` will appear in your Admin.

== Frequently Asked Questions ==

= I have a problem with the plugin, or I want to suggest a feature. Where can I do this? =

You can do it on [Support Threads](https://wordpress.org/support/plugin/simple-consent-mode/#new-topic-0), but please add your ticket to [Github Issues](https://github.com/iworks/simple-consent-mode/issues/new).

= How to open the consents dialog for any location (eg. a menu) =

Simply add the class `iw-scm-dialog-open` to any link, and the dialog will open.

= How to use the shortcode `scm_link_to_show' =

The shortcode scm_link_to_show, is designed to create a link that opens a consent dialog.i

Parameters
The scm_link_to_show shortcode accepts the following parameters:

* **container_tag**: The HTML tag to use for the container element. Default is div.
* **container_classes**: Classes to apply to the container element.
* **classes**: Classes to apply to the link element itself.
* **text**: The text to display for the link.
* **aria-label**: The ARIA label for accessibility purposes.

**Usage Example**

To use the shortcode, insert it into your WordPress page or post with the desired parameters.

`
[scm_link_to_show
  container_tag="span"
  container_classes="my-container-class"
  classes="my-link-class"
  text="Open Consent Dialog"
  aria-label="Open consent dialog for more information"]
`

This will create a link wrapped in a span element with the specified classes and text, and it will open a consent dialog when clicked.


== Screenshots ==

== Changelog ==

= 1.3.1 - 2025-07-09 =
* **Dependencies**: Updated the [iWorks Options](https://github.com/iworks/wordpress-options-class) module to version 3.0.7 and the [iWorks Rate](https://github.com/iworks/iworks-rate) module to version 2.3.1.

= 1.3.0 - 2025-03-29 =
* The ability to show or hide the about consents tab has been added. [#6](https://github.com/iworks/simple-consent-mode/issues/6).
* The ability to show or hide the icon has been added. [#7](https://github.com/iworks/simple-consent-mode/issues/7). Props for [Daniel](https://www.linkedin.com/in/daniel-bocek-186944197).
* The issue regarding option initialization has been addressed.
* The `[scm_link_to_show]` shortcode has been added. [#8](https://github.com/iworks/simple-consent-mode/issues/8). Props for [Daniel](https://www.linkedin.com/in/daniel-bocek-186944197).
* Updated the [iWorks Options](https://github.com/iworks/wordpress-options-class) module to version 2.9.9.

= 1.2.3 - 2025-03-20 =
* Enhanced CSS for smaller screens. Props for [Daniel](https://www.linkedin.com/in/daniel-bocek-186944197).
* Wrong [GitHub releases](https://github.com/iworks/simple-consent-mode/releases) zip file URL has been fixed [#5](https://github.com/iworks/simple-consent-mode/issues/5).

= 1.2.2 - 2025-03-13 =
* Enhanced CSS class selectors to prevent conflicts with theme styles.
* Improved build process for better performance and efficiency.
* The dialog logo has been corrected to prevent the use of the cropped version.
* Updated the [iWorks Options](https://github.com/iworks/wordpress-options-class) module to version 2.9.8.
* Wrong [GitHub releases](https://github.com/iworks/simple-consent-mode/releases) zip file URL has been fixed.

= 1.2.1 - 2025-02-25 =
* Wrong data decode has been fixed.

= 1.2.0 - 2025-02-25 =
* The frontend has been refactored.
* Updated the [iWorks Options](https://github.com/iworks/wordpress-options-class) module to version 2.9.7.
* Translation loading for [github releases](https://github.com/iworks/simple-consent-mode/releases) has been fixed.

= 1.1.1 - 2025-02-20 =

* A typo in code has been fixed. [#3](https://github.com/iworks/simple-consent-mode/issues/3).
* The Plugins row setting link has been fixed.
* The capability to setting page has been fixed.

= 1.1.0 - 2025-02-19 =

* The Consent Log has been added. [#1](https://github.com/iworks/simple-consent-mode/issues/1).
* In the description fields you can use HMTL tags now. [#2](https://github.com/iworks/simple-consent-mode/issues/2). Props for [sylwiastein](https://github.com/sylwiastein).

= 1.0.0 - 2025-02-13 =

* Initial release.

== Upgrade Notice ==

