<?php



if ( function_exists('register_sidebar') )

{

	register_sidebar(array('name'=>'Sidebar 1'));

	register_sidebar(array('name'=>'Sidebar 2'));

}



function wp_list_pages2($limit=NULL) {

	

	$defaults = array('depth' => 0, 'show_date' => '', 'date_format' => get_option('date_format'),

		'child_of' => 0, 'exclude' => '', 'title_li' =>'', 'echo' => 1, 'authors' => '', 'sort_column' => 'menu_order, post_title');

	$r = array_merge((array)$defaults, (array)$r);



	$output = '';

	$current_page = 0;



	// sanitize, mostly to keep spaces out

	$r['exclude'] = preg_replace('[^0-9,]', '', $r['exclude']);



	// Allow plugins to filter an array of excluded pages

	$r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', explode(',', $r['exclude'])));



	// Query pages.

	$pages = get_pages($r);



	if ( !empty($pages) ) {



		for($i=0;$i<count($pages);$i++)

		{

			$output .=' <li> <a href="'.get_page_link($pages[$i]->ID).'">'.$pages[$i]->post_title.'</a></li>';

			if($limit!=NULL)

			{

				break;

			}

		}

	}



	$output = apply_filters('wp_list_pages', $output);



	echo $output;

}

	

function get_sidebar_right() {

	do_action( 'get_sidebar' );

	if ( file_exists( TEMPLATEPATH . '/sidebar_right.php') )

		load_template( TEMPLATEPATH . '/sidebar_right.php');

	else

		load_template( ABSPATH . 'wp-content/themes/default/sidebar.php');

}



function get_links_list2($order = 'name', $hide_if_empty = 'obsolete') {

	$order = strtolower($order);



	// Handle link category sorting

	$direction = 'ASC';

	if ( '_' == substr($order,0,1) ) {

		$direction = 'DESC';

		$order = substr($order,1);

	}



	if ( !isset($direction) )

		$direction = '';



	$cats = get_categories("type=link&orderby=$order&order=$direction&hierarchical=0");



	// Display each category

	if ( $cats ) {

		foreach ( (array) $cats as $cat ) {

			// Handle each category.



			// Call get_links() with all the appropriate params

			get_links($cat->cat_ID, '<li>', "</li>", "\n", true, 'name', false);



		}

	}

}



///////////////////////////////////////////////////////////////////////////
//////////////////////////CUSTOM THEME OPTION//////////////////////////////
///////////////////////////////////////////////////////////////////////////

$themename = "oceanwide";
$shortname = "oc";

