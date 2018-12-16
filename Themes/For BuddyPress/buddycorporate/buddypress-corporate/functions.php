<?php

$includes_path = TEMPLATEPATH . '/includes/';
require_once ($includes_path . 'custom-functions.php');

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


/* Register the widget columns */
register_sidebars( 1,
	array( 
		'name' => __('left-column'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);

register_sidebars( 1,
	array( 
		'name' => __('center-column'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);

register_sidebars( 1,
	array( 
		'name' => __('right-column'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	) 
);
register_sidebars( 1,
	array(
		'name' => __('blog-sidebar'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	)
);

register_sidebars( 1,
	array(
		'name' => __('footer-left'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	)
);


register_sidebars( 1,
	array(
		'name' => __('footer-center'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	)
);

register_sidebars( 1,
	array(
		'name' => __('footer-right'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>'
	)
);




///////////////////////////////////////////////////////////////
// multiple option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

function _g($str)
{
return __($str, 'option-page');
}




////////////////////////////////////////////////////////////////////////////////
// theme option menu for buddycorp - june 2009
////////////////////////////////////////////////////////////////////////////////

$themename = "BuddyPress Corporate";
$themeversion = "1.0";
$shortname = "tn";

$shortprefix = "_buddycorp_";

// get design style
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


// get featured category
$wp_dropdown_rd_admin = $wpdb->get_results("SELECT $wpdb->term_taxonomy.term_id,name,description,count FROM $wpdb->term_taxonomy LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id WHERE parent = 0 AND taxonomy = 'category' AND count != '0' GROUP BY $wpdb->terms.name ORDER by $wpdb->terms.name ASC");
$wp_getcat = array();
foreach ($wp_dropdown_rd_admin as $category_list) {
$wp_getcat[$category_list->term_id] = $category_list->name;
}
$category_bulk_list = array_unshift($wp_getcat, "Choose a category:");



$options = array (


array(
"name" => __("Choose your <strong>Homepage</strong> featured category"),
"id" => $shortname . $shortprefix . "home_featured_cat",
"box"=> "1",
"inblock" => "homepage",
"type" => "select",
"std" => "Choose a category:",
"options" => $wp_getcat),





array(
"name" => __("Insert your logo full url here<br /><em>*you can upload your logo in <a href='media-new.php'>media panel</a> and copy paste the url here</em>"),
"id" => $shortname . $shortprefix . "header_logo",
"box"=> "2",
"inblock" => "header",
"type" => "text",
"std" => "",
),


array(
"name" => __("Do you want to enable custom image header?"),
"id" => $shortname . $shortprefix . "header_on",
"box"=> "2",
"inblock" => "header",
"type" => "select",
"std" => "disable",
"options" => array("disable","enable")),

array(
"name" => __("Your prefered custom image header height"),
"id" => $shortname . $shortprefix . "image_height",
"box"=> "2",
"inblock" => "header",
"type" => "text",
"std" => "150",
),


array(
"name" => __("Check this box to disable the welcome message"),
"id" => $shortname . $shortprefix . "call_signup_on",
"box"=> "2",
"inblock" => "signup",
"type" => "checkbox",
"std" => "disable"),


array(
"name" => __("Edit your welcome message here&nbsp;&nbsp;&nbsp;<em>*html allowed</em>"),
"id" => $shortname . $shortprefix . "call_signup_text",
"box"=> "2",
"inblock" => "signup",
"type" => "textarea",
"std" => "Welcome to your BuddyPress Corporate theme!<br />
<span>Change or remove the text here using the <a href='wp-admin/themes.php?page=functions.php'>theme options</a></span>",
),

array(
"name" => __("Edit your welcome message button text here"),
"id" => $shortname . $shortprefix . "call_signup_button_text",
"box"=> "2",
"inblock" => "signup",
"type" => "text",
"std" => "Join Us Here",
),






array(
"name" => __("Choose your body font"),
"id" => $shortname . $shortprefix  . "body_font",
"type" => "select",
"box"=> "1",
"inblock" => "css",
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
"box"=> "1",
"inblock" => "css",
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
"inblock" => "css",
"id" => $shortname . $shortprefix . "font_size",
"type" => "select",
"std" => "normal",
"options" => array("normal", "medium", "bigger", "largest")),




);


function buddycorp_admin() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>



<h4><?php echo "$themename"; ?> <?php _e('Theme Options'); ?></h4>

<form action="" method="post">

<?php if( $value['box'] = '1' ) {  ?>

<div class="option-block">

<div class="get-option">
<h2><?php _e("Blog Homepage Settings") ?></h2>
<div class="option-save">

<?php foreach ($options as $value) { ?>

<?php if (($value['inblock'] == "homepage") && ($value['type'] == "text")) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>

<?php } elseif (($value['inblock'] == "homepage") && ($value['type'] == "textarea")) { // setting ?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>


<?php } elseif (($value['inblock'] == "homepage") && ($value['type'] == "text") && ($value['custom'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
</p>

<?php } elseif (($value['inblock'] == "homepage") && ($value['type'] == "select") ) { // setting ?>

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
<h2><?php _e("Blog CSS Settings") ?></h2>
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


<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "text") && ($value['custom'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
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

</div><!-- end option block -->

<?php } ?>



<?php if( $value['box'] = '2' ) {  ?>

<div class="option-block">

<div class="get-option">
<h2><?php _e("Blog Header Settings") ?></h2>
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


<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "text") && ($value['custom'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
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
</div>



<div class="option-block">

<div class="get-option">
<h2><?php _e("Blog Welcome Message Settings") ?></h2>
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


<?php } elseif (($value['inblock'] == "signup") && ($value['type'] == "text") && ($value['custom'] == "colorpicker") ) { // setting ?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p><input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
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



</div>

<?php
}

function buddycorp_admin_register() {
global $themename, $shortname, $options;
if ( $_GET['page'] == basename(__FILE__) ) {
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
add_theme_page(_g ($themename . __(' Options')),  _g (__('Theme Options')),  'edit_themes', basename(__FILE__), 'buddycorp_admin');
}





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


function buddycorp_preset_styles_admin_panel() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options2;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<h4><?php echo "$themename"; ?> <?php _e('Preset Styles'); ?></h4>
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


function buddycorp_preset_styles_admin_register() {
global $themename, $shortname, $options2;
if ( $_GET['page'] == 'buddycorp-styles.php' ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options2 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
header("Location: themes.php?page=buddycorp-styles.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options2 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=buddycorp-styles.php&reset=true");
die;
}
}

add_theme_page(_g (__('BuddyPress Corporate Preset Styles')),  _g (__('Preset Styles')),  'edit_themes', 'buddycorp-styles.php', 'buddycorp_preset_styles_admin_panel');

}

add_action('admin_menu', 'buddycorp_preset_styles_admin_register');





////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function buddycorp_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/admin/custom-admin.css" rel="stylesheet" type="text/css" />
<?php }


add_action('admin_head', 'buddycorp_head');
add_action('admin_menu', 'buddycorp_admin_register');


////////////////////////////////////////////////////////////////////////////////
// CUSTOM IMAGE HEADER  - IF ON WILL BE SHOWN ELSE WILL HIDE
////////////////////////////////////////////////////////////////////////////////


$header_enable = get_option('tn_buddycorp_header_on');
if($header_enable == 'enable') {
$custom_height = get_option('tn_buddycorp_image_height');
if($custom_height==''){$custom_height='150';}else{$custom_height = get_option('tn_buddycorp_image_height'); }


define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 988); //width is fixed
define('HEADER_IMAGE_HEIGHT', $custom_height);
define('NO_HEADER_TEXT', true );


function buddycorp_admin_header_style() { ?>
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
add_custom_image_header('', 'buddycorp_admin_header_style');
}
} else { }



?>