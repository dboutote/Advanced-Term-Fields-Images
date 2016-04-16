=== Advanced Term Images ===
Contributors: dbmartin
Tags: term-meta, term, meta, metadata, taxonomy, image, images, featured-images, category-images
Requires at least: 4.4
Tested up to: 4.5
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add featured images to your categories, tags, and custom taxonomy terms. Supports all taxonomies!

== Description ==

**Advanced Term Images** gives users the ability to easily add and manage featured images for categories, tags, and custom taxonomies.

**Update:** As of version 1.0 this plugin no longer relies on the Advanced Term Fields framework. All functionality from that framework has been incorporated within this plugin.

= Usage =

Once you've installed and activated the plugin, you should see a new form field in your edit tags screen.  (See the Screenshots tab.)

Use the native WordPress media picker to select a featured image for your term.

= Also Check Out: =

* [Advanced Term Colors](https://wordpress.org/plugins/advanced-term-fields-colors/)
* [Advanced Term Icons](https://wordpress.org/plugins/advanced-term-fields-icons/)
* [Advanced Term Images](https://wordpress.org/plugins/advanced-term-fields-featured-images/)
* [Advanced Term Locks](https://wordpress.org/plugins/advanced-term-fields-locks/)

== Installation ==

= From the WordPress.org plugin repository: =

* Download and install using the built in WordPress plugin installer.
* Activate in the "Plugins" area of your admin by clicking the "Activate" link.
* No further setup or configuration is necessary.


== Frequently Asked Questions ==

= Where can I find additional documentation? =

The plugin's official page: http://darrinb.com/plugins/advanced-term-images

= Does this plugin depend on any others? =

Nope!  It _used_ to depend on the Advanced Term Fields plugin, but as of version 1.0, all functionality has been incorporated into this plugin.

= Does this create/modify/destroy database tables? =

This leverages the term meta capabilities added in WordPress 4.4.  No database modifications needed!

= Are there other plugins in this family? =

Yep!  This is a list of all current term meta plugins:

* [Advanced Term Colors](https://wordpress.org/plugins/advanced-term-fields-colors/)
* [Advanced Term Icons](https://wordpress.org/plugins/advanced-term-fields-icons/)
* [Advanced Term Images](https://wordpress.org/plugins/advanced-term-fields-featured-images/)
* [Advanced Term Locks](https://wordpress.org/plugins/advanced-term-fields-locks/)

== Screenshots ==

1. Custom column on the Tag List Table.
2. Select your image using the native WordPress media picker.
3. Accessible from the Quick Edit form
4. Featured Image field on the Edit Tag screen.


== Changelog ==

= 1.0 =
* Incorporated Advanced Term Fields framework into plugin.
* Namespaced all option keys.
* WP 4.5 Compatibility updates: added 'load-term.php' action hook.
* Bug fix: on quick edit form when $taxonomy is not defined.

= 0.1.1 =
* Added `$meta_slug` property for localizing js files and HTML attributes for form fields.
* Added check for update functionaliy to test for latest version.
* Changed meta field key to protected.
* Removed final keyword from Adv_Term_Fields_Images class.

= 0.1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
This version fixes compatibility issues with WP 4.5.



