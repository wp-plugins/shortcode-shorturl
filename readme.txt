=== Plugin Name ===
Contributors: jhm
Donate link: http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/#donate
Tags: twitter, short-url, shortcode, url-shortener
Requires at least: 2.8
Tested up to: 2.8
Stable tag: trunk

With this Shortcode you are able to easily add a twitter optimized URL to your blog posts, so your readers do not have to create it on their own.

== Description ==

With this Shortcode-Plugin you **optimize your workflow** as it enables you to auto-generate a shortened URL to your blog posts. So neither you nor your readers have to do it. These Short URLs are particular useful for twitter and alike as these services limit the messages of their users to a certain amount of characters - which leads to the situation that their users are forced to have an eye on what exactly they want to write. And by providing a very short URL it's easier for them to spread the word on your blog article as they have more characters left for personal remarks.

Compared to other solutions **this plugin caches the generated shortened URL** - this makes it faster. If the permalink of the article changes, a new Short URL will be automatically generated. 


= Usage: =

* Place `[shorturl]` in your article where you want to display the shortened url.
* Add optional info with parameters (see below)


= Features: =

* Automatic generation of a Short URL to the blog post
* **Caches the Short URL** - So it's only generated once
* Uses "u.nu" as provider with the **shortest URLs on the net**
* Provides optional parameters to further increase workflow


= Options: =
**Possible values are "1" for active and "0" for disabled**

* txt => Will add a label in front of the URL(s) (default: 0)
* full => The permalink will also be displayed (default: 0)
* link => Displays the URL(s) as HTML link (default: 0)
* short => Displays the Short URL (default: 1)

= Additional info =

For more information, examples, questions and previews - please have a look on the [plugins website](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/ "Short URL Plugin for Wordpress - Original post by Hendrik Jacob").

There is also a [german version of the plugins page](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress_german/ "Short URL Plugin für Wordpress - Original Artikel von Hendrik Jacob").


== Installation ==

1. Download the Plugin
1. Upload the shorturl.php into your “wp-content/plugins” folder of your blog
1. Activate the shortcode in your Wordpress-Admin Plugins page
1. Start using the shortcode in your articles where ever you like

== Frequently Asked Questions ==

= Do I need to set any parameters? =

Nope, you can use simply [shorturl] to insert just the short url.

= Does the order of the options matter? =

Nope, you can use the optional parameters in any order - just like for all shortcodes.

= The labels added by the parameter "txt" suck, what can I do? =

The plugin doesn't offer a settings page yet, so if you have an HTML editor you can open the "shorturl.php" (in your wp plugin folder) and search for "Short URL for this post: " and replace it with what ever you like. Please make sure that it's still surrounded with quotation marks, otherwise the code gets broken :).

= What is that "short" option for? =

It defaults to "1", so by default the Short URL will be displayed (thats what this whole thing is for). But maybe you want to post your permalink at the beginning of your article and the Short URL at the end, so you can use the shortcode twice - the first time with **short=0 and full=1** and the second time **without any** options.

= I found this plugin very useful, how can i show my appreciation? =

Spread the word and maybe write an blog post on this plugin with a link to the original post at [the autors page](http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/ "Short URL Plugin for Wordpress - Original post by Hendrik Jacob").

== Screenshots ==

1. An example output of the plugin

== Changelog ==

= 0.1 =
* Inital release.