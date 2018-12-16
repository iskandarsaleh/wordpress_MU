<?php

////////////////////////////////////////////////////////////////////////////////
// Short title
////////////////////////////////////////////////////////////////////////////////

function the_short_title(){

echo substr_replace(the_title('','',false),'...','40');

}

////////////////////////////////////////////////////////////////////////////////
// wp 2.7 wp_list_pingback
////////////////////////////////////////////////////////////////////////////////

function list_pings($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

add_filter('get_comments_number', 'comment_count', 0);

function comment_count( $count ) {
	global $id;
	$comments_by_type = &separate_comments(get_comments('post_id=' . $id));
	return count($comments_by_type['comment']);
}


////////////////////////////////////////////////////////////////////////////////
// WP-PageNavi
////////////////////////////////////////////////////////////////////////////////


function custom_wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class=\"wp-pagenavi\"><span class=\"pages\">Page $paged of $max_page:</span>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.get_pagenum_link().'">&laquo; First</a>';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='current'>$i</strong>";
					} else {
						echo ' <a href="'.get_pagenum_link($i).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '<a href="'.get_pagenum_link($max_page).'">Last &raquo;</a>';
			}
			echo "</div> $after";
		}
	}
}




////////////////////////////////////////////////////////////////////////////////
// Comment and pingback separate controls
////////////////////////////////////////////////////////////////////////////////

$bm_trackbacks = array();
$bm_comments = array();

function split_comments( $source ) {

    if ( $source ) foreach ( $source as $comment ) {

        global $bm_trackbacks;
        global $bm_comments;

        if ( $comment->comment_type == 'trackback' || $comment->comment_type == 'pingback' ) {
            $bm_trackbacks[] = $comment;
        } else {
            $bm_comments[] = $comment;
        }
    }
}

////////////////////////////////////////////////////////////////////////////////
// Most Comments
////////////////////////////////////////////////////////////////////////////////

function get_hottopics($limit = 10) {
    global $wpdb, $post;
    $mostcommenteds = $wpdb->get_results("SELECT  $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT $limit");
    foreach ($mostcommenteds as $post) {
			$post_title = htmlspecialchars(stripslashes($post->post_title));
			$comment_total = (int) $post->comment_total;
			echo "<li><a href=\"".get_permalink()."\">$post_title&nbsp;<strong>($comment_total)</strong></a></li>";
    }
}


////////////////////////////////////////////////////////////////////////////////
// excerpt features
////////////////////////////////////////////////////////////////////////////////

function the_excerpt_feature($excerpt_length=150, $allowedtags='', $filter_type='', $use_more_link=true, $more_link_text="...read full article&raquo;", $force_more_link=true, $fakeit=1, $fix_tags=true) {
	if (preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) {
		$filter_type = 'the_' . $filter_type;
	}
	$text = apply_filters($filter_type, get_the_excerpt_feature($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit));
	$text = ($fix_tags) ? balanceTags($text) : $text;
	echo $text;
}

function get_the_excerpt_feature($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit) {
	global $id, $post;
	$output = '';
	$output = $post->post_excerpt;
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			$output = __('There is no excerpt because this is a protected post.');
			return $output;
		}
	}

	// If we haven't got an excerpt, make one.
	if ((($output == '') && ($fakeit == 1)) || ($fakeit == 2)) {
		$output = $post->post_content;
		$output = strip_tags($output, $allowedtags);
		$blah = explode(' ', $output);
		if (count($blah) > $excerpt_length) {
			$k = $excerpt_length;
			$use_dotdotdot = 1;
		} else {
			$k = count($blah);
			$use_dotdotdot = 0;
		}
		$excerpt = '';
		for ($i=0; $i<$k; $i++) {
			$excerpt .= $blah[$i] . ' ';
		}
		// Display "more" link (use css class 'more-link' to set layout).
		if (($use_more_link && $use_dotdotdot) || $force_more_link) {
			$excerpt .= "<a href=\"". get_permalink() . "#more-$id\">$more_link_text</a>";
		} else {
			$excerpt .= ($use_dotdotdot) ? '...' : '';
		}
		 $output = $excerpt;
	} // end if no excerpt
	return $output;
}


