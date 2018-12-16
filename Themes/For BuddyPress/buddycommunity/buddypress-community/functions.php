<?php


/* Register the widget columns */
register_sidebars( 1,
	array( 
		'name' => 'left-column',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);

register_sidebars( 1,
	array( 
		'name' => 'center-column',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);

register_sidebars( 1,
	array( 
		'name' => 'right-column',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);
register_sidebars( 1,
	array(
		'name' => 'blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	)
);


/* Catch specific URLs */

if( function_exists('bp_exists') ) {
$bp_existed = 'true';
} else {
$bp_existed = 'false';
}

if($bp_existed == 'true') {

function bp_show_home_blog() {
	global $bp, $query_string;

	if ( $bp->current_component == BP_HOME_BLOG_SLUG ) {
		$pos = strpos( $query_string, 'pagename=' . BP_HOME_BLOG_SLUG );

		if ( $pos !== false )
			$query_string = preg_replace( '/pagename=' . BP_HOME_BLOG_SLUG . '/', '', $query_string );

		query_posts($query_string);
		
		if ( is_single() )
			bp_core_load_template( 'single', true );
		else if ( is_category() || is_search() || is_day() || is_month() || is_year() )
			bp_core_load_template( 'archive', true );
		else
			bp_core_load_template( 'index', true );
	}
}
add_action( 'wp', 'bp_show_home_blog', 2 );

function bp_show_register_page() {
	global $bp, $current_blog;
	
	require ( BP_PLUGIN_DIR . '/bp-core/bp-core-signup.php' );
	
	if ( $bp->current_component == BP_REGISTER_SLUG && $bp->current_action == '' ) {
		bp_core_signup_set_headers();
		bp_core_load_template( 'register', true );
	}
}
add_action( 'wp', 'bp_show_register_page', 2 );

function bp_show_activation_page() {
	global $bp, $current_blog;

	require ( BP_PLUGIN_DIR . '/bp-core/bp-core-activation.php' );
	
	if ( $bp->current_component == BP_ACTIVATION_SLUG && $bp->current_action == '' ) {
		bp_core_activation_set_headers();
		bp_core_load_template( 'activate', true );
	}
}
add_action( 'wp', 'bp_show_activation_page', 2 );

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
    $comment_chk_variable = get_comments('post_id=' . $id);
	$comments_by_type = &separate_comments($comment_chk_variable);
	return count($comments_by_type['comment']);
}


///////////////////////////////////////////////////////////////////////////////


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
				echo '<a href="'.get_pagenum_link().'">&laquo; First</a> ... ';
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
				echo ' ... <a href="'.get_pagenum_link($max_page).'">Last &raquo;</a>';
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
// excerpt features
////////////////////////////////////////////////////////////////////////////////

function the_excerpt_feature($excerpt_length=120, $allowedtags='', $filter_type='none', $use_more_link=true, $more_link_text="<br /><br />...Click here to read more &raquo;", $force_more_link=true, $fakeit=1, $fix_tags=true) {
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

$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );

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


////////////////////custom most commented post widget//////////////////////////////

function custom_most_comment($args) {

extract($args);

$settings = get_option("widget_custom_most_comment");

$mc_name = $settings['name'];
//check if xustom name exited///
if($mc_name == '') {
$mc_name = __('Most Commented');
} else {
$mc_name = $mc_name;
}


$mc_number = $settings['number'];
?>

<?php
global $wpdb, $post;
$mostcommenteds = $wpdb->get_results("SELECT  $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT $mc_number");

echo $before_widget;

echo $before_title . $mc_name . $after_title;

echo "<ul> ";

foreach ($mostcommenteds as $post) {
$post_title = htmlspecialchars(stripslashes($post->post_title));
$comment_total = (int) $post->comment_total;
echo "<li><a href=\"".get_permalink()."\">$post_title&nbsp;<strong>($comment_total)</strong></a></li>";
}

echo "</ul> ";

echo $after_widget;
?>

<?php }

function custom_most_comment_admin() {

$settings = get_option("widget_custom_most_comment");

// check if anything's been sent
if (isset($_POST['update_custom_most_comment'])) {
$settings['name'] = strip_tags(stripslashes($_POST['custom_most_comment_id']));
$settings['number'] = strip_tags(stripslashes($_POST['custom_most_comment_number']));
update_option("widget_custom_most_comment",$settings);
}
echo '<p>
<label for="custom_most_comment_id">Name for most comment(optional):
<input id="custom_most_comment_id" name="custom_most_comment_id" type="text" class="widefat" value="'.$settings['name'].'" /></label></p>';
echo '<p>
<label for="custom_most_comment_number">Total to show:
<input id="custom_most_comment_number" name="custom_most_comment_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
echo '<input type="hidden" id="update_custom_most_comment" name="update_custom_most_comment" value="1" />';
}

register_sidebar_widget('Most Comment', 'custom_most_comment');
register_widget_control('Most Comment', 'custom_most_comment_admin', 400, 200);






////////////////////recent commented post with avatar//////////////////////////////

function custom_recent_comment($args) {

extract($args);

$settings = get_option("widget_custom_recent_comment");

$rc_name = $settings['name'];
//check if xustom name exited///
if($rc_name == '') {
$rc_name = __('Recent Comments');
} else {
$rc_name = $rc_name;
}

$rc_avatar = $settings['avatar_on'];

$rc_number = $settings['number'];
?>

<?php

global $wpdb;

$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,50) AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE comment_approved = '1' AND comment_type = '' AND
post_password = ''
ORDER BY comment_date_gmt DESC LIMIT $rc_number";

$comments = $wpdb->get_results($sql);
$output = $pre_HTML;

echo $before_widget;

echo $before_title . $rc_name . $after_title;

echo "<ul> ";

foreach ($comments as $comment) {

$email = $comment->comment_author_email;
$grav_name = $comment->comment_author_name;
$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($email). "&amp;size=16";

?>
<li>
<?php if($rc_avatar == 'yes') { ?>
<img class="alignleft" src="<?php echo $grav_url; ?>" alt="<?php echo $grav_name ?>" />
<?php } ?>
<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="on <?php echo $comment->post_title; ?>">
<?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?>...
</a>
</li>
<?php
}

echo "</ul> ";

echo $after_widget;


?>
<?php }

function custom_recent_comment_admin() {

$settings = get_option("widget_custom_recent_comment");

// check if anything's been sent
if (isset($_POST['update_custom_recent_comment'])) {
$settings['name'] = strip_tags(stripslashes($_POST['custom_recent_comment_name']));

$settings['avatar_on'] = strip_tags(stripslashes($_POST['custom_recent_comment_avatar_status']));


$settings['number'] = strip_tags(stripslashes($_POST['custom_recent_comment_number']));
update_option("widget_custom_recent_comment",$settings);
}

echo '<p>
<label for="custom_recent_comment_id">Name for recent comment(optional):
<input id="custom_recent_comment_name" name="custom_recent_comment_name" type="text" class="widefat" value="'.$settings['name'].'" /></label></p>';

echo '<p>
<label for="custom_recent_comment_avatar_status">Enable avatar?:
<select id="custom_recent_comment_avatar_status" name="custom_recent_comment_avatar_status">
<option name="'.$settings['avatar_on'].'" value="yes">yes</option>
<option name="'.$settings['avatar_on'].'" value="no">no</option>
</select>
</p>';

echo '<p>
<label for="custom_recent_comment_number">Total to show:
<input id="custom_recent_comment_number" name="custom_recent_comment_number" type="text" class="widefat" value="'.$settings['number'].'" /></label></p>';
echo '<input type="hidden" id="update_custom_recent_comment" name="update_custom_recent_comment" value="1" />';
}

register_sidebar_widget('Comment It Avatar', 'custom_recent_comment');
register_widget_control('Comment It Avatar', 'custom_recent_comment_admin', 400, 200);











///////////////////////////////////////////////////////////////
// multiple option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

function _g($str)
{
return __($str, 'option-page');
}


///////////////////////////////////////////////////////////////
// theme option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

$themename = "BuddyPress Community";
$shortname = "tn";
$shortprefix = "_buddycom_";

$options = array (


array(
"name" => __("Choose your body font"),
"id" => $shortname . $shortprefix . "body_font",
"type" => "select",
"inblock" => "typo",
"std" => "Lucida Grande, Lucida Sans, sans-serif",
			"options" => array(
            "Lucida Grande, Lucida Sans, sans-serif",
            "Arial, sans-serif",
            "Verdana, sans-serif",
            "Trebuchet MS, sans-serif",
            "Fertigo, serif",
            "Georgia, serif",
            "Cambria, Georgia, serif",
            "Tahoma, sans-serif",
            "Helvetica, Arial, sans-serif",
            "Corpid, Corpid Bold, sans-serif",
            "Century Gothic, Century, sans-serif",
            "Palatino Linotype, Times New Roman, serif",
            "Garamond, Georgia, serif",
            "Caslon Book BE, Caslon, Arial Narrow",
            "Arial Rounded Bold, Arial",
            "Arial Narrow, Arial",
            "Myriad Pro, Calibri, sans-serif",
            "Candara, Calibri, Lucida Grande",
            "Univers LT 55, Univers LT Std 55, Univers, sans-serif",
            "Ronda, Ronda Light, Century Gothic",
            "Century, Times New Roman, serif",
            "Courier New, Courier, monospace",
            "Walbaum LT Roman, Walbaum, Times New Roman",
            "Dax, Dax-Regular, Dax-Bold, Trebuchet MS",
            "VAG Round, Arial Rounded Bold, sans-serif",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande",
            "Qlassik Medium, Qlassik Bold, Lucida Grande",
            "TradeGothic LT, Lucida Sans, Lucida Grande",
            "Cocon, Cocon-Light, sans-serif",
            "Frutiger, Frutiger LT Std 55 Roman, tahoma",
            "Futura LT Book, Century Gothic, sans-serif",
            "Steinem, Cocon, Cambria",
            "Delicious, Trebuchet MS, sans-serif",
            "Helvetica 65 Medium, Helvetica Neue, Helvetica Bold, sans-serif",
            "Helvetica Neue, Helvetica, Helvetica-Normal, sans-serif",
            "Helvetica Rounded, Arial Rounded Bold, VAGRounded BT, sans-serif",
            "Decker, sans-serif",
            "Mrs Eaves OT, Georgia, Cambria, serif",
            "Anivers, Lucida Sans, Lucida Grande",
            "Geneva, sans-serif",
            "Trajan, Trajan Pro, serif",
            "FagoCo, Calibri, Lucida Grande",
            "Meta, Meta Bold , Meta Medium, sans-serif",
            "Chocolate, Segoe UI, Seips",
            "Ronda, Ronda Light, Century Gothic",
            "DIN, DINPro-Regular, DINPro-Medium, sans-serif",
            "Gotham, Georgia, serif"
            )
            ),

array(
"name" => __("Choose your headline font"),
"id" => $shortname . $shortprefix . "headline_font",
"type" => "select",
"inblock" => "typo",
"std" => "Lucida Grande, Lucida Sans, sans-serif",
			"options" => array(
            "Lucida Grande, Lucida Sans, sans-serif",
            "Arial, sans-serif",
            "Verdana, sans-serif",
            "Trebuchet MS, sans-serif",
            "Fertigo, serif",
            "Georgia, serif",
            "Cambria, Georgia, serif",
            "Tahoma, sans-serif",
            "Helvetica, Arial, sans-serif",
            "Corpid, Corpid Bold, sans-serif",
            "Century Gothic, Century, sans-serif",
            "Palatino Linotype, Times New Roman, serif",
            "Garamond, Georgia, serif",
            "Caslon Book BE, Caslon, Arial Narrow",
            "Arial Rounded Bold, Arial",
            "Arial Narrow, Arial",
            "Myriad Pro, Calibri, sans-serif",
            "Candara, Calibri, Lucida Grande",
            "Univers LT 55, Univers LT Std 55, Univers, sans-serif",
            "Ronda, Ronda Light, Century Gothic",
            "Century, Times New Roman, serif",
            "Courier New, Courier, monospace",
            "Walbaum LT Roman, Walbaum, Times New Roman",
            "Dax, Dax-Regular, Dax-Bold, Trebuchet MS",
            "VAG Round, Arial Rounded Bold, sans-serif",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande",
            "Qlassik Medium, Qlassik Bold, Lucida Grande",
            "TradeGothic LT, Lucida Sans, Lucida Grande",
            "Cocon, Cocon-Light, sans-serif",
            "Frutiger, Frutiger LT Std 55 Roman, tahoma",
            "Futura LT Book, Century Gothic, sans-serif",
            "Steinem, Cocon, Cambria",
            "Delicious, Trebuchet MS, sans-serif",
            "Helvetica 65 Medium, Helvetica Neue, Helvetica Bold, sans-serif",
            "Helvetica Neue, Helvetica, Helvetica-Normal, sans-serif",
            "Helvetica Rounded, Arial Rounded Bold, VAGRounded BT, sans-serif",
            "Decker, sans-serif",
            "Mrs Eaves OT, Georgia, Cambria, serif",
            "Anivers, Lucida Sans, Lucida Grande",
            "Geneva, sans-serif",
            "Trajan, Trajan Pro, serif",
            "FagoCo, Calibri, Lucida Grande",
            "Meta, Meta Bold , Meta Medium, sans-serif",
            "Chocolate, Segoe UI, Seips",
            "Ronda, Ronda Light, Century Gothic",
            "DIN, DINPro-Regular, DINPro-Medium, sans-serif",
            "Gotham, Georgia, serif"
            )
            ),

array(
"name" => __("Choose your font size"),
"box"=> "1",
"inblock" => "typo",
"id" => $shortname . $shortprefix . "font_size",
"type" => "select",
"std" => "normal",
"options" => array("normal", "medium", "bigger", "largest")),





//background setting

array (
"name" => __("Choose your background color"),
"id" => $shortname . $shortprefix . "bg_color",
"inblock" => "bg",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Insert your <strong>background image</strong> full url here<br /><em>*you can upload your image in <a href='media-new.php'>media panel</a> and copy paste the url here</em>"),
"inblock" => "bg",
"id" => $shortname . $shortprefix . "bg_image",
"std" => "",
"type" => "text"),


array(
"name" => __("Background Images Repeat"),
"id" => $shortname . $shortprefix . "bg_image_repeat",
"inblock" => "bg",
"type" => "select",
"std" => "no-repeat",
"options" => array("no-repeat", "repeat", "repeat-x", "repeat-y")),

array(
"name" => __("Background Images Attachment"),
"id" => $shortname . $shortprefix . "bg_image_attachment",
"inblock" => "bg",
"type" => "select",
"std" => "fixed",
"options" => array("fixed", "scroll")),

array(
"name" => __("Background Images Horizontal Position"),
"id" => $shortname . $shortprefix . "bg_image_horizontal",
"inblock" => "bg",
"type" => "select",
"std" => "left",
"options" => array("left", "center", "right")),


array(
"name" => __("Background Images Vertical Position"),
"id" => $shortname . $shortprefix . "bg_image_vertical",
"inblock" => "bg",
"type" => "select",
"std" => "top",
"options" => array("top", "center", "bottom")),

array(
"name" => __("Insert your <strong>logo</strong> full url here<br /><em>*you can upload your logo in <a href='media-new.php'>media panel</a> and copy paste the url here</em>"),
"id" => $shortname . $shortprefix . "header_logo",
"inblock" => "bg",
"type" => "text",
"std" => "",
),


//signup

array(
"name" => __("Edit your welcome message text here&nbsp;&nbsp;&nbsp;<em>*html allowed</em>"),
"id" => $shortname . $shortprefix . "call_signup_text",
"inblock" => "signup",
"type" => "textarea",
"std" => "<h2>Welcome to the BuddyPress Community Theme</h2><span>Simply change this text in your theme options</span>",
),

array(
"name" => __("Edit your welcome message button text here"),
"id" => $shortname . $shortprefix . "call_signup_button_text",
"inblock" => "signup",
"type" => "text",
"std" => "Signup Here",
),



//css



array (
"name" => __("Global links color"),
"id" => $shortname . $shortprefix . "global_links",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),

//header

array (
"name" => __("Header area color"),
"id" => $shortname . $shortprefix . "header_color",
"inblock" => "header",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Header bottom border color"),
"id" => $shortname . $shortprefix . "header_bottom_border_color",
"inblock" => "header",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Header text color"),
"id" => $shortname . $shortprefix . "header_text_color",
"inblock" => "header",
"std" => "",
"type" => "colorpicker"),





//searchbox


array (
"name" => __("SearchBox area color"),
"id" => $shortname . $shortprefix . "searchbox_color",
"inblock" => "searchbox",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("SearchBox bottom border color"),
"id" => $shortname . $shortprefix . "searchbox_bottom_border_color",
"inblock" => "searchbox",
"std" => "",
"type" => "colorpicker"),




// footer


array (
"name" => __("Footer area color"),
"id" => $shortname . $shortprefix . "footer_color",
"inblock" => "footer",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Footer bottom border color"),
"id" => $shortname . $shortprefix . "footer_bottom_border_color",
"inblock" => "footer",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Footer text color"),
"id" => $shortname . $shortprefix . "footer_text_color",
"inblock" => "footer",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Footer text link color"),
"id" => $shortname . $shortprefix . "footer_text_link_color",
"inblock" => "footer",
"std" => "",
"type" => "colorpicker"),

// sidebar


array (
"name" => __("Sidebar box color"),
"id" => $shortname . $shortprefix . "sidebar_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar border color"),
"id" => $shortname . $shortprefix . "sidebar_border_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Sidebar text color"),
"id" => $shortname . $shortprefix . "sidebar_text_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar H2 header text color"),
"id" => $shortname . $shortprefix . "sidebar_header_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar text links color"),
"id" => $shortname . $shortprefix . "sidebar_text_links_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),


// member userbar and optionbar

array (
"name" => __("Member theme <strong>userbar and optionsbar</strong> bg color"),
"id" => $shortname . $shortprefix . "sidebar_memberbar_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Member theme <strong>userbar and optionsbar</strong> border color"),
"id" => $shortname . $shortprefix . "sidebar_memberbar_border_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Member theme <strong>userbar LI link color</strong>"),
"id" => $shortname . $shortprefix . "sidebar_userbar_li_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Member theme <strong>userbar CURRENT LI bg color</strong>"),
"id" => $shortname . $shortprefix . "sidebar_userbar_current_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Member theme <strong>userbar CURRENT LI link color</strong>"),
"id" => $shortname . $shortprefix . "sidebar_userbar_link_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),


