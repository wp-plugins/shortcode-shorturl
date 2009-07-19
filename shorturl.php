<?php
/*
Plugin Name: Short URL Generator
Plugin URI: http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/
Description: Plugin which adds an shortened URL to your blog posts. Handy for microblogging services like Twitter.
Version: 1.1.1
Author: Jan Hendrik Merlin Jacob
Author URI: http://hjacob.com/blog/
*/

$jhm_valid_attribute_values = array("1","y","yes","ja");

function jhm_shorturl(&$atts) {
	global $post, $jhm_valid_attribute_values;
	# Parse Attribute(s)
	
	extract(shortcode_atts(array('short' => "1", 'full' => "0", 'link' => '0', 'txt' => "0"), $atts));
	$_s = jhm_shorturl_settings_load();

	$short_url = get_post_meta( $post->ID, 'short_url');
	#print("<br/>".print_r($short_url)."<br/><br>");
	#delete_post_meta( $post->ID, 'short_url' );	
	
	if($short_url && $short_url[0]["slug"] == $post->post_name) {
		# Get the Cached Version
		$short_url = $short_url[0]["url"];
	} else {
		if($short_url && $short_url.length > 0 ) {
			# URL was changed - so expire cache
			delete_post_meta( $post->ID, 'short_url' );
		}
		# Get new shorturl
		$short_url = jhm_shorturl_set($post);
	}
	
	if(empty($short_url)) { return; }
	
	$result = array();
	$i=0;
	# Determine occurance and visibility of shorturl
	if(in_array($short, $jhm_valid_attribute_values)) {
		$i++;
		if(in_array($link, $jhm_valid_attribute_values)) {
			$result[$i] = '<a href="'.$short_url.'">'.$short_url.'</a>';
		} else {
			$result[$i] = $short_url;		
		}
		if(in_array($txt, $jhm_valid_attribute_values)) {
			$result[$i] = str_replace("%s%", $result[$i], $_s["label_short"]);
		}
	}

	# Determine occurance and visibility of full url
	if(in_array($full, $jhm_valid_attribute_values)) {
		$i++;
		if(in_array($link, $jhm_valid_attribute_values)) {
			$result[$i] = '<a href="'.get_permalink($post->id).'">'.get_permalink($post->id).'</a>';
		} else {
			$result[$i] = get_permalink($post->id);
		}
		if(in_array($txt, $jhm_valid_attribute_values)) {
			$result[$i] = str_replace("%s%", $result[$i], $_s["label_full"]);
		}
	}

	# Pack together and fire :)
	return join("<br/>\n",$result);
}


function jhm_shorturl_set($post) {
	if($post->post_status != "publish" and $post->post_status != "static") {
		return "<i>Short URL will be generated after this post is published</i>";
	}
	$_s = jhm_shorturl_settings_load();
	$url = get_permalink($post->id);
	switch($_s["provider"]) {
			   # Determine Request API URL
			   case "unu": 	$_r = 'http://u.nu/unu-api-simple?url=' . urlencode($url); break;
			   case "isgd": $_r = 'http://is.gd/api.php?longurl=' . $url; break;
			   case "snurl": $_r = 'http://sn.im/site/snip?r=simple&link=' . urlencode($url); break;
			   case "tiny": $_r = 'http://tinyurl.com/api-create.php?url=' . urlencode($url); break;
			   case "trim": $_r = 'http://api.tr.im/api/trim_simple?url=' . urlencode($url); break;
			}
			
   # Else use bit.ly the default provider
   if(!$_r) { $_r = 'http://bit.ly/api?url=' . urlencode($url); }
			
	if($short_url = file_get_contents($_r)) {
		add_post_meta( $post->ID, 'short_url', array("url"=>$short_url, "slug"=>$post->post_name) );
		return $short_url;
	} else {
		return "";
	}
}