////////////////////////////////////////////////////////////////////////////////
// end
////////////////////////////////////////////////////////////////////////////////

if ( function_exists('register_sidebar') ) {
register_sidebar(array('name'=>'Top-Left',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Top-Center',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Top-Right',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Bottom-Left',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Bottom-Right',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Sidebar',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

function unregister_problem_widgets() {
unregister_sidebar_widget('Search');
unregister_sidebar_widget('FlickrRSS');
}
add_action('widgets_init','unregister_problem_widgets');
}








////////////////////////////////////////////////////////////////////////////////
// CUSTOMIZE BACKEND FOR WPMU-CMS
////////////////////////////////////////////////////////////////////////////////









$themename = "WPMU-TRIDEN";
$shortname = "tn";
$short_prefix = "wpmu_tri_";

$tpl_dir = get_bloginfo('template_directory');
$tpl_url = get_bloginfo('wpurl');

$mywp_version = get_bloginfo('version');
if ($mywp_version >= '2.3') {
$wp_dropdown_rd_admin = $wpdb->get_results("SELECT $wpdb->term_taxonomy.term_id,name,description,count FROM $wpdb->term_taxonomy LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id WHERE parent = 0 AND taxonomy = 'category' GROUP BY $wpdb->terms.name ORDER by $wpdb->terms.name ASC");
$wp_getcat = array();
foreach ($wp_dropdown_rd_admin as $category_list) {
$wp_getcat[$category_list->term_id] = $category_list->name;
}
$category_bulk_list = array_unshift($wp_getcat, "Choose a category");
} else {
$wp_dropdown_rd_admin = get_categories('hide_empty=0&orderby=name');
$wp_getcat = array();
foreach ($wp_dropdown_rd_admin as $category_list) {
$wp_getcat[$category_list->cat_ID] = $category_list->cat_name;
}
$category_bulk_list = array_unshift($wp_getcat, "Choose a category");
}





$options = array (

    array (	"name" => __("Choose your layout mode?"),
			"id" => $shortname . "_" . $short_prefix . "layout_mode",
            "inblock" => "main-layout",
            "box" => "1",
			"type" => "select",
            "std" => "custom homepage",
            "options" => array("custom homepage","blog homepage")),



    array(	"name" => __("Do you want to used the social bar in posts?:"),
			 "id" => $shortname . "_" . $short_prefix . "social_status",
             "inblock" => "main-layout",
            "box" => "1",
			"type" => "select",
            "std" => "disable",
			"options" => array("disable", "enable")),



    array (	"name" => __("Show a login panel and logged in users profile?:"),
			 "id" => $shortname . "_" . $short_prefix . "show_profile",
             "inblock" => "main-layout",
            "box" => "1",
			"type" => "select",
            "std" => "yes",
            "options" => array("yes","no")),


    array(	"name" => __("Enter some information about yourself or the site (only displayed if the login panel is enabled)"),
			 "id" => $shortname . "_" . $short_prefix . "profile_text",
            "inblock" => "main-layout",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),








    array (	"name" => __("Choose your background colour?"),
			"id" => $shortname . "_" . $short_prefix . "bg_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your content background colour?"),
			"id" => $shortname . "_" . $short_prefix . "container_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your body <strong>line</strong> colour? *grid lines and separate lines"),
			"id" => $shortname. "_" . $short_prefix . "content_line_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("If you want to use an image as the background please upload the image here:<br /><a target=\"_blank\" href=\"$tpl_url/wp-admin/themes.php?page=gallery.php\">upload image</a>"),
			"id" => $shortname . "_" . $short_prefix . "bg_image",
            "inblock" => "layout",
            "box" => "1",
            "std" => "",
			"type" => "text"),



array(
"name" => __("Background Images Repeat"),
"id" => $shortname . "_" . $short_prefix . "bg_image_repeat",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "no-repeat",
"options" => array("no-repeat","repeat","repeat-x","repeat-y")),


array(
"name" => __("Background Images Attachment"),
"id" => $shortname . "_" . $short_prefix . "bg_image_attachment",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "fixed",
"options" => array("fixed", "scroll")),


