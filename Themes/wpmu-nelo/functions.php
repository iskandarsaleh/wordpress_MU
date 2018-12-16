<?php

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
// Short title
////////////////////////////////////////////////////////////////////////////////

function the_short_title(){

echo substr_replace(the_title('','',false),'...','40');

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
register_sidebar(array('name'=>'Sidebar',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Top Right',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Box Left',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Box Center',
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Home Box Right',
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









$themename = "WPMU-NELO ";
$shortname = "tn";

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
			"id" => $shortname."_wpmu_layout_mode",
            "inblock" => "main-layout",
            "box" => "1",
			"type" => "select",
            "std" => "custom homepage",
            "options" => array("custom homepage","blog homepage")),


    array (	"name" => __("Main Intro Box Setting? *only required if you are using the custom homepage"),
			"id" => $shortname."_wpmu_latest_post",
            "inblock" => "main-layout",
            "box" => "1",
			"type" => "select",
            "std" => "custom post",
            "options" => array("custom post", "recent post", "custom post with recent post")),


    array (	"name" => __("Choose your background colour?"),
			"id" => $shortname."_wpmu_bg_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your content background colour?"),
			"id" => $shortname."_wpmu_container_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),

     array (	"name" => __("Choose your body <strong>line</strong> colour? *grid lines and separate lines"),
			"id" => $shortname."_wpmu_content_line_colour",
            "inblock" => "layout",
            "custom" => "colourpicker",
            "box" => "1",
            "std" => "",
			"type" => "text"),



    array (	"name" => __("If you want to use an image as the background please upload the image here:<br /><a target=\"_blank\" href=\"$tpl_url/wp-admin/themes.php?page=gallery.php\">upload image</a>"),
			"id" => $shortname."_wpmu_bg_image",
            "inblock" => "layout",
            "box" => "1",
            "std" => "",
			"type" => "text"),



array(
"name" => __("Background Images Repeat"),
"id" => $shortname . "_wpmu_bg_image_repeat",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "no-repeat",
"options" => array("no-repeat","repeat","repeat-x","repeat-y")),


array(
"name" => __("Background Images Attachment"),
"id" => $shortname . "_wpmu_bg_image_attachment",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "fixed",
"options" => array("fixed", "scroll")),


array(
"name" => __("Background Images Horizontal Position"),
"id" => $shortname . "_wpmu_bg_image_horizontal",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "left",
"options" => array("left", "center", "right")),


array(
"name" => __("Background Images Vertical Position"),
"id" => $shortname . "_wpmu_bg_image_vertical",
"inblock" => "layout",
"box" => "1",
"type" => "select",
"std" => "top",
"options" => array("top", "center", "bottom")),


array(	"name" => __("Choose your global body font?"),
			"id" => $shortname."_wpmu_body_font",
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
			"id" => $shortname."_wpmu_headline_font",
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
			"id" => $shortname."_wpmu_font_size",
            "box" => "2",
            "inblock" => "font",
			"type" => "select",
            "std" => "normal",
			"options" => array("normal","small", "bigger", "largest")),


    array (	"name" => __("Change your global body font colour?"),
			"id" => $shortname."_wpmu_body_font_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "#1a1a1a",
			"type" => "text"),


    array (	"name" => __("Choose your prefered links colour?"),
			"id" => $shortname."_wpmu_content_link_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),

    array (	"name" => __("Choose your prefered links <strong>hover</strong> colour?"),
			"id" => $shortname."_wpmu_content_link_hover_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your prefered <strong>post title</strong> links colour?"),
			"id" => $shortname."_wpmu_post_title_link_colour",
            "inblock" => "font",
            "custom" => "colourpicker",
            "box" => "2",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Choose your prefered navigation and footer colour?"),
			"id" => $shortname."_wpmu_nv_footer_colour",
            "inblock" => "nav",
            "custom" => "colourpicker",
            "box" => "3",
            "std" => "",
			"type" => "text"),



    array(	"name" => __("Do you want to used the custom image header *default: disabled"),
			"id" => $shortname."_wpmu_header_on",
            "box" => "3",
            "inblock" => "custom-header",
			"type" => "select",
            "std" => "disable",
			"options" => array("disable","enable")),


    array (	"name" => __("Insert your desired custom header height?"),
			"id" => $shortname."_wpmu_image_height",
            "inblock" => "custom-header",
            "box" => "3",
            "std" => "150",
			"type" => "text"),


    array (	"name" => __("Show a login panel and logged in users profile?"),
			"id" => $shortname."_wpmu_show_profile",
            "inblock" => "profile",
            "box" => "2",
			"type" => "select",
            "std" => "no",
            "options" => array("no","yes")),

    array(	"name" => __("Do you want to used the social bar in posts?"),
			"id" => $shortname."_wpmu_social_status",
            "inblock" => "profile",
            "box" => "2",
			"type" => "select",
            "std" => "disable",
			"options" => array("disable", "enable")),


    array(	"name" => __("Enter some information about yourself or the site (only displayed if the login panel is enabled)"),
			"id" => $shortname."_wpmu_profile_text",
            "inblock" => "profile",
            "box" => "2",
            "std" => "",
			"type" => "textarea")

);










function mytheme_wpmu_admin() {
global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>



<div id="wrap-admin">
<div id="content-admin">

<div id="top-content-admin">
<h4><?php _e('Theme Options'); ?></h4>
<br /><br />
<p><?php _e('Configure the style, function and design of your site below:'); ?></p>
<br /><br />
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
<h4><?php _e('Profile Settings'); ?></h4>
<?php foreach ($options as $value) {

if (($value['inblock'] == "profile") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>
<div class="pwrap">
<?php $i == $i++ ; ?>
<p><?php echo $value['name']; ?>:</p>
<p><input class="ops-colour color {pickerPosition:'top',styleElement:'pick <?php echo $i; ?>',required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
<br />
<input class="pick" id="pick <?php echo $i; ?>">
</p></div>

<?php } elseif (($value['inblock'] == "profile") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "profile") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "profile") && ($value['type'] == "textarea")) { ?>

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






<p class="submit">
<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Options')); ?>" />
<input type="hidden" name="action" value="save" />
</p>
</form>

<form method="post">
<p class="submit">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Options')); ?>" />
<input type="hidden" name="action" value="reset" /></p>
</form>

</div>
</div>
</div>

<?php }

function mytheme_add_wpmu_admin() {
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
add_theme_page($themename. 'Options', 'Theme Options', 'edit_themes', 'functions.php', 'mytheme_wpmu_admin');
}




////////////////////////////////////////////////////////////////////////////////



function _g($str)
{
return __($str, 'option-page');
}


////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function mytheme_wp_wpmu_head() { ?>

<link href="<?php bloginfo('template_directory'); ?>/admin/wpmu-admin.css" rel="stylesheet" type="text/css" />

<?php if(($_GET["page"] == "custom-homepage.php") || ($_GET["page"] == "functions.php")) { ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jscolor.js"></script>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.imgareaselect-0.3.min.js"></script>


<?php } ?>

<?php }