function jhm_shorturl_settings_load() {
	# Loads the Short URL Settings
	global $jhm_shorturl_settings_cache;
	
	# If the Settings were already loaded in this instance - return them from cache
	if(!empty($jhm_shorturl_settings_cache)) { return $jhm_shorturl_settings_cache; }
	
	$user_settings = (array) get_option('jhm_shorturl');
	$default_settings = array(
		"provider" => "bitly",
		"auto" => "[shorturl txt=1]",
		"label_short" => "Short URL for this post: %s%",
		"label_full" => "Full URL for this post: %s%",);

	if ( $default_settings !== $user_settings ) {
		foreach ( (array) $user_settings as $key1 => $value1 ) {
			if ( is_array($value1) ) {
				foreach ( $value1 as $key2 => $value2 ) {
					$default_settings[$key1][$key2] = $value2;
				}
			} else {
				$default_settings[$key1] = $value1;
			}
		}
	}
	
	$jhm_shorturl_settings_cache = $default_settings;
	return $default_settings;
}


function jhm_shorturl_settings() {
	# The Shorturl Settings Page in WP-Admin
	
	# Reset settings if requested
	if($_POST["reset"] == "reset") { 
		delete_option("jhm_shorturl");	
		
		# Remove Short URL Caches from posts:
	  	$allposts = get_posts('numberposts=0&post_type=post&post_status=publish|draft|future|pending');

		foreach( $allposts as $postinfo) {
		  delete_post_meta($postinfo->ID, 'short_url');
		}
		echo('<div id="message" class="updated fade"><p>Settings were set back to default values and Short URL caches were emptied.</p></div>');
	}
	
	# Start  with loading Settings
	$_s = jhm_shorturl_settings_load();
	
	# Handle POST request (-> Store data)
	if($_POST["store_shorturl_settings"]) {
		$_s["provider"] = $_POST["provider"];
		$_s["auto"] = $_POST["auto"];
		$_s["label_short"] = $_POST["label_short"];
		$_s["label_full"] = $_POST["label_full"];
		update_option( 'jhm_shorturl', $_s);
		echo('<div id="message" class="updated fade"><p>Short URL Settings are stored.</p></div>');
	}
	
	
	# Output the form
	print'
		<div class="wrap">
		'.(function_exists('screen_icon') ? screen_icon() : "").'
		<h2>Short URL Settings</h2>
		</div>
		<form method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'">';
		
	if ( function_exists('wp_nonce_field') ) { echo(wp_nonce_field('short_url-nonce'));	}
	
	print'
		<input type="hidden" name="store_shorturl_settings" value="1"/>
		<input type="hidden" name="action" value="shorturl" />
		<table class="form-table" style="width:580px;">
		<tbody>
		<tr valign="top">
		<th scope="row">Provider</th>
		<td>
		<fieldset>
		<legend class="hidden">Provider</legend>
		<label for="prov-bitly">
			<input id="prov-bitly" type="radio" '.($_s["provider"]=="bitly" ? 'checked="checked"' : '').' value="bitly" name="provider"/>
			bit.ly (<a href="http://bit.ly/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label><br/>
		<label for="prov-trim">
			<input id="prov-trim" type="radio" '.($_s["provider"]=="trim" ? 'checked="checked"' : '').' value="trim" name="provider"/>
			tr.im (<a href="http://tr.im/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label><br/>
		<label for="prov-isgd">
			<input id="prov-isgd" type="radio" '.($_s["provider"]=="isgd" ? 'checked="checked"' : '').' value="isgd" name="provider"/>
			is.gd (<a href="http://is.gd/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label><br/>
		<label for="prov-unu">
			<input id="prov-unu" type="radio" '.($_s["provider"]=="unu" ? 'checked="checked"' : '').' value="unu" name="provider"/>
			u.nu (<a href="http://u.nu/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label><br/>
		<label for="prov-snurl">
			<input id="prov-snurl" type="radio" '.($_s["provider"]=="snurl" ? 'checked="checked"' : '').' value="snurl" name="provider"/>
			snurl (<a href="http://sn.im/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label><br/>
		<label for="prov-tiny">
			<input id="prov-tiny" type="radio" '.($_s["provider"]=="tiny" ? 'checked="checked"' : '').' value="tiny" name="provider"/>
			tinyurl (<a href="http://tinyurl.com/" target="_blank" style="font-size:10px">Visit Homepage</a>)
		</label>
		</fieldset>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">Auto display</th>
		<td>
		<fieldset>
		<legend class="hidden">Usage</legend>
			<input id="auto-2" type="text" name="auto" value="'.htmlspecialchars(str_replace("\'", "'", str_replace('\"',"'",$_s["auto"]))).'" style="width:98%"/><br/>
			<label for="auto-2">This code (HTML allowed!) gets <b>automatically added at the bottom</b> of your articles. <span style="text-decoration:underline">Leave it blank, if you want to add the Short URL by hand</span>. You can use the [shorturl] - shortcode at any position of your article to display the Short URL.</label>
		</fieldset>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">Labels</th>
		<td>
		<fieldset>
		<legend class="hidden">Labels</legend>
			<label for="label_short"><b>Select a label for Short URL:</b><br/>
			<span style="color:#acacac">Place %s% where you want to display the shortened URL</span></label><br/>
			<input type="text" name="label_short" id="label_short" value="'.$_s["label_short"].'" style="width:98%"/>
			<br/><br/>
			<label for="label_full"><b>Select a label for Full URL:</b><br/>
			<span style="color:#acacac">Place %s% where you want to display the Full URL</span></label><br/>
			<input type="text" name="label_full" id="label_full" value="'.$_s["label_full"].'" style="width:98%"/>
		</legend>
		</fieldset>
		</td>
		</tr>
		<tr>
		<th></th>
		<td style="padding-bottom:20px">
			<a style="float:right" href="http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/" target="_blank">Support &amp; Feedback Page</a>
			<input type="submit" value="Store settings"/>
		</td>
		</tr>
		</table>
		</form>
		<hr style="max-width:580px; margin:30px auto 20px 0 "/>
		<p style="max-width:580px;"><b>Did you know?</b> You can tweak the appearance of your Short URL by adding attributes. Available attributes are: "txt", "full", "link" and "short". Possible values are "1" for active and "0" for disabled. <a href="http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/" target="_blank">Learn more about attributes and see examples.</a></p>
		<hr style="max-width:580px; margin:30px auto 20px 0 "/>
		<form action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'" method="post" style="max-width:580px;">
		<b style="color:red">Reset Settings</b><br/>
		If you\'d like to reset the Short URL Plugin Settings to their default values - click this button:<br/><br/>';
		if(function_exists('wp_nonce_field')) { echo(wp_nonce_field('short_url-nonce')); }
		print'
		<input type="hidden" value="reset" name="reset"/>
		<input type="submit" value="Reset the Short URL Settings"/>
		</p>
	';
}

function jhm_shorturl_settings_link() {
	# Adds the link to the Config Page into WP Admin
	if ( function_exists('add_submenu_page') )
		add_options_page('Short URL', 'Short URL', 'manage_options', 'shorturl', 'jhm_shorturl_settings');
}

function jhm_shorturl_auto_check($content) {
	# Check if auto-insert has been activated and if so -> insert content
	
	if(!is_single()) { echo(do_shortcode($content)); return; }
	
	$_s = jhm_shorturl_settings_load();
	if(!empty($_s["auto"])) {
		$content = $content . str_replace("\'", "'", str_replace('\"',"'", do_shortcode($_s["auto"])));
	} 
	echo(do_shortcode($content));
}


# Init actions
$jhm_shorturl_settings_cache = array();
add_shortcode('shorturl', 'jhm_shorturl');
add_action('admin_menu', 'jhm_shorturl_settings_link');
add_action('the_content','jhm_shorturl_auto_check')

?>