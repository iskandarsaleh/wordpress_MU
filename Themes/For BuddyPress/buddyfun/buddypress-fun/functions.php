<?php

$includes_path = TEMPLATEPATH . '/includes/';
require_once ($includes_path . 'custom-functions.php');


////////////////////////////////////////////////////////////////////////////////
/// buddypress code
////////////////////////////////////////////////////////////////////////////////


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
// one-category
////////////////////////////////////////////////////////////////////////////////

function custom_the_category() {
$parentscategory ="";
foreach((get_the_category()) as $category) {
if ($category->category_parent == 0) {

$parentscategory .= ' <a href="' . get_category_link($category->cat_ID) . '" title="' . $category->name . '">' . $category->name . '</a>, ';

}
}
echo substr($parentscategory,0,-2);
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
// excerpt features main
////////////////////////////////////////////////////////////////////////////////

function the_excerpt_feature_main($excerpt_length=150, $allowedtags='', $filter_type='none', $use_more_link=true, $more_link_text="...more&raquo;", $force_more_link=false, $fakeit=1, $fix_tags=true) {

if (preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) {
$filter_type = 'the_' . $filter_type;
}
$text = apply_filters($filter_type, get_the_excerpt_feature_main($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit));
$text = ($fix_tags) ? balanceTags($text) : $text;
echo $text;
}

function get_the_excerpt_feature_main($excerpt_length, $allowedtags, $use_more_link, $more_link_text, $force_more_link, $fakeit) {
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


////////////////////////////////////////////////////////////////////////////////
// short code for img features
////////////////////////////////////////////////////////////////////////////////

function dez_get_images($the_post_id = '') {
global $wpdb;
$detect_post_id = $the_post_id;
$get_post_attachment = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$detect_post_id' AND post_type = 'attachment' ORDER BY menu_order ASC LIMIT 1");
// If images exist for this page
if($get_post_attachment != '') {

foreach($get_post_attachment as $attach) {
$attach_img = $attach->guid;
$sImgString = '<a href="' . get_permalink() . '">' . '<img src="' . $attach_img . '"alt="Thumbnail Image" title="Thumbnail Image" />' . '</a>';
echo "$sImgString";
}

} else {
}
}



///////////////////////////////////////////////////////////////
// multiple option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

function _g($str)
{
return __($str, 'option-page');
}


////////////////////////////////////////////////////////////////////////////////
/// Register the widget columns
////////////////////////////////////////////////////////////////////////////////

if ( function_exists('register_sidebar') ) {

register_sidebar(
array(
'name' => __('left-column'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2 class="widgettitle">',
'after_title' => '</h2>'
)
);

register_sidebar(
array(
'name' => __('center-column'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2 class="widgettitle">',
'after_title' => '</h2>'
)
);

register_sidebar(
array(
'name' => __('right-column'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2 class="widgettitle">',
'after_title' => '</h2>'
)
);

register_sidebar(
array(
'name' => __('blog-sidebar'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h2 class="widgettitle">',
'after_title' => '</h2>'
)
);

}


///////////////////////////////////////////////////////////////
// theme option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

$themename = "BuddyPress Fun";
$shortname = "tn";
$shortprefix = "_buddyfun_";

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


array (
"name" => __("Choose your global body text color"),
"id" => $shortname . $shortprefix . "body_text_color",
"inblock" => "typo",
"std" => "",
"type" => "colorpicker"),


//background setting



array (
"name" => __("Choose your background color"),
"id" => $shortname . $shortprefix . "bg_color",
"inblock" => "bg",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Choose your content body background color"),
"id" => $shortname . $shortprefix . "content_bg_color",
"inblock" => "bg",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Choose your content gridline color"),
"id" => $shortname . $shortprefix . "content_line_bg_color",
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
"name" => __("Check this box to disable the welcome message"),
"id" => $shortname . $shortprefix . "call_signup_on",
"box"=> "2",
"inblock" => "signup",
"type" => "checkbox",
"std" => "disable"),

array(
"name" => __("Edit your welcome message text here&nbsp;&nbsp;&nbsp;<em>*html allowed</em>"),
"id" => $shortname . $shortprefix . "call_signup_text",
"inblock" => "signup",
"type" => "textarea",
"std" => "Welcome to your BuddyPress Fun theme!<br />
<small>Change or remove the text here using the theme options</small>",
),

array(
"name" => __("Edit your welcome message button text here"),
"id" => $shortname . $shortprefix . "call_signup_button_text",
"inblock" => "signup",
"type" => "text",
"std" => "Join Here",
),



//css



array (
"name" => __("Global links color"),
"id" => $shortname . $shortprefix . "global_links",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Global links <strong>hover</strong> color"),
"id" => $shortname . $shortprefix . "global_hover_links",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Post title links color"),
"id" => $shortname . $shortprefix . "post_title_links",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Post title links <strong>hover</strong> color"),
"id" => $shortname . $shortprefix . "post_title_hover links",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Global blockquote and meta item background color"),
"id" => $shortname . $shortprefix . "global_blockquote",
"inblock" => "css",
"std" => "",
"type" => "colorpicker"),


array(
"name" => __("Do you want to enable gloss effect to sidebar header and top navigation?"),
"id" => $shortname . $shortprefix . "header_gloss_on",
"inblock" => "header",
"type" => "select",
"std" => "disable",
"options" => array("disable","enable")),


//header

array(
"name" => __("Do you want to enable custom image header?"),
"id" => $shortname . $shortprefix . "header_on",
"inblock" => "header",
"type" => "select",
"std" => "disable",
"options" => array("disable","enable")),

array(
"name" => __("Your prefered custom image header height"),
"id" => $shortname . $shortprefix . "image_height",
"inblock" => "header",
"type" => "text",
"std" => "150",
),


array (
"name" => __("Header background color"),
"id" => $shortname . $shortprefix . "header_color",
"inblock" => "header",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Header text color"),
"id" => $shortname . $shortprefix . "header_text_color",
"inblock" => "header",
"std" => "",
"type" => "colorpicker"),


//nav

array (
"name" => __("Top navigation block color"),
"id" => $shortname . $shortprefix . "topnav_block_color",
"inblock" => "topnav",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Top navigation links color"),
"id" => $shortname . $shortprefix . "topnav_block_link_color",
"inblock" => "topnav",
"std" => "",
"type" => "colorpicker"),


//nav

array (
"name" => __("Navigation background color"),
"id" => $shortname . $shortprefix . "nav_bg_color",
"inblock" => "nav",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Navigation links color"),
"id" => $shortname . $shortprefix . "nav_text_link_color",
"inblock" => "nav",
"std" => "",
"type" => "colorpicker"),


array (
"name" => __("Navigation links hover color"),
"id" => $shortname . $shortprefix . "nav_text_link_hover_color",
"inblock" => "nav",
"std" => "",
"type" => "colorpicker"),



// footer


array (
"name" => __("Footer background color"),
"id" => $shortname . $shortprefix . "footer_color",
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
"name" => __("Sidebar box background color"),
"id" => $shortname . $shortprefix . "sidebar_box_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar gridline color"),
"id" => $shortname . $shortprefix . "sidebar_line_bg_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar box text color"),
"id" => $shortname . $shortprefix . "sidebar_box_text_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar box text link color"),
"id" => $shortname . $shortprefix . "sidebar_box_text_link_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar box text link <strong>hover</strong> color"),
"id" => $shortname . $shortprefix . "sidebar_box_text_link_hover_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),



array (
"name" => __("Sidebar H2 header background color"),
"id" => $shortname . $shortprefix . "sidebar_header_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar H2 header text color"),
"id" => $shortname . $shortprefix . "sidebar_header_text_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("Sidebar H2 header text link color"),
"id" => $shortname . $shortprefix . "sidebar_header_text_link_color",
"inblock" => "sidebar",
"std" => "",
"type" => "colorpicker"),






// member userbar and optionbar

array (
"name" => __("BuddyFun member theme <strong>userbar</strong> background color"),
"id" => $shortname . $shortprefix . "userbar_bg_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("BuddyFun member theme <strong>userbar</strong> text color"),
"id" => $shortname . $shortprefix . "userbar_text_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker"),

array (
"name" => __("BuddyFun member theme <strong>userbar</strong> text link color"),
"id" => $shortname . $shortprefix . "userbar_text_link_color",
"inblock" => "msidebar",
"std" => "",
"type" => "colorpicker")

);



function buddyfun_admin_panel() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<h4><?php echo "$themename"; ?> <?php _e('Theme Options'); ?></h4>
<form action="" method="post">

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

<?php } elseif (($value['inblock'] == "signup") && ($value['type'] == "checkbox") ) { // setting ?>

<?php if(get_settings($value['id'])) { $checked = "checked=\"checked\""; } else { $checked = ""; } ?>

<div class="description"><p><input type="<?php echo $value['type']; ?>" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="<?php echo $value['id']; ?>" <?php echo $checked; ?> /> <?php echo $value['name']; ?></p></div>


<?php } } ?>

