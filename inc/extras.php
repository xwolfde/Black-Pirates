<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package blackpirates
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blackpirates_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'blackpirates_body_classes' );



/*
 * Make URLs relative; Several functions
 */
function blackpirates_relativeurl($content){
        return preg_replace_callback('/<a[^>]+/', 'blackpirates_relativeurl_callback', $content);
}
function blackpirates_relativeurl_callback($matches) {
        $link = $matches[0];
        $site_link =  wp_make_link_relative(home_url());  
        $link = preg_replace("%href=\"$site_link%i", 'href="', $link);                 
        return $link;
    }
 add_filter('the_content', 'blackpirates_relativeurl');
 
 
 function blackpirates_relativeimgurl($content){
        return preg_replace_callback('/<img[^>]+/', 'blackpirates_relativeimgurl_callback', $content);
}
function blackpirates_relativeimgurl_callback($matches) {
        $link = $matches[0];
        $site_link =  wp_make_link_relative(home_url());  
        $link = preg_replace("%src=\"$site_link%i", 'src="', $link);                 
        return $link;
    }
 add_filter('the_content', 'blackpirates_relativeimgurl');
 
 /*
  * Replaces esc_url, but also makes URL relative
  */
 function blackpirates_esc_url( $url) {
     if (!isset($url)) {
	 $url = home_url("/");
     }
     return wp_make_link_relative(esc_url($url));
 }
 
 function blackpirates_get_template_uri () {
     return wp_make_link_relative(get_template_directory_uri());
 } 

add_action('template_redirect', 'blackpirates_relative_urls');
function blackpirates_relative_urls() {
    // Don't do anything if:
    // - In feed
    // - In sitemap by WordPress SEO plugin
    if (is_admin() || is_feed() || get_query_var('sitemap')) {
        return;
    }
    $filters = array(
    //    'post_link',
        'post_type_link',
        'page_link',
        'attachment_link',
        'get_shortlink',
        'post_type_archive_link',
        'get_pagenum_link',
        'get_comments_pagenum_link',
        'term_link',
        'search_link',
        'day_link',
        'month_link',
        'year_link',
        'script_loader_src',
        'style_loader_src',
    );
    foreach ($filters as $filter) {
        add_filter($filter, 'blackpirates_make_link_relative');
    }
}

function blackpirates_make_link_relative($url) {
    $current_site_url = get_site_url();   
	if (!empty($GLOBALS['_wp_switched_stack'])) {
        $switched_stack = $GLOBALS['_wp_switched_stack'];
        $blog_id = end($switched_stack);
        if ($GLOBALS['blog_id'] != $blog_id) {
            $current_site_url = get_site_url($blog_id);
        }
    }
    $current_host = parse_url($current_site_url, PHP_URL_HOST);
    $host = parse_url($url, PHP_URL_HOST);
    if($current_host == $host) {
        $url = wp_make_link_relative($url);
    }
    return $url; 
}