add_action('admin_head', 'mytheme_wp_wpmu_head');
add_action('admin_menu', 'mytheme_add_wpmu_admin');


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

$header_enable = get_option('tn_wpmu_header_on');

if(($header_enable == 'disable') || ($header_enable == '')) { } else {

$custom_height = get_option('tn_wpmu_image_height');
if($custom_height==''){$custom_height='150';}else{$custom_height = get_option('tn_wpmu_image_height'); }


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 900); //width is fixed
define('HEADER_IMAGE_HEIGHT', $custom_height);
define( 'NO_HEADER_TEXT', true );


function wpmu_admin_header_style() { ?>
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
add_custom_image_header('', 'wpmu_admin_header_style');
}
}

























////////////////////////////////////////////////////////////////////////////////
//  IMAGE CROP
////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////
//  TOP HEADER
////////////////////////////////////////////////////////////////////////////////

$options1 = array (


    array (	"name" => __("Top header image direct link to? *http://www.sitename.com"),
			"id" => $shortname."_wpmu_top_header_imgurl",
            "inblock" => "home-top-header",
            "box" => "1",
            "std" => "",
			"type" => "text")

);

$options2 = array (


    array (	"name" => __("Your homepage intro header title"),
			"id" => $shortname."_wpmu_intro_header",
            "inblock" => "home-intro",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("Your homepage intro text"),
			"id" => $shortname."_wpmu_intro_text",
            "inblock" => "home-intro",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),


    array (	"name" => __("Intro header image direct link to? *http://www.sitename.com"),
			"id" => $shortname."_wpmu_intro_header_imgurl",
            "inblock" => "home-intro",
            "box" => "1",
            "std" => "",
			"type" => "text")

);

