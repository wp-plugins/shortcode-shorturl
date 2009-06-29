<?php
/*
Plugin Name: Shortcode [shorturl]
Plugin URI: http://hjacob.com/blog/2009/06/short_url_shortcode_wordpress/
Description: Shortcode to add a autogenerated short url (provider: u.nu). Please visit plugin page for attribute list and support.
Version: 0.1
Author: Jan Hendrik Merlin Jacob
Author URI: http://hjacob.com/blog/
*/

function jhm_shorturl_set($post) {
	$request = 'http://u.nu/unu-api-simple?url=' . urlencode($post->guid);
	$short_url = file_get_contents($request);
	add_post_meta( $post->ID, 'short_url', array("url"=>$short_url, "slug"=>$post->post_name) );
	return $short_url;
}

function jhm_shorturl($atts) {
	global $post;
	# Parse Attribute(s)

	extract(shortcode_atts(array('short' => "1", 'full' => "0", 'link' => '0', 'txt' => "0"), $atts));

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
	
	$result = array();
	$i=0;
	# Determine occurance and visibility of shorturl
	if($short == "1" || $short == "y" || $short == "yes") {
		$i++;
		if($link == "1" || $link == "y" || $link == "yes") {
			$result[$i] = '<a href="'.$short_url.'">'.$short_url.'</a>';
		} else {
			$result[$i] = $short_url;		
		}
		if($txt == "1" || $txt == "y" || $txt == "yes") {
			$result[$i] = 'Short URL for this post: '.$result[$i];
		}
	}

	# Determine occurance and visibility of full url
	if($full == "1" || $full == "y" || $full == "yes") {
		$i++;
		if($link == "1" || $link == "y" || $link == "yes") {
			$result[$i] = '<a href="'.$post->guid.'">'.$post->guid.'</a>';
		} else {
			$result[$i] = $post->guid;
		}
		if($txt == "1" || $txt == "y" || $txt == "yes") {
			$result[$i] = 'Full URL for this post: '.$result[$i];		
		}
	}

	# Pack together and fire :)
	return join("<br/>\n",$result);
}

add_shortcode('shorturl', 'jhm_shorturl');

?>