</div>
</div>






</div>


<!--block 2-->



<div class="option-block">


<div class="get-option">
<h2><?php _e("Global CSS Settings") ?></h2>
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
<h2><?php _e("Top Navigation CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "topnav") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "topnav") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "topnav") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "topnav") && ($value['type'] == "select") ) { // setting ?>

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
<h2><?php _e("Main Navigation CSS Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "nav") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "nav") && ($value['type'] == "select") ) { // setting ?>

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


<!--block 3-->

<div class="option-block">

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


<?php
if( function_exists('bp_exists') ) {
$bp_existed = 'true';
} else {
$bp_existed = 'false';
}
if($bp_existed == 'true') { ?>

<div class="get-option">
<h2><?php _e("Member Theme Userbar Settings") ?></h2>
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

<?php } ?>

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




function buddyfun_admin_register() {
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

add_theme_page(_g ($themename . __(' Theme Options')),  _g (__('Theme Options')),  'edit_themes', 'functions.php', 'buddyfun_admin_panel');
}

add_action('admin_menu', 'buddyfun_admin_register');



///////////////////////////////////////////////////////////////
// admin header/////////////////////////////////////////
////////////////////////////////////////////////////////////////


function buddyfun_admin_head() { ?>

<link href="<?php bloginfo('template_directory'); ?>/admin/custom-admin.css" rel="stylesheet" type="text/css" />

<?php if($_GET["page"] == "functions.php") { ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jscolor.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>

<?php } ?>

<?php }

add_action('admin_head', 'buddyfun_admin_head');





////////////////////////////////////////////////////////////////////////////////
// CUSTOM IMAGE HEADER  - IF ON WILL BE SHOWN ELSE WILL HIDE
////////////////////////////////////////////////////////////////////////////////


$header_enable = get_option('tn_buddyfun_header_on');

if($header_enable == 'enable') {

$custom_height = get_option('tn_buddyfun_image_height');
if($custom_height==''){$custom_height='150';}else{$custom_height = get_option('tn_buddyfun_image_height'); }


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 960); //width is fixed
define('HEADER_IMAGE_HEIGHT', $custom_height);
define('NO_HEADER_TEXT', true );


function buddyfun_admin_header_style() { ?>
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
add_custom_image_header('', 'buddyfun_admin_header_style');
}
} else { }







?>