// buddypress meta

array (
"name" => __("Sidebar <strong>meta block</strong> color"),
"id" => $shortname . $shortprefix . "sidebar_meta_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Post <strong>meta block</strong> color"),
"id" => $shortname . $shortprefix . "post_meta_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Member theme info group h4 header background color"),
"id" => $shortname . $shortprefix . "member_header_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Member theme info group h4 header bottom border color"),
"id" => $shortname . $shortprefix . "member_header_bottom_line_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Member theme info group h4 header text color"),
"id" => $shortname . $shortprefix . "member_header_text_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Member theme info group h4 header link color"),
"id" => $shortname . $shortprefix . "member_header_links_color",
"inblock" => "buddy",
"std" => "",
"type" => "colorpicker"),

);



function buddycom_admin_panel() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<h4><?php echo "$themename"; ?> <?php _e('Theme Options'); ?></h4>
<form action="" method="post">

<div id="buddynote">
<strong><?php _e('Optional Features:'); ?></strong><br />
<?php _e('If you want to customize the theme options you MUST have default.css selected in the BuddyPress Community Preset Styles section.<br />
However, <em>typography</em> and <em>background</em> settings will work with any preset style'); ?>
</div>

<div class="option-block">

<div class="get-option">
<h2><?php _e("Typography Font Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "typo") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "typo") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "typo") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "typo") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>




<div class="get-option">
<h2><?php _e("Background Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "bg") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "bg") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "bg") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "bg") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>



<div class="get-option">
<h2><?php _e("Welcome Message Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "signup") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "signup") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "signup") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "signup") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>




<div class="get-option">
<h2><?php _e("CSS Links Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "css") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>

</div>


<!--block 2-->



<div class="option-block">

<div class="get-option">
<h2><?php _e("Header CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "header") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>




<div class="get-option">
<h2><?php _e("Search Box CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "searchbox") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "searchbox") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "searchbox") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "searchbox") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>




<div class="get-option">
<h2><?php _e("Footer CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "footer") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "footer") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "footer") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "footer") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>


<div class="get-option">
<h2><?php _e("Sidebar CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "sidebar") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "sidebar") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "sidebar") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "sidebar") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>

</div>


<!--block 3 check if buddypress existed-->
<?php
if( function_exists('bp_exists') ) {
$bp_existed = 'true';
} else {
$bp_existed = 'false';
}
if($bp_existed == 'true') { ?>
<div class="option-block">

<div class="get-option">
<h2><?php _e("Member Theme Userbar And Optionsbar Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "msidebar") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "msidebar") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "msidebar") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "msidebar") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>




<div class="get-option">
<h2><?php _e("Member Theme CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "buddy") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "buddy") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "buddy") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "buddy") && ($value['type'] == "select") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>

<?php } } ?>

</div>
</div>


</div>
<?php } ?>



<p id="top-margin" class="save-p">
<input name="save" type="submit" class="sbutton" value="<?php echo attribute_escape(__('Save Options')); ?>" />
<input type="hidden" name="action" value="save" />
</p>
</form>



<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="<?php echo attribute_escape(__('Reset Options')); ?>" />
<input type="hidden" name="action" value="reset" />
</p>

</form>




</div><!-- admin-option -->

<?php }




function buddycom_admin_register() {
global $themename, $shortname, $options;
if ( $_GET['page'] == 'functions.php' ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
header("Location: themes.php?page=functions.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=functions.php&reset=true");
die;
}
}

add_theme_page(_g ($themename . __(' Theme Options')),  _g (__('Theme Options')),  'edit_themes', 'functions.php', 'buddycom_admin_panel');

}

add_action('admin_menu', 'buddycom_admin_register');







///////////////////////////////////////////////////////////////
// Ready made buddycommunity style
////////////////////////////////////////////////////////////////


$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
	if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
		while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
			if(stristr($alt_stylesheet_file, ".css") !== false) {
				$alt_stylesheets[] = $alt_stylesheet_file;
			}
		}
	}
}
$category_bulk_list = array_unshift($alt_stylesheets, "default.css");

$options2 = array (

array(
"name" => __("Choose Your BuddyPress Community Preset Style:"),
"id" => $shortname. $shortprefix . "custom_style",
"std" => "default.css",
"type" => "radio",
"options" => $alt_stylesheets)
);


function buddycom_ready_style_admin_panel() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options2;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<h4><?php echo "$themename"; ?> <?php _e('Preset Style'); ?></h4>
<form action="" method="post">

<div class="get-listings">
<h2><?php _e("Style Select:") ?></h2>
<div class="option-save">
<ul>
<?php foreach ($options2 as $value) { ?>

<?php foreach ($value['options'] as $option2) {

$screenshot_img = substr($option2,0,-4);

$radio_setting = get_settings($value['id']);
if($radio_setting != '') {
if (get_settings($value['id']) == $option2) { $checked = "checked=\"checked\""; } else { $checked = ""; }
} else {
if(get_settings($value['id']) == $value['std'] ){ $checked = "checked=\"checked\""; } else { $checked = ""; }
} ?>

<li>
<div class="theme-img"><img src="<?php bloginfo('stylesheet_directory');?>/styles/images/<?php echo $screenshot_img . '.png'; ?>" alt="<?php echo $screenshot_img; ?>" /></div>
<input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $option2; ?>" <?php echo $checked; ?> /><?php echo $option2; ?>
</li>

<?php } ?>

<?php } ?>

</ul>
</div>
</div>

<p id="top-margin" class="save-p">
<input name="save" type="submit" class="sbutton" value="<?php echo attribute_escape(__('Save Options')); ?>" />
<input type="hidden" name="action" value="save" />
</p>
</form>



<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="<?php echo attribute_escape(__('Reset Options')); ?>" />
<input type="hidden" name="action" value="reset" />
</p>

</form>




</div><!-- admin-option -->

<?php }


function buddycom_ready_style_admin_register() {
global $themename, $shortname, $options2;
if ( $_GET['page'] == 'buddycommunity-themes.php' ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options2 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
header("Location: themes.php?page=buddycommunity-themes.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=buddycommunity-themes.php&reset=true");
die;
}
}

add_theme_page(_g (__('BuddyPress Community Preset Style')),  _g (__('Preset Style')),  'edit_themes', 'buddycommunity-themes.php', 'buddycom_ready_style_admin_panel');

}

add_action('admin_menu', 'buddycom_ready_style_admin_register');





///////////////////////////////////////////////////////////////
// admin header/////////////////////////////////////////
////////////////////////////////////////////////////////////////


function buddycom_admin_head() { ?>

<link href="<?php bloginfo('template_directory'); ?>/admin/custom-admin.css" rel="stylesheet" type="text/css" />

<?php if($_GET["page"] == "functions.php") { ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jscolor.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>

<?php } ?>

<?php }

add_action('admin_head', 'buddycom_admin_head');





?>