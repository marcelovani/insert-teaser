=== Teaser Shortcode ===
Contributors: Marcelo Vani
Tags: teaser shortcode
Requires at least: 2.7
Stable tag: 1.0


== Description ==

Provides an easy way to insert teaser/excerpt to any post by using shortcodes.
You can specify the number of columns for a grid layout and the size of the teaser image.
Also, you can use <!--more--> to limit the description that is displayed with the teaser.


== Installation ==

= Manual installation  =

1. Download [Insert Teaser](http://wordpress.org/extend/plugins/insert-teaser "Insert Teaser package") from wordpress.org Plugin Directory
1. Extract and upload the entire `post-teaser` directory as `.../wp-content/plugins/insert-teaser` directory of your WordPress installation.
1. Go to the Plugins configuration page in your WordPress admin panel, and enable Insert Teaser

= Auto installation (2.7.x and above) =

1. Click on the link `Plugin Browser/Installer` under the "Get More Plugins" section at the bottom of the Plugins page
1. Search for "insert teaser" in Term.
1. Click on the install action on the right side of the table where Insert Teaser is listed.
1. Follow WordPress instruction to complete the installation.


== Using it ==

Add the following shortcode into any content:
[insert_teaser post_id=222 width="250" height="200"]

Parameters:
  width, height: correspond to the size of the image atrached to the content.
  columns: number of columns, if you want to display the teasers side by side.

The following example will display one large teaser:
[insert_teaser post_id=222 width="250" height="200" columns="1"]

The following example will display 2 teasers, side by side.
[insert_teaser post_id=222 width="250" height="200" columns="2"]

[insert_teaser post_id=176 width="250" height="200" columns="2"]

The following example will display 4 teasers side by side.
[insert_teaser post_id=222 width="250" height="200" columns="4"]

[insert_teaser post_id=176 width="250" height="200" columns="4"]

[insert_teaser post_id=176 width="250" height="200" columns="4"]

[insert_teaser post_id=176 width="250" height="200" columns="4"]
