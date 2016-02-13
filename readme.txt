=== Advanced Term Fields: Featured Images ===
Contributors: dbmartin
Tags: termmeta, term_meta, term, meta, metadata, taxonomy, colors
Requires at least: 4.4
Tested up to: 4.4.1
Stable tag: 0.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily assign featured images for categories, tags, and custom taxonomy terms. Term meta, with images!

== Description ==

Advanced Term Fields: Featured Images extends the Advanced Term Fields framework to give users the ability to easily add and manage featured images for any category, tag, or custom taxonomy.

= Usage =

This is an extension of the **Advanced Term Fields** framework.  To use, the Advanced Term Fields plugin must be installed on your project.

You can find the plugin here: [Advanced Term Fields](https://wordpress.org/plugins/advanced-term-fields/)

= Check Out Other Extensions =

* [Advanced Term Fields: Colors](https://wordpress.org/plugins/advanced-term-fields-featured-images/) Color-code your terms!
* [Advanced Term Fields: Icons](https://wordpress.org/plugins/advanced-term-fields-icons/) Dashicons for your terms.
* [Advanced Term Fields: Featured Images](https://wordpress.org/plugins/advanced-term-fields-featured-images/) Featured images for terms!

== Installation ==

= From the WordPress.org plugin repository: =

* [Download](https://wordpress.org/plugins/advanced-term-fields-featured-images/) and install using the built in WordPress plugin installer.
* Activate in the "Plugins" area of your admin by clicking the "Activate" link.
* No further setup or configuration is necessary.

= From GitHub: =

* Download the [latest stable version](https://github.com/dboutote/Advanced-Term-Fields-Images/archive/master.zip).
* Extract the zip folder to your plugins directory.
* Activate in the "Plugins" area of your admin by clicking the "Activate" link.
* No further setup or configuration is necessary.


== Frequently Asked Questions ==

= Where can I find documentation? =

The plugin's official page: http://darrinb.com/advanced-term-fields-images

= Does this plugin depend on any others? =

Yes, this plugin is an extension of the Advanced Term Fields framework.  You'll need to install that plugin to handle all base functionality.

It can be found here:

* On WP: [Advanced Term Fields](https://wordpress.org/plugins/advanced-term-fields/)
* On GitHub: [Advanced Term Fields](https://github.com/dboutote/Advanced-Term-Fields)

= Does this create/modify/destroy database tables? =

This leverages the term meta capabilities added in WordPress 4.4.  No database modifications needed!

== Screenshots ==

1. Custom column to the Tag List Table.
2. Select your image using the native WordPress media picker.
3. Accessible from the Quick Edit form
4. Featured Image field on the Edit Tag screen.


== Changelog ==

= 0.1.1 =
* Added `$meta_slug` property for localizing js files and HTML attributes for form fields.
* Added check for update functionaliy to test for latest version.
* Changed meta field key to protected.
* Removed final keyword from Adv_Term_Fields_Images class.

= 0.1.0 =
* Initial release