array(
"name" => __("Background Images Horizontal Position"),
"id" => $shortname . "_" . $short_prefix . "bg_image_horizontal",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "left",
"options" => array("left", "center", "right")),


array(
"name" => __("Background Images Vertical Position"),
"id" => $shortname . "_" . $short_prefix . "bg_image_vertical",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "top",
"options" => array("top", "center", "bottom")),





    array(	"name" => __("Choose your global body font?"),
			"id" => $shortname . "_" . $short_prefix . "body_font",
            "type" => "select",
            "box" => "2",
            "inblock" => "font",
			"std" => "Helvetica, Arial, sans-serif",
			"options" => array(
            "Helvetica, Arial, sans-serif",
            "Helvetica LT Light, Helvetica, Arial",
            "Candara, Arial, Cambria, Georgia, Times New Roman",
            "Univers LT 55, Lucida Grande, Lucida Sans",
            "Arial, Verdana, Times New Roman, sans-serif",
            "Verdana, Arial, Times New Roman, sans-serif",
            "Calibri, Helvetica, Trebuchet MS",
            "Lucida Grande, Verdana, Tahoma, Trebuchet MS",
            "Times New Roman, Georgia, Tahoma, Trajan Pro",
            "Georgia, Times New Roman, Helvetica, sans-serif",
            "Cambria, Georgia, Times New Roman",
            "Futura LT Book, Helvetica Neue, Tahoma, Georgia",
            "Tahoma, Lucida Sans, Arial",
            "Lucida Sans, Lucida Grande, Trebuchet MS",
            "Century Gothic, Century, Georgia, Times New Roman",
            "Arial Rounded MT Bold, Arial, Verdana, sans-serif",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS",
            "Delicious, Delicious Heavy, Decker, Denmark",
            "Helvetica Neue, Helvetica LT Std Cond, Helvetica-Normal",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande, Georgia",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS, Tahoma, Arial",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Myriad Pro, Myriad Pro Black SemiExt, Trebuchet MS, Tahoma",
            "Anivers, Trebuchet MS, Tahoma",
            "Geneva, Arial, Verdana, sans-serif"
            )
            ),

	array(	"name" => __("Choose your global headline font"),
			"id" => $shortname . "_" . $short_prefix . "headline_font",
            "type" => "select",
            "box" => "2",
            "inblock" => "font",
            "std" => "Helvetica, Arial, sans-serif",
			"options" => array(
            "Helvetica, Arial, sans-serif",
            "Helvetica LT Light, Helvetica, Arial",
            "Candara, Arial, Cambria, Georgia, Times New Roman",
            "Univers LT 55, Lucida Grande, Lucida Sans",
            "Arial, Verdana, Times New Roman, sans-serif",
            "Verdana, Arial, Times New Roman, sans-serif",
            "Calibri, Helvetica, Trebuchet MS",
            "Lucida Grande, Verdana, Tahoma, Trebuchet MS",
            "Times New Roman, Georgia, Tahoma, Trajan Pro",
            "Georgia, Times New Roman, Helvetica, sans-serif",
            "Cambria, Georgia, Times New Roman",
            "Futura LT Book, Helvetica Neue, Tahoma, Georgia",
            "Tahoma, Lucida Sans, Arial",
            "Lucida Sans, Lucida Grande, Trebuchet MS",
            "Century Gothic, Century, Georgia, Times New Roman",
            "Arial Rounded MT Bold, Arial, Verdana, sans-serif",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS",
            "Delicious, Delicious Heavy, Decker, Denmark",
            "Helvetica Neue, Helvetica LT Std Cond, Helvetica-Normal",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande, Georgia",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS, Tahoma, Arial",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Myriad Pro, Myriad Pro Black SemiExt, Trebuchet MS, Tahoma",
            "Anivers, Trebuchet MS, Tahoma",
            "Geneva, Arial, Verdana, sans-serif"
            )
            ),

    array(	"name" => __("Choose your font size here?"),
			"id" => $shortname . "_" . $short_prefix . "font_size",
            "box" => "2",
            "inblock" => "font",
			"type" => "select",
            "std" => "normal",
			"options" => array("normal","small", "bigger", "largest")),


   array (	"name" => __("Change your global body font colour?"),
			"id" => $shortname. "_" . $short_prefix . "body_font_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "#1a1a1a",
			"type" => "text"),


    array (	"name" => __("Choose your prefered links colour?"),
            "id" => $shortname . "_" . $short_prefix . "content_link_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your prefered links <strong>hover</strong> colour?"),
			"id" => $shortname. "_" . $short_prefix . "content_link_hover_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),

    array (	"name" => __("Choose your prefered <strong>post title</strong> links colour?"),
			"id" => $shortname. "_" . $short_prefix . "post_title_link_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),

    array (	"name" => __("Choose your prefered navigation and footer colour?"),
            "id" => $shortname . "_" . $short_prefix . "nv_footer_colour",
            "inblock" => "nav",
            "custom" => "colourpicker",
            "box" => "3",
            "std" => "",
			"type" => "text"),



    array(	"name" => __("Do you want to used the custom image header *default: enable"),
            "id" => $shortname . "_" . $short_prefix . "header_on",
            "box" => "3",
            "inblock" => "custom-header",
			"type" => "select",
            "std" => "enable",
			"options" => array("enable","disable")),


    array (	"name" => __("Insert your desired custom header height?"),
            "id" => $shortname . "_" . $short_prefix . "image_height",
            "inblock" => "custom-header",
            "box" => "3",
            "std" => "150",
			"type" => "text"),








    ////feed one//////

    array(	"name" => __("<strong>Insert the first feed name here</strong>"),
			"id" => $shortname . "_" . $short_prefix . "rss_one",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the first feed url you'd like to display here: (etc: http://sitename/feed or feedburner feed url)"),
            "id" => $shortname . "_" . $short_prefix . "rss_one_url",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
            "id" => $shortname . "_" . $short_prefix . "rss_one_sum",
            "box" => "3",
            "inblock" => "rssnetwork",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


    array(	"name" => __("How many word count to pull from your feeds?"),
            "id" => $shortname . "_" . $short_prefix . "rss_one_wordcount",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "150",
			"type" => "text"),



   ////feed two//////

    array(	"name" => __("<br /><strong>Insert the second feed name here</strong>"),
			"id" => $shortname . "_" . $short_prefix . "rss_two",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the second feed url you'd like to display here: (etc: http://sitename/feed or feedburner feed url)"),
            "id" => $shortname . "_" . $short_prefix . "rss_two_url",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
            "id" => $shortname . "_" . $short_prefix . "rss_two_sum",
            "box" => "3",
            "inblock" => "rssnetwork",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


    array(	"name" => __("How many word count to pull from your feeds?"),
            "id" => $shortname . "_" . $short_prefix . "rss_two_wordcount",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "150",
			"type" => "text"),



////feed third//////

    array(	"name" => __("<br /><strong>Insert your third feed name here</strong>"),
			"id" => $shortname . "_" . $short_prefix . "rss_three",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the third feed url you'd like to display here: (etc: http://sitename/feed or feedburner feed url)"),
            "id" => $shortname . "_" . $short_prefix . "rss_three_url",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
            "id" => $shortname . "_" . $short_prefix . "rss_three_sum",
            "box" => "3",
            "inblock" => "rssnetwork",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


    array(	"name" => __("How many word count to pull from your feeds?"),
            "id" => $shortname . "_" . $short_prefix . "rss_three_wordcount",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "150",
			"type" => "text"),


////feed fourth//////

    array(	"name" => __("<br /><strong>Insert your fourth feed name here</strong>"),
			"id" => $shortname . "_" . $short_prefix . "rss_four",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the fourth feed url you'd like to display here: (etc: http://sitename/feed or feedburner feed url)"),
            "id" => $shortname . "_" . $short_prefix . "rss_four_url",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
            "id" => $shortname . "_" . $short_prefix . "rss_four_sum",
            "box" => "3",
            "inblock" => "rssnetwork",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


    array(	"name" => __("How many word count to pull from your feeds?"),
            "id" => $shortname . "_" . $short_prefix . "rss_four_wordcount",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "150",
			"type" => "text"),

////feed fifth//////

    array(	"name" => __("<br /><strong>Insert your fifth feed name here</strong>"),
			"id" => $shortname . "_" . $short_prefix . "rss_five",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the fifth feed url you'd like to display here: (etc: http://sitename/feed or feedburner feed url)"),
            "id" => $shortname . "_" . $short_prefix . "rss_five_url",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
            "id" => $shortname . "_" . $short_prefix . "rss_five_sum",
            "box" => "3",
            "inblock" => "rssnetwork",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


    array(	"name" => __("How many word count to pull from your feeds?"),
            "id" => $shortname . "_" . $short_prefix . "rss_five_wordcount",
            "inblock" => "rssnetwork",
            "box" => "3",
            "std" => "150",
			"type" => "text")


/////////////end rss//////////////////



);










function mytheme_wpmu_tri_admin() {
global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>



<div id="wrap-admin">

<div id="content-admin">

<div id="top-content-admin">
<h4><?php _e('Theme Options'); ?></h4>
<p><?php _e('You can configure your own blog style and content below'); ?></p>
</div>


<div class="admin-content">
<form method="post" id="option-mz-form">


<?php
if ($values['box'] = '1') { ?>

<div class="admin-layer">

<div class="option-box" id="main-setting">
<h4><?php _e('Blog Main Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "main-layout") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "main-layout") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "main-layout") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "main-layout") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>


<div class="option-box">
<h4><?php _e('Blog Layout Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "layout") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "layout") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "layout") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "layout") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>



</div>
<?php } ?>




<?php

if ($values['box'] = '2') { ?>

<div class="admin-layer">

<div class="option-box">
<h4><?php _e('Blog Fonts Settings'); ?></h4>
<?php foreach ($options as $value) {
if (($value['inblock'] == "font") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "font") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "font") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "font") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "font") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>



<div class="option-box">
<h4><?php _e('Navigation &amp; Footer Colour Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "nav") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>



<div class="option-box">
<h4><?php _e('Custom Image Header Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "custom-header") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "custom-header") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "custom-header") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>


</div><!-- admin-layer -->
<?php } ?>





<?php

if ($values['box'] = '3') { ?>

<div class="admin-layer">

<div class="option-box">
<h4><?php _e('RSS Networks Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "rssnetwork") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "rssnetwork") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "rssnetwork") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "rssnetwork") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>
</div>

</div><!-- admin-layer -->

<?php } ?>






<p class="submit">
<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Changes')); ?>" />
<input type="hidden" name="action" value="save" />
</p>
</form>


<form method="post">
<p class="submit">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Changes')); ?>" />
<input type="hidden" name="action" value="reset" /></p>
</form>

</div>
</div>
</div>

<?php }

function mytheme_add_wpmu_tri_admin() {
global $themename, $shortname, $options;
if ( $_GET['page'] == "functions.php" ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=functions.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=functions.php&reset=true");
die;
} else if( 'upload' == $_REQUEST['action'] ) {
header("Location: themes.php?page=functions.php&upload=ok");
die;
}
}
add_theme_page($themename. ' Options', 'Theme Options', 'edit_themes', 'functions.php', 'mytheme_wpmu_tri_admin');
}




////////////////////////////////////////////////////////////////////////////////



function _g($str)
{
return __($str, 'option-page');
}


////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function mytheme_wp_wpmu_tri_head() { ?>

<link href="<?php bloginfo('template_directory'); ?>/admin/wpmu-admin.css" rel="stylesheet" type="text/css" />

<?php if(($_GET["page"] == "functions.php") || ($_GET["page"] == "site-intro.php")) { ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jscolor.js"></script>


<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/var.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/quicktags.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/simple-code.php"></script>


<?php } ?>

<?php }


add_action('admin_head', 'mytheme_wp_wpmu_tri_head');
add_action('admin_menu', 'mytheme_add_wpmu_tri_admin');


////////////////////////////////////////////////////////////////////////////////
// add theme custom crop
////////////////////////////////////////////////////////////////////////////////



// function to generate random strings
function RandomString($length=3)
{
$randstr='';
srand((double)microtime()*1000000);
$chars = array ('1','2','3','4','5','6','7','8','9','0');
for ($rand = 0; $rand <= $length; $rand++)
{
$random = rand(0, count($chars) -1);
$randstr .= $chars[$random];
}
return $randstr;
}



////////////////////////////////////////////////////////////////////////////////
// CUSTOM IMAGE HEADER  - IF ON WILL BE SHOWN ELSE WILL HIDE
////////////////////////////////////////////////////////////////////////////////




$header_enable = get_option('tn_wpmu_tri_header_on');

if(($header_enable == 'enable') || ($header_enable == '')) {

$custom_height = get_option('tn_wpmu_tri_image_height');
if($custom_height==''){$custom_height='150';}else{$custom_height = get_option('tn_wpmu_tri_image_height'); }


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 960); //width is fixed
define('HEADER_IMAGE_HEIGHT', $custom_height);
define( 'NO_HEADER_TEXT', true );


function wpmu_tri_admin_header_style() { ?>
<style type="text/css">
#headimg {
	background: url(<?php header_image() ?>) no-repeat;
}
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php }

if (function_exists('add_custom_image_header')) {
add_custom_image_header('', 'wpmu_tri_admin_header_style');
}

} else {

}












$options1 = array (

    array (	"name" => __("Your homepage intro title"),
			"id" => $shortname . "_" . $short_prefix . "intro_header",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Your homepage box left text"),
			"id" => $shortname . "_" . $short_prefix . "intro_header_text",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),

);


function wpmu_tri_intro() { ?>
<?php
global $themename, $shortname, $options1;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>


<div id="wrap-admin">
<div id="content-admin">

<div id="top-content-admin">
<h5><?php _e('Site Intro Settings'); ?></h5>
<p><?php _e("If you wish to display an introduction to your site on the frontpage please enter it below - this is confined to 'homepage' mode"); ?></p>
</div>


<form method="post" id="option-mz-form">


<?php

if ($values['box'] = '1') { ?>


<div class="option-box">
<h4><?php _e('Homepage Intro Settings'); ?></h4>
<?php foreach ($options1 as $value) {

if (($value['inblock'] == "home-box1") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box1") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box1") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option1) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option1) { echo ' selected="selected"'; } elseif ($option1 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option1; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "home-box1") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p>
<script type='text/javascript'>
quicktagsL10n = {
quickLinks: "(Quick Links)",
wordLookup: "Enter a word to look up:",
dictionaryLookup: "Dictionary lookup",
lookup: "lookup",
closeAllOpenTags: "Close all open tags",
closeTags: "close tags",
enterURL: "Enter the URL",
enterImageURL: "Enter the URL of the image",
enterImageDescription: "Enter a description of the image"
}
</script>
<script type="text/javascript">edToolbar()</script>
</p>
<p><textarea class="ops-area" id="ops-com" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p><script type="text/javascript">var edCanvas = document.getElementById('ops-com');</script> </div>
<?php }
}
?>
</div>


<?php } ?>

<p class="submit">
<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Text')); ?>" />
<input type="hidden" name="action" value="save" />
</p>
</form>


<form method="post">
<p class="submit">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Text')); ?>" />
<input type="hidden" name="action" value="reset" /></p>
</form>

</div>
</div>



<?php }

function wpmu_tri_add_intro() {
global $themename, $shortname, $options1;
if ( $_GET['page'] == "site-intro.php" ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options1 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options1 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=site-intro.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options1 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=site-intro.php&reset=true");
die;
}
}
add_theme_page(_g ('Site Intro'),  _g ('Site Intro'),  'edit_themes', 'site-intro.php', 'wpmu_tri_intro');
}













