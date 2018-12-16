<?php
/**
 * Function BX_get_pages
 * ------------------------------------------------------
 * Returns the following of all WP pages:
 * ID, title, name, (content)
 *
 * $withcontent		specifies if the page's content will
 *					also be returned
 */

function BX_get_pages($with_content = '')
{
    global $wpdb;
    $query = "SELECT ID, post_title, post_name FROM " . $wpdb->posts . " WHERE post_type='page' OR post_status='static' ORDER BY menu_order ASC";
	
	if ($with_content == "with_content") {
	   $query = "SELECT ID, post_title,post_name, post_content FROM " . $wpdb->posts . " WHERE post_type='page' OR post_status='static' ORDER BY menu_order ASC";
	}
	return $wpdb->get_results($query);
}


/**
 * Function BX_excluded_pages()
 * ------------------------------------------------------
 * Returns the Blix default pages that are excluded
 * from the navigation in the sidebar
 *
 */

function BX_excluded_pages()
{
	$pages = BX_get_pages();
	$exclude = "";
	if ($pages) {
		foreach ($pages as $page) {
			$page_id = $page->ID;
   			$page_name = $page->post_name;
   			if ($page_name == "archives" || $page_name == "about"  || $page_name == "about_short" || $page_name == "contact") {
   				$exclude .= ", ".$page_id;
   			}
   		}
   		$exclude = preg_replace("/^, (.*?)/","\\1",$exclude);
   	}
   	return $exclude;
}

/*Widgets Code
----------------------------------------------------------
Adds widgets plugin compatiblilty.
*/

if ( function_exists('register_sidebar') )
    register_sidebars(2, array(
        'before_widget' => '<div class="left-box">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));
?>