$options3 = array (

    array (	"name" => __("Your homepage box left header title"),
			"id" => $shortname."_wpmu_box1_header",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array (	"name" => __("Your homepage box left text"),
			"id" => $shortname."_wpmu_box1_text",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),


    array (	"name" => __("Choose your featured category in box left?"),
			"id" => $shortname."_wpmu_box1_cat",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "Choose a category",
			"type" => "select",
            "options" => $wp_getcat),

    array (	"name" => __("Box left image direct link to? *http://www.sitename.com"),
			"id" => $shortname."_wpmu_box1_imgurl",
            "inblock" => "home-box1",
            "box" => "1",
            "std" => "",
			"type" => "text")

);

$options4 = array (

    array ( "name" => __("Your homepage box center header title"),
			"id" => $shortname."_wpmu_box2_header",
            "inblock" => "home-box2",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("Your homepage box center text"),
			"id" => $shortname."_wpmu_box2_text",
            "inblock" => "home-box2",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),


    array (	"name" => __("Choose your featured category in box center?"),
			"id" => $shortname."_wpmu_box2_cat",
            "inblock" => "home-box2",
            "box" => "1",
            "std" => "Choose a category",
			"type" => "select",
            "options" => $wp_getcat),


    array (	"name" => __("Box center image direct link to? *http://www.sitename.com"),
			"id" => $shortname."_wpmu_box2_imgurl",
            "inblock" => "home-box2",
            "box" => "1",
            "std" => "",
			"type" => "text")

);


$options5 = array (

    array (	"name" => __("Your homepage box right header title"),
			"id" => $shortname."_wpmu_box3_header",
            "inblock" => "home-box3",
            "box" => "1",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("Your homepage box right text"),
			"id" => $shortname."_wpmu_box3_text",
            "inblock" => "home-box3",
            "box" => "1",
            "std" => "",
			"type" => "textarea"),



    array (	"name" => __("Choose your featured category in box right?"),
			"id" => $shortname."_wpmu_box3_cat",
            "inblock" => "home-box3",
            "box" => "1",
            "std" => "Choose a category",
			"type" => "select",
            "options" => $wp_getcat),


    array (	"name" => __("Box right image direct link to? *http://www.sitename.com"),
			"id" => $shortname."_wpmu_box3_imgurl",
            "inblock" => "home-box3",
            "box" => "1",
            "std" => "",
			"type" => "text")

);

function sz_custom_page() { ?>

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
$gallery_folder = "thumb";

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
$gallery_folder = "thumb";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/";
$upload_path_check = ABSPATH . 'wp-content/' . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/" . $gallery_folder;
}




//////////////////////////////////////////////////////////////////You can alter these options///////////////


//Image functions
//You do not need to alter these functions
function resizeImage($image,$width,$height,$scale) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	$source = imagecreatefromjpeg($image);
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$thumb_image_name,90);
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}




$large_image_name = "top_header.jpg"; 		// New name of the large image
$thumb_image_name = "top_header_crop.jpg"; 	// New name of the thumbnail image
$max_file = "1000000"; 						// Approx 1MB
$max_width = "800";							// Max width allowed for the large image
$thumb_width = "300";						// Width of thumbnail image
$thumb_height = "100";                      // Height of thumbnail image


//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

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

//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		if (($file_ext!="jpg") && ($file_ext!="jpeg")){
			$error= "ONLY jpeg images extension are accepted for upload";
		}
        if($userfile_size > $max_file){
            $error= "ONLY jpeg images under 1MB are accepted for upload";
        }
	} else {
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail

print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
echo "<h4 id=\"loading-bar\">Your Cropped Image Currently Loading</h4>";
print "<meta http-equiv=\"refresh\" content=\"2;url=$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">";
exit();

}
?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>




<script type="text/javascript">
function preview(img, selection) {
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
});

function selectionStart(img, selection) { width:300;height:100 }

$(window).load(function () {
	$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 320, y2: 120, aspectRatio: '3:1', onSelectChange: preview });
});

