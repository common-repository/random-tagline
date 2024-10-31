=== Random Tagline ===
Contributors: poslundc
Tags: random, tagline
Requires at least: 2.5.1
Tested up to: 2.5.1
Stable tag: trunk

Replaces the blog tagline with a random tagline from a text file.

== Description ==

Replaces the tagline on your blog with a random tagline selected from a taglines file you provide.

Version 1.2 adds diagnostic information to the settings page.
Version 1.1 makes the random tagline consistent throughout a single page display.

== Installation ==

1. Drop the file random_tagline.php into /wp-content/plugins
1. Activate the plugin in the Plugin Management page
1. On your Settings page, select Random Tagline
1. Enter the path to your tagline file, and click Save Changes 

All occurrences of your tagline throughout your blog (except the General Settings page) should now randomly select from the file you specified.

== The Tagline File ==

The tagline file should contain all of the taglines you want to randomly select from. It is return-delimited, ie. there is one tagline per line.
