<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="title"> <h2>',
        'after_title' => '</h2> </div>',
    ));
    function widget_mytheme_search() {
?>
	<div class="widget" id="slightpad">
		<div class="title"><h2>Browse</h2></div>
		<select name="archivemenu" onChange="document.location.href=this.options[this.selectedIndex].value;">
		<option value="">Monthly Archives</option>
<?php get_archives('monthly','','option','','',''); ?>
		</select>		
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_mytheme_search');







///////////////////////////////////////////////////////////////////////////
//////////////////////////CUSTOM THEME OPTION//////////////////////////////
///////////////////////////////////////////////////////////////////////////

$themename = "oceanmist";
$shortname = "oc";

$options = array (

    array(	"name" => "Choose Your Global Body Font Size?",
			"id" => $shortname."_om_body_font_size",
            "type" => "select",
            "inblock" => "css",
			"std" => "70%",
			"options" => array("70%", "75%", "80%", "90%", "100%")),



     array(	"name" => "Choose Your Global Body Font?",
			"id" => $shortname."_om_body_font",
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
			"id" => $shortname."_om_headline_font",
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

    array(	"name" => "Your Desired Image Header Height *this will effect when cropping",
			"id" => $shortname."_om_image_height",
            "inblock" => "css",
            "std" => "200",
			"type" => "text"),



    array(	"name" => "Do you want to use the images rotations? *size accepted 736x<strong>your image height setting above</strong> or more",
			"id" => $shortname."_om_image_rotate_status",
            "inblock" => "rotator",
			"type" => "select",
            "std" => "no",
			"options" => array("no", "yes")),


    array(	"name" => "First Image Rotations *only effect if image rotate setting enable*",
			"id" => $shortname."_om_image_one",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Second Image Rotations",
			"id" => $shortname."_om_image_two",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Third Image Rotations",
			"id" => $shortname."_om_image_three",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text"),

    array(	"name" => "Fourth Image Rotations",
			"id" => $shortname."_om_image_four",
            "inblock" => "rotator",
            "std" => "",
			"type" => "text")


);

function mytheme_om_admin() {
global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>




<div id="custom-wrap">
<div id="custom-container">

<div id="notes">
<p>if image rotation enable but no url insert, auto images header will initatited...so have fun</p>
</div>

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
<h5>Images Rotation Settings</h5>
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

function mytheme_add_om_admin() {
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
add_theme_page($themename." Options", "Blog Options", 'edit_themes', basename(__FILE__), 'mytheme_om_admin');
}



////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function mytheme_wp_om_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/admin/om-admin.css" rel="stylesheet" type="text/css" />
<?php }

add_action('admin_head', 'mytheme_wp_om_head');
add_action('admin_menu', 'mytheme_add_om_admin');



///////////////////////////////////////////////////////////////////////////
//////////////////////////CUSTOM HEADER CONFIG/////////////////////////////
///////////////////////////////////////////////////////////////////////////



$c_h_height = get_option('oc_om_image_height');

if($c_h_height==''){$c_h_height='200';}else{$c_h_height = get_option('oc_om_image_height'); }

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/mainpic01.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 736); //width is fixed
define('HEADER_IMAGE_HEIGHT', $c_h_height);
define( 'NO_HEADER_TEXT', true );

function oceanmist_admin_header_style() {
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
function oceanmist_header_style() {
?>

<style type="text/css">
* html #mainpic {
       margin: 0px 5px 0px 3px!important;
}
#mainpic {
    overflow: hidden;
    position: relative;
    float: left;
    height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#mainpic img{
    border: 0px;
    float: left;
}
</style>
<?php
}
if ( function_exists('add_custom_image_header') ) {
	add_custom_image_header('oceanmist_header_style', 'oceanmist_admin_header_style');
}

?>