</script>
<?php } ?>

<?php global $themename, $shortname;
if ( $_REQUEST['resetall'] )
echo '<div id="message" class="updated fade"><p><strong>All images deleted and settings reset</strong></p></div>';
?>

<div id="wrap-admin">

<div id="content-admin">

<?php global $themename, $shortname, $options1;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<div class="option-box">

<div id="top-content-admin">
<h5>Blog Top Header Image Upload And Crop</h5>
</div>


<?php
if (isset($_POST["delete_thumbnail"])){
unlink("$upload_path/$large_image_name");
unlink("$upload_path/$thumb_image_name");
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload image</a>";
exit();
}
?>



<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> Successfully upload and crop thumbnail, if you want to delete or replace the image, just press delete and reupload and recrop the new image</p>";
    echo "<img src=\"$upload_url/$thumb_image_name\" class=\"timg\"/>";
      echo "  <form name=\"thumbnail\" action=\"\" method=\"post\">
    <input type=\"submit\" name=\"delete_thumbnail\" class=\"submit-button\" value=\"Delete This Image\" />
    </form>";

} else {



		if(strlen($large_photo_exists)>0){?>



		<h4>Crop And Save Your Thumbnail</h4>
		<div>
			<img src="<?php echo "$upload_url/$large_image_name"; ?>" style="clear: both; margin-bottom: 10px;" id="thumbnail" alt="Create Thumbnail" />

			<br style="clear:both;"/>
			<form name="thumbnail" action="" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>

	<?php 	} ?>

    <?php if(strlen($large_photo_exists)==0){ ?>
	<h4><strong>Upload Photo</strong></h4>
	<form name="photo" class="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<input type="file" name="image" size="50" class="upz" />
    <p><input type="submit" name="upload" value="Upload" /></p>
    <p class="onlyjpg">* only jpg image files are allowed</p>
	</form>

<?php } ?>
<?php } ?>


<form method="post" id="option-mz-form">




<h4>Homepage Top Header Settings</h4>
<?php foreach ($options1 as $value) {

if (($value['inblock'] == "home-top-header") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-top-header") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-top-header") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option1) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option1) { echo ' selected="selected"'; } elseif ($option1 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option1; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "home-intro") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php } } ?>



<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Links')); ?>" />
<input type="hidden" name="action" value="save" />

</form>



<form method="post">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Links')); ?>" />
<input type="hidden" name="action" value="reset" />
</form>


</div>

<?php





$large_image_name = "intro.jpg"; 		// New name of the large image
$thumb_image_name = "intro_crop.jpg"; 	// New name of the thumbnail image
$max_file = "1000000"; 						// Approx 1MB
$max_width = "800";							// Max width allowed for the large image
$thumb_width = "350";						// Width of thumbnail image
$thumb_height = "250";                      // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;


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


//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload2"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		if (($file_ext!="jpg") && ($file_ext!="jpeg")){
			$error= "ONLY jpeg images extension are accepted for upload";
		}
        if($userfile_size > $max_file){
            $error= "ONLY jpeg images under 1MB are accepted for upload";
        }
	} else {
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST["upload_thumbnail2"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail

print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
echo "<h4 id=\"loading-bar\">Your Cropped Image Currently Loading</h4>";
print "<meta http-equiv=\"refresh\" content=\"2;url=$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">";
exit();

}
?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>




<script type="text/javascript">
function preview(img, selection) {
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail2 + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
});

function selectionStart(img, selection) { width:350;height:250 }

$(window).load(function () {
	$('#thumbnail2').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 370, y2: 270, aspectRatio: '7:5', onSelectChange: preview });
});

</script>
<?php } ?>



