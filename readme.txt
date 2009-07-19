=== Plugin Name ===
Contributors: jhm
Donate link: http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/#donate
Tags: twitter, short-url, shortcode, url-shortener
Requires at least: 2.5
Stable tag: trunk

This plugin automatically generates a Short URL for your article. You can choose your favorite provider and get multiple options.

== Description ==

With this Plugin you **optimize your workflow** as it enables you to auto-generate a shortened URL to your blog posts. So neither you nor your readers have to do it. These Short URLs are particular useful for twitter and alike as these services limit the messages of their users to a certain amount of characters - which leads to the situation that their users are forced to have an eye on what exactly they want to write. And by providing a very short URL it's easier for them to spread the word on your blog article as they have more characters left for personal remarks.

Compared to other solutions **this plugin caches the generated shortened URL** - this makes it faster. If the permalink of the article changes, a new Short URL will be automatically generated. It also allows you to choose your favorite from a couple of Short URL Providers and lets you insert the shortened URL via a handy shortcode.


= Usage: =

* Place `[shorturl]` in your article where you want to display the shortened url.
* Add optional info with parameters (see below)
* If you don't like shortcodes you can use the complete auto mode - that way the shortened URL gets always auto-added at the end of your articles.


= Features: =

* Automatic generation of a Short URL to the blog post.
* **Caches the Short URL** - So it's only generated once.
* Offers 6 different URL Shorteners to choose from (bit.ly, tr.im, is.gd, u.nu, snurl.com, tinyurl.com).
* Provides optional parameters to further increase workflow.
* Can add self-defined labels in front (or around) the URL(s).


= Options: =
**Possible values are "1" for active and "0" for disabled**

* txt => Will add a label in front of the URL(s) (default: 0).
* full => The permalink will also be displayed (default: 0).
* link => Displays the URL(s) as HTML link (default: 0).
* short => Displays the Short URL (default: 1).

= Additional info =

For more information, examples, questions and previews - please have a look on the [plugins website](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/ "Short URL Plugin for Wordpress - Original post by Hendrik Jacob").

There is also a [german version of the plugins page](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress_german/ "Short URL Plugin für Wordpress - Original Artikel von Hendrik Jacob").


== Installation ==

1. Download the Plugin
1. Upload the shorturl.php into your “wp-content/plugins” folder of your blog
1. Activate the plugin ("Automatic Short URL") in your Wordpress-Admin Plugins page
1. Start using the shortcode in your articles where ever you like
1. If you like you can optimize the settings in the "Short URL" Settings-Page.

== Frequently Asked Questions ==

= Do I need to set any parameters? =

Nope, you can simply use [shorturl] to insert just the short url.

= Does the order of the parameters matter? =

Nope, you can use the optional parameters in any order - just like for all shortcodes.

= The labels added by the parameter "txt" suck, what can I do? =

You can define the labels in the "Short URL" Settings page, which can be found in the "Settings Box" in your Wordpress Admin Interface. 

= What is that "short" option for? =

It defaults to "1", so by default the Short URL will be displayed (thats what this whole thing is for). But maybe you want to post your permalink at the beginning of your article and the Short URL at the end, so you can use the shortcode twice - the first time with **short=0 and full=1** and the second time **without any** options.

= I found this plugin very useful, how can i show my appreciation? =

Spread the word and maybe write an blog post on this plugin with a link to the original post at [the autors page](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/ "Short URL Plugin for Wordpress - Original post by Hendrik Jacob").

== Screenshots ==

1. The Settings-Panel of this plugin
2. An example output of this plugin

== Changelog ==

= 1.1.1 = 
* Store Settings Bug (unknown action "empty2zero") solved
* The "pretty" permalink is now used
* From now on Short URLs get generated after the post is published, this way the URL Shorteners Databases don't get spammed by Draft URLs.

= 1.1 = 
* Short URL Provider "tr.im" has been added 

= 1.0 =
* A Settings Page is added.
* Support for 6 different URL Shortener Services (tr.im, is.gd, bit.ly, u.nu, snurl.com, tinyurl.com).
* Auto-Add functionality (optional!) - no need to write the shortcode by hand anymore.
* Auto added Short URLs support HTML code, so you can tweak their appearance with CSS classes and more.
* The Labels added by the "txt" parameter are now editable.
* A "Reset Settings" function, which removes Settings and URL Caches from posts.

= 0.1 =
* Inital release.