$options = array (


     array(	"name" => "Choose Your Global Body Font Size?",
			"id" => $shortname."_ow_global_body_font_size",
            "type" => "select",
            "inblock" => "css",
			"std" => "65%",
			"options" => array("65%","70%","75%","80%","85%","90%","100%")
            ),


     array(	"name" => "Choose Your Global Body Font?",
			"id" => $shortname."_ow_body_font",
            "type" => "select",
            "inblock" => "css",
			"std" => "Verdana, Arial, Times New Roman, sans-serif",
			"options" => array(
            "Verdana, Arial, Times New Roman, sans-serif",
            "Lucida Grande, Verdana, Tahoma, Trebuchet MS",
            "Arial, Verdana, Times New Roman, sans-serif",
            "Times New Roman, Georgia, Tahoma, Trajan Pro",
            "Georgia, Times New Roman, Helvetica, sans-serif",
            "Futura LT Book, Helvetica Neue, Tahoma, Georgia",
            "Tahoma, Lucida Sans, Arial",
            "Lucida Sans, Lucida Grande, Trebuchet MS",
            "Century Gothic, Century, Georgia, Times New Roman",
            "Arial Rounded MT Bold, Arial, Verdana, sans-serif",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Futura-CondensedExtraBold-Norma, Arial Black, Tahoma",
            "Delicious Heavy, Georgia, Tahoma",
            "Delicious, Delicious Heavy, Decker, Denmark",
            "Helvetica Neue, Helvetica LT Std Cond, Helvetica-Normal",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande, Georgia",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS, Tahoma, Arial"
            )
            ),

	array(	"name" => "Choose Your Global Headline Font",
			"id" => $shortname."_ow_headline_font",
            "type" => "select",
            "inblock" => "css",
            "std" => "Lucida Grande, Verdana, Tahoma, Trebuchet MS",
			"options" => array(
            "Lucida Grande, Verdana, Tahoma, Trebuchet MS",
            "Cambria, Georgia, Geneva, Verdana",
            "Arial, Verdana, Times New Roman, sans-serif",
            "Verdana, Arial, Times New Roman, sans-serif",
            "Times New Roman, Georgia, Tahoma, Trajan Pro",
            "Georgia, Times New Roman, Helvetica, sans-serif",
            "Futura LT Book, Helvetica Neue, Tahoma, Georgia",
            "Tahoma, Lucida Sans, Arial",
            "Lucida Sans, Lucida Grande, Trebuchet MS",
            "Century Gothic, Century, Georgia, Times New Roman",
            "Arial Rounded MT Bold, Arial, Verdana, sans-serif",
            "Trebuchet MS, Arial, Verdana, Helvetica, sans-serif",
            "Futura-CondensedExtraBold-Norma, Arial Black, Tahoma",
            "Delicious Heavy, Georgia, Tahoma",
            "Delicious, Delicious Heavy, Decker, Denmark",
            "Helvetica Neue, Helvetica LT Std Cond, Helvetica-Normal",
            "Humana Sans ITC, Humana Sans Md ITC, Lucida Grande, Georgia",
            "Qlassik Bold, Qlassik Medium, Trebuchet MS, Tahoma, Arial"
            )
            ),



    array(  "name" => "Enable Header Sitename Title?",
			"id" => $shortname."_ow_titlename_status",
            "inblock" => "header",
			"type" => "select",
            "std" => "yes",
			"options" => array("yes","no")),


    array(  "name" => "Header Title Background Colour <br />*<em>opacity active</em>",
			"id" => $shortname."_ow_title_background_trans_colour",
            "inblock" => "header",
			"type" => "text",
            "std" => "#33466E"),

    array(  "name" => "Header Site Description Colour",
			"id" => $shortname."_ow_titlename_text_colour",
            "inblock" => "header",
			"type" => "text",
            "std" => "#FFFFFF"),

    array(  "name" => "Header Sitename Title Colour",
			"id" => $shortname."_ow_titlename_sitename_colour",
            "inblock" => "header",
			"type" => "text",
            "std" => "#FFFFFF"),


    array(  "name" => "Header Sitename Title Size?",
			"id" => $shortname."_ow_titlename_size",
            "inblock" => "header",
			"type" => "select",
            "std" => "20px",
			"options" => array("20px","22px","24px","26px","28px","30px","32px","34px")),





    array(	"name" => "Your Desired Image Header Height *this will effect when cropping",
			"id" => $shortname."_ow_image_height",
            "inblock" => "css",
            "std" => "198",
			"type" => "text"),

    array(  "name" => "Do you want to use the images rotations? <br />*<em>size accepted 980 x <strong>your image height setting above</strong> or more</em>",
			"id" => $shortname."_ow_image_rotate_status",
            "inblock" => "rotator",
			"type" => "select",
            "std" => "no",
			"options" => array("no", "yes")),


    array(	"name" => "First Image Rotations <br />*<em>only effect if image rotate setting enable</em><br />*<em>External image url or internal image url accepted</em><br />*<em>You can upload image in write panel for internal image url</em>",
			"id" => $shortname."_ow_image_one",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Second Image Rotations",
			"id" => $shortname."_ow_image_two",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Third Image Rotations",
			"id" => $shortname."_ow_image_three",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Fourth Image Rotations",
			"id" => $shortname."_ow_image_four",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text")


);

function mytheme_ow_admin() {
global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>




<div id="custom-wrap">
<div id="custom-container">
<form method="post" id="option-mz-form">

<div class="option-box">
<h5>Blog CSS Settings</h5>
<?php foreach ($options as $value) {
if (($value['inblock'] == "css") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<opti<?php _e('on');?> <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "css") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }

}
?>
</div>



<div class="option-box">
<h5>Blog Header Settings</h5>
<?php foreach ($options as $value) {
if (($value['inblock'] == "header") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<opti<?php _e('on');?> <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "header") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }

}
?>
</div>



<div class="option-box">
<h5>Blog Header Image Rotate Settings</h5>
<?php foreach ($options as $value) {
if (($value['inblock'] == "rotator") && ($value['type'] == "text")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><input name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p></div>

<?php } elseif (($value['inblock'] == "rotator") && ($value['type'] == "select")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<p><select name="<?php echo $value['id']; ?>" class="ops-select" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<opti<?php _e('on');?> <?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p></div>

<?php } elseif (($value['inblock'] == "rotator") && ($value['type'] == "textarea")) { ?>

<div class="pwrap">
<p><?php echo $value['name']; ?>:</p>
<?php $valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<p><textarea name="<?php echo $valuey; ?>" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea>
</p></div>
<?php }

}
?>
</div>

<p class="submit">
<input name="save" type="submit" class="saveme" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>

<form method="post">
<p class="submit">
<input name="reset" type="submit" class="saveme" value="<?php _e('Reset')?>" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
</div>
 </div>


<?php
}

function mytheme_add_ow_admin() {
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
add_theme_page($themename." Options", "Blog Options", 'edit_themes', basename(__FILE__), 'mytheme_ow_admin');
}



////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function mytheme_wp_ow_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/admin/ow-admin.css" rel="stylesheet" type="text/css" />
<?php }

add_action('admin_head', 'mytheme_wp_ow_head');
add_action('admin_menu', 'mytheme_add_ow_admin');







///////////////////////////////////////////////////////////////////////////
//////////////////////////CUSTOM HEADER CONFIG/////////////////////////////
///////////////////////////////////////////////////////////////////////////

$user_image_height = get_option('oc_ow_image_height');

if($user_image_height==''){$user_image_height='198';}else{$user_image_height = get_option('oc_ow_image_height'); }

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header_center_bg.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 980); //width is fixed
define('HEADER_IMAGE_HEIGHT', $user_image_height);
define( 'NO_HEADER_TEXT', true );

function oceanwide_admin_header_style() {
?>
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
<?php
}


function oceanwide_header_style() {
?>
<style type="text/css">

#header_center {
width: 970px;
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
overflow: hidden;
float: left;
margin: 0px;
position: relative;
}
#header_center_original {
width: 970px;
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
overflow: hidden;
float: left;
margin: 0px;
position: relative;
}
</style>
<?php
}


if ( function_exists('add_custom_image_header') ) {
	add_custom_image_header('oceanwide_header_style', 'oceanwide_admin_header_style');
}


?>