<?php global $themename, $shortname, $options2;
if ( $_REQUEST['saved2'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset2'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<div class="option-box">

<div id="top-content-admin">
<h5>Blog Intro Header Image Upload And Crop</h5>
</div>


<?php
if (isset($_POST["delete_thumbnail2"])){
unlink("$upload_path/$large_image_name");
unlink("$upload_path/$thumb_image_name");
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$tpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new</a>";
exit();
}
?>

<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> Successfully upload and crop thumbnail, if you want to delete or replace the image, just press delete and reupload and recrop the new image</p>";
    echo "<img src=\"$upload_url/$thumb_image_name\" class=\"timg\"/>";
      echo "  <form name=\"thumbnail\" action=\"\" method=\"post\">
    <input type=\"submit\" name=\"delete_thumbnail2\" class=\"submit-button\" value=\"Delete This Image\" />
    </form>";

} else {



		if(strlen($large_photo_exists)>0){?>



		<h4>Crop And Save Your Thumbnail</h4>
		<div>
			<img src="<?php echo "$upload_url/$large_image_name"; ?>" style="clear: both; margin-bottom: 10px;" id="thumbnail2" alt="Create Thumbnail" />

			<br style="clear:both;"/>
			<form name="thumbnail" action="" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail2" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<?php 	} ?>

    <?php if(strlen($large_photo_exists)==0){ ?>
	<h4>Upload Photo</h4>
	<form name="photo" class="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<input type="file" name="image" class="upz" size="50" />
    <p><input type="submit" name="upload2" value="Upload" /></p>
    <p class="onlyjpg">* only jpg image files are allowed</p>
	</form>

<?php } ?>
<?php } ?>




<form method="post" id="option-mz-form">


<h4>Homepage Intro Settings</h4>
<?php foreach ($options2 as $value) {

if (($value['inblock'] == "home-intro") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-intro") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-intro") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option2) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option2) { echo ' selected="selected"'; } elseif ($option2 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option2; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "home-intro") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<p>
<textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p>
</div>
<?php }
}
?>


<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Text')); ?>" />
<input type="hidden" name="action" value="save2" />

</form>


<form method="post">

<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Text')); ?>" />
<input type="hidden" name="action" value="reset2" />

</form>

</div>


<?php






$large_image_name = "box_cat_left.jpg"; 		// New name of the large image
$thumb_image_name = "box_cat_left_crop.jpg"; 	// New name of the thumbnail image
$max_file = "1000000"; 						// Approx 1MB
$max_width = "800";							// Max width allowed for the large image
$thumb_width = "290";						// Width of thumbnail image
$thumb_height = "150";                     // Height of thumbnail image


//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;


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

//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload3"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		if (($file_ext!="jpg") && ($file_ext!="jpeg")){
			$error= "ONLY jpeg images extension are accepted for upload";
		}
        if($userfile_size > $max_file){
            $error= "ONLY jpeg images under 1MB are accepted for upload";
        }
	} else {
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST["upload_thumbnail3"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail

print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
echo "<h4 id=\"loading-bar\">Your Cropped Image Currently Loading</h4>";
print "<meta http-equiv=\"refresh\" content=\"2;url=$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">";
exit();

}

?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection) {
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail3 + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
});

function selectionStart(img, selection) { width:290;height:150 }

$(window).load(function () {
	$('#thumbnail3').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 310, y2: 170, aspectRatio: '29:15', onSelectChange: preview });
});

</script>
<?php }?>