///////////////////////////////////////////////////////
/////////////////CUSTOM GALLERY PAGE///////////////////
///////////////////////////////////////////////////////


function wpmu_tri_gallery() { ?>
<?php
///check if use mu or normal wp/////////////
if (function_exists("is_site_admin")) {
$mu = true;
} else {
$mu = false;
}
////////////////////////////////////////////


/////////////////////////////////////////////////////You can alter these options///////////////////////////

if($mu == "true") {
global $blog_id;
$tpl_url = get_bloginfo('wpurl');
$ptp = get_template();
define( 'ABSPATH', dirname(__FILE__) . '/' );
$upload_dir = "files"; 				// The directory for the images to be saved in
$gallery_folder = "gallery";

$upload_path = ABSPATH . 'wp-content/blogs.dir/' . $blog_id . "/" . $gallery_folder . "/";
$upload_path_blogid = ABSPATH . 'wp-content/blogs.dir/' . $blog_id;
$upload_path_check = ABSPATH . 'wp-content/blogs.dir/' . $blog_id . "/" . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/blogs.dir/" . $blog_id . "/" . $gallery_folder;

} else {

$tpl_url = get_bloginfo('wpurl');
$ptp = get_template();
define( 'ABSPATH', dirname(__FILE__) . '/' );
$upload_dir = "files"; 				// The directory for the images to be saved in
$gallery_folder = "gallery";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/";
$upload_path_check = ABSPATH . 'wp-content/' . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/" . $gallery_folder;
}

//Create the upload directory with the right permissions if it doesn't exist
if($mu == "true") {
if(!is_dir($upload_path_blogid)){
    mkdir($upload_path_blogid, 0777);
	chmod($upload_path_blogid, 0777);
}
}
if(!is_dir($upload_path_check)){
    mkdir($upload_path_check, 0777);
	chmod($upload_path_check, 0777);
}

?>
<div id="wrap-admin">
<div id="content-admin">

<div id="top-content-admin">
<h5><?php _e('Custom Images Gallery'); ?></h5>
<p><?php _e('If you wish to use an background image or pattern, please upload it using the tools below.'); ?></p>
</div>



<?php
if (isset($_POST["upload"])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_name = str_replace(" ","-",$userfile_name);

$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_size = $_FILES['image']['size'];

$large_image_location = $upload_path . $userfile_name;

if(ereg('[^a-zA-Z0-9 ._.-]', $userfile_name)){
echo "<p class=\"uperror\">The image name contain invalid character, rename it and try upload it again</p>";
} else {
move_uploaded_file($userfile_tmp, $large_image_location);
chmod($large_image_location, 0777);
}

}
?>


<?php

echo "<form id=\"gala\" name=\"gallery\" action=\"\" method=\"post\"> ";

if ($handle = opendir("$upload_path")) {
$pattern="(\.jpg$)|(\.png$)|(\.jpeg$)|(\.gif$)|(\.bmp$)"; //valid image extensions
// List all the files


while (false !== ($file = readdir($handle))) {
$i == $i++ ;
if(eregi($pattern, $file)){ ?>

<?php
if (isset($_POST['delete_' . $i])){
unlink($upload_path . $file);
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=gallery.php';";
print "</script>";
}
?>
<div class="gallery-box">
<img src="<?php echo "$upload_url/$file"; ?>" class="img-left" width="48" height="48" alt="Thumbnail" />
<p><input type="text" class="ops-text" name="images-gala" value="<?php echo "$upload_url/$file"; ?>"/></p>
<p><input type="submit" class="submit-button" name="delete_<?php echo "$i"; ?>" value="delete" /></p>
</div>
<?php }
}
closedir($handle);
}
echo "</form> ";
?>

<h5><?php _e('Upload Images And Patterns'); ?></h5>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
Photo <input type="file" name="image" size="30" /> <input type="submit" name="upload" value="Upload" />
</form>





<?php

echo "<form method=\"post\"> ";

if ($handle = opendir("$upload_path")) {
$pattern="(\.jpg$)|(\.png$)|(\.jpeg$)|(\.gif$)|(\.bmp$)"; //valid image extensions
// List all the files


while (false !== ($file = readdir($handle))) {
if(eregi($pattern, $file)){ ?>

<?php
if (isset($_POST['deleteall'])){
unlink($upload_path . $file);
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=gallery.php';";
print "</script>";
}
?>
<?php }
}
closedir($handle);
}
echo "<p><input type=\"submit\" class=\"saveme\" name=\"deleteall\" value=\"Delete All Gallery Images\" /></p>";
echo "</form> ";
?>




</div>
</div>

<?php }

function wpmu_tri_add_gallery() {
add_theme_page(_g ('Gallery'),  _g ('Gallery'),  'edit_themes', 'gallery.php', 'wpmu_tri_gallery');
}

add_action('admin_menu', 'wpmu_tri_add_intro');
add_action('admin_menu', 'wpmu_tri_add_gallery');


?>