<?php global $themename, $shortname, $options3;
if ( $_REQUEST['saved3'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset3'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<div class="option-box">

<div id="top-content-admin">
<h5>Blog Box Left Image Upload And Crop</h5>
</div>

<?php
if (isset($_POST["delete_thumbnail3"])){
unlink("$upload_path/$large_image_name");
unlink("$upload_path/$thumb_image_name");
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$tpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload image</a>";
exit();
}
?>

<?php
//Display error message if there are any
if(strlen($error)>0){
	echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> Successfully upload and crop thumbnail, if you want to delete or replace the image, just press delete and reupload and recrop the new image</p>";
    echo "<img src=\"$upload_url/$thumb_image_name\" class=\"timg\"/>";
      echo "  <form name=\"thumbnail\" action=\"\" method=\"post\">
    <input type=\"submit\" name=\"delete_thumbnail3\" class=\"submit-button\" value=\"Delete This Image\" />
    </form>";

} else {



		if(strlen($large_photo_exists)>0){?>



		<h4>Crop And Save Your Thumbnail</h4>
		<div>
			<img src="<?php echo "$upload_url/$large_image_name"; ?>" style="clear: both; margin-bottom: 10px;" id="thumbnail3" alt="Create Thumbnail" />

			<br style="clear:both;"/>
			<form name="thumbnail" action="" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail3" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<hr />
	<?php 	} ?>

    <?php if(strlen($large_photo_exists)==0){ ?>
	<h4>Upload Photo</h4>
	<form name="photo" class="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<input type="file" name="image" class="upz" size="50" />
    <p><input type="submit" name="upload3" value="Upload" /></p>
    <p class="onlyjpg">* only jpg image files are allowed</p>
	</form>

    <?php } ?>






<?php } ?>




<form method="post" id="option-mz-form">


<h4>Homepage Box Left Settings</h4>
<?php foreach ($options3 as $value) {

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
<?php foreach ($value['options'] as $option3) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option3) { echo ' selected="selected"'; } elseif ($option3 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option3; ?></option>
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
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }
}
?>


<input name="save" type="submit" class="saveme" value="Save This Text" />
<input type="hidden" name="action" value="save3" />
</form>


<form method="post">
<input name="reset" type="submit" class="saveme" value="Reset This Text" />
<input type="hidden" name="action" value="reset3" />
</form>

</div>

<?php






$large_image_name = "box_cat_center.jpg"; 		// New name of the large image
$thumb_image_name = "box_cat_center_crop.jpg"; 	// New name of the thumbnail image
$max_file = "1000000"; 						// Approx 1MB
$max_width = "800";							// Max width allowed for the large image
$thumb_width = "290";						// Width of thumbnail image
$thumb_height = "150";                    // Height of thumbnail image


//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;


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


//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload4"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		if (($file_ext!="jpg") && ($file_ext!="jpeg")){
			$error= "ONLY jpeg images extension are accepted for upload";
		}
        if($userfile_size > $max_file){
            $error= "ONLY jpeg images under 1MB are accepted for upload";
        }
	} else {
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST["upload_thumbnail4"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail

print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
echo "<h4 id=\"loading-bar\">Your Cropped Image Currently Loading</h4>";
print "<meta http-equiv=\"refresh\" content=\"2;url=$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">";
exit();

}

?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection) {
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail4 + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
});

function selectionStart(img, selection) { width:290;height:150 }

$(window).load(function () {
	$('#thumbnail4').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 310, y2: 170, aspectRatio: '29:15', onSelectChange: preview });
});

</script>
<?php }?>

<?php global $themename, $shortname, $options4;
if ( $_REQUEST['saved4'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset4'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<div class="option-box">

<div id="top-content-admin">
<h5>Blog Box Center Image Upload And Crop</h5>
</div>

<?php
if (isset($_POST["delete_thumbnail4"])){
unlink("$upload_path/$large_image_name");
unlink("$upload_path/$thumb_image_name");
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$tpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload image</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
	echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> Successfully upload and crop thumbnail, if you want to delete or replace the image, just press delete and reupload and recrop the new image</p>";
    echo "<img src=\"$upload_url/$thumb_image_name\" class=\"timg\"/>";
      echo "  <form name=\"thumbnail\" action=\"\" method=\"post\">
    <input type=\"submit\" name=\"delete_thumbnail4\" class=\"submit-button\" value=\"Delete This Image\" />
    </form>";

} else {



		if(strlen($large_photo_exists)>0){?>



		<h4>Crop And Save Your Thumbnail</h4>
		<div>
			<img src="<?php echo "$upload_url/$large_image_name"; ?>" style="clear: both; margin-bottom: 10px;" id="thumbnail4" alt="Create Thumbnail" />

			<br style="clear:both;"/>
			<form name="thumbnail" action="" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail4" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<hr />
	<?php 	} ?>

    <?php if(strlen($large_photo_exists)==0){ ?>
	<h4>Upload Photo</h4>
	<form name="photo" class="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<input type="file" name="image" class="upz" size="50" />
    <p><input type="submit" name="upload4" value="Upload" /></p>
    <p class="onlyjpg">* only jpg image files are allowed</p>
	</form>

<?php } ?>
<?php } ?>


<form method="post" id="option-mz-form">

<h4>Homepage Box Center Settings</h4>
<?php foreach ($options4 as $value) {

if (($value['inblock'] == "home-box2") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box2") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box2") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option4) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option4) { echo ' selected="selected"'; } elseif ($option3 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option4; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "home-box2") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php
}
}
?>

<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Text')); ?>" />
<input type="hidden" name="action" value="save4" />
</form>


<form method="post">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Text')); ?>" />
<input type="hidden" name="action" value="reset4" />
</form>

</div>

<?php




$large_image_name = "box_cat_right.jpg"; 		// New name of the large image
$thumb_image_name = "box_cat_right_crop.jpg"; 	// New name of the thumbnail image
$max_file = "1000000"; 						// Approx 1MB
$max_width = "800";							// Max width allowed for the large image
$thumb_width = "290";						// Width of thumbnail image
$thumb_height = "150";                    // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

///////////////////////Image directory//////////////////
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


//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
	if(file_exists($thumb_image_location)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload5"])) {
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);

	//Only process if the file is a JPG and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		if (($file_ext!="jpg") && ($file_ext!="jpeg")){
			$error= "ONLY jpeg images extension are accepted for upload";
		}
        if($userfile_size > $max_file){
            $error= "ONLY jpeg images under 1MB are accepted for upload";
        }
	} else {
		$error= "Select a jpeg image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){

		if (isset($_FILES['image']['name'])){

			move_uploaded_file($userfile_tmp, $large_image_location);
			chmod($large_image_location, 0777);

			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width){
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
		exit();
	}
}

if (isset($_POST["upload_thumbnail5"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail


print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
echo "<h4 id=\"loading-bar\">Your Cropped Image Currently Loading</h4>";
print "<meta http-equiv=\"refresh\" content=\"2;url=$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">";
exit();

}

?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection) {
	var scaleX = <?php echo $thumb_width;?> / selection.width;
	var scaleY = <?php echo $thumb_height;?> / selection.height;

	$('#thumbnail5 + div > img').css({
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px',
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}

$(document).ready(function () {
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
});

function selectionStart(img, selection) { width:290;height:150 }

$(window).load(function () {
	$('#thumbnail5').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 310, y2: 170, aspectRatio: '29:15', onSelectChange: preview });
});

</script>
<?php }?>

<?php global $themename, $shortname, $options5;
if ( $_REQUEST['saved5'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset5'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>


<div class="option-box">

<div id="top-content-admin">
<h5>Blog Box Right Image Upload And Crop</h5>
</div>

<?php
if (isset($_POST["delete_thumbnail5"])){
unlink("$upload_path/$large_image_name");
unlink("$upload_path/$thumb_image_name");
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$tpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload image</a>";
exit();
}
?>

<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo "<p><strong>NOTE:</strong> Successfully upload and crop thumbnail, if you want to delete or replace the image, just press delete and reupload and recrop the new image</p>";
    echo "<img src=\"$upload_url/$thumb_image_name\" class=\"timg\"/>";
      echo "  <form name=\"thumbnail\" action=\"\" method=\"post\">
    <input type=\"submit\" name=\"delete_thumbnail5\" class=\"submit-button\" value=\"Delete This Image\" />
    </form>";

} else {



		if(strlen($large_photo_exists)>0){?>



		<h4>Crop And Save Your Thumbnail</h4>
		<div>
			<img src="<?php echo "$upload_url/$large_image_name"; ?>" style="clear: both; margin-bottom: 10px;" id="thumbnail5" alt="Create Thumbnail" />

			<br style="clear:both;"/>
			<form name="thumbnail" action="" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail5" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<hr />
	<?php 	} ?>

    <?php if(strlen($large_photo_exists)==0){ ?>
	<h4>Upload Photo</h4>
	<form name="photo" class="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
	<input type="file" name="image" class="upz" size="50" />
    <p><input type="submit" name="upload5" value="Upload" /></p>
    <p class="onlyjpg">* only jpg image files are allowed</p>
	</form>

<?php } ?>
<?php } ?>


<form method="post" id="option-mz-form">

<h4>Homepage Box Right Settings</h4>
<?php foreach ($options5 as $value) {

if (($value['inblock'] == "home-box3") && ($value['type'] == "text") && ($value['custom'] == "colourpicker")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-colour" id="vtrColorPicker" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box3") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-text" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "home-box3") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option5) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option5) { echo ' selected="selected"'; } elseif ($option3 == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option5; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "home-box3") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea class="ops-area" name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php } } ?>


<input name="save" type="submit" class="saveme" value="<?php echo attribute_escape(__('Save Text')); ?>" />
<input type="hidden" name="action" value="save5" />
</form>


<form method="post">
<input name="reset" type="submit" class="saveme" value="<?php echo attribute_escape(__('Reset Text')); ?>" />
<input type="hidden" name="action" value="reset5" />
</form>




</div>

<p align="center" id="resetall">
<form method="post">
<input name="reset" type="submit" class="saveme" value="<?php _e('Delete all images and reset all text options'); ?>" />
<input type="hidden" name="action" value="resetall" />
</form>
</p>

</div>



<?php }



function sz_add_custom_page() {

global $themename, $shortname, $options1, $options2, $options3, $options4, $options5;


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options1 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options1 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options1 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset=true");
die;
}
}

if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save2' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options2 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved=true");
die;
} else if( 'reset2' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save3' == $_REQUEST['action'] ) {
foreach ($options3 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options3 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved=true");
die;
} else if( 'reset3' == $_REQUEST['action'] ) {
foreach ($options3 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset=true");
die;
}
}

if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save4' == $_REQUEST['action'] ) {
foreach ($options4 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options4 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved=true");
die;
} else if( 'reset4' == $_REQUEST['action'] ) {
foreach ($options4 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset=true");
die;
}
}

if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save5' == $_REQUEST['action'] ) {
foreach ($options5 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options5 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved=true");
die;
} else if( 'reset5' == $_REQUEST['action'] ) {
foreach ($options5 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset=true");
die;
}
}

if ( $_GET['page'] == "custom-homepage.php" ) {
if( 'resetall' == $_REQUEST['action'] ) {
foreach ($options1 as $value){ delete_option( $value['id'] ); }
foreach ($options2 as $value){ delete_option( $value['id'] ); }
foreach ($options3 as $value){ delete_option( $value['id'] ); }
foreach ($options4 as $value){ delete_option( $value['id'] ); }
foreach ($options5 as $value){ delete_option( $value['id'] ); }

///check if use mu or normal wp/////////////
if (function_exists("is_site_admin")) {
$mu = true;
} else {
$mu = false;
}
/////////////////////////////////////////////////////You can alter these options///////////////////////////

if($mu == "true") {

global $blog_id;
$tpl_url = get_bloginfo('wpurl');
$ptp = get_template();
define( 'ABSPATH', dirname(__FILE__) . '/' );
$upload_dir = "files"; 				// The directory for the images to be saved in
$gallery_folder = "thumb";
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
$gallery_folder = "thumb";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/";
$upload_path_check = ABSPATH . 'wp-content/' . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/" . $gallery_folder;

}

if(file_exists($upload_path . 'top_header.jpg')) {
unlink("$upload_path_check/top_header.jpg");
unlink("$upload_path_check/top_header_crop.jpg");
}

if(file_exists($upload_path . 'intro.jpg')) {
unlink("$upload_path_check/intro.jpg");
unlink("$upload_path_check/intro_crop.jpg");
}

if(file_exists($upload_path . 'box_cat_left.jpg')) {
unlink("$upload_path_check/box_cat_left.jpg");
unlink("$upload_path_check/box_cat_left_crop.jpg");
}

if(file_exists($upload_path . 'box_cat_center.jpg')) {
unlink("$upload_path_check/box_cat_center.jpg");
unlink("$upload_path_check/box_cat_center_crop.jpg");
}

if(file_exists($upload_path . 'box_cat_right.jpg')) {
unlink("$upload_path_check/box_cat_right.jpg");
unlink("$upload_path_check/box_cat_right_crop.jpg");
}
header("Location: themes.php?page=custom-homepage.php&resetall=true");
die;
}
}

add_theme_page(_g ('Custom Homepage'),  _g ('Custom Homepage'),  'edit_themes', 'custom-homepage.php', 'sz_custom_page');
}
add_action('admin_menu', 'sz_add_custom_page');


































































function sz_gala_page(){ ?>
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
echo "<br /><br /><br /><p><input type=\"submit\" class=\"saveme\" name=\"deleteall\" value=\"Delete All Gallery Images\" /></p>";
echo "</form> ";
?>




</div>
</div>

<?php }

function sz_add_gala_page() {
add_theme_page(_g ('Gallery'),  _g ('Gallery'),  'edit_themes', 'gallery.php', 'sz_gala_page');
}
add_action('admin_menu', 'sz_add_gala_page');


?>