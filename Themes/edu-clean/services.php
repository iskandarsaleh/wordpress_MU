<?php
##########################################################################################################

# IMAGE FUNCTIONS																						 #

# You do not need to alter these functions																 #

##########################################################################################################

function resizeImage($image,$width,$height,$scale) {
list($imagewidth, $imageheight, $imageType) = getimagesize($image);
$imageType = image_type_to_mime_type($imageType);
$newImageWidth = ceil($width * $scale);
$newImageHeight = ceil($height * $scale);
$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
switch($imageType) {
case "image/gif":
$source=imagecreatefromgif($image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
$source=imagecreatefromjpeg($image);
break;
case "image/png":
case "image/x-png":
$source=imagecreatefrompng($image);
break;
}
imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

switch($imageType) {
case "image/gif":
imagegif($newImage,$image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
imagejpeg($newImage,$image,90);
break;
case "image/png":
case "image/x-png":
imagepng($newImage,$image);
break;
}
chmod($image, 0777);
return $image;
}

//You do not need to alter these functions

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
list($imagewidth, $imageheight, $imageType) = getimagesize($image);
$imageType = image_type_to_mime_type($imageType);
$newImageWidth = ceil($width * $scale);
$newImageHeight = ceil($height * $scale);
$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
switch($imageType) {
case "image/gif":
$source=imagecreatefromgif($image);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
$source=imagecreatefromjpeg($image);
break;
case "image/png":
case "image/x-png":
$source=imagecreatefrompng($image);
break;
}

imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
switch($imageType) {
case "image/gif":
imagegif($newImage,$thumb_image_name);
break;
case "image/pjpeg":
case "image/jpeg":
case "image/jpg":
imagejpeg($newImage,$thumb_image_name,90);
break;
case "image/png":
case "image/x-png":
imagepng($newImage,$thumb_image_name);
break;
}
chmod($thumb_image_name, 0777);
return $thumb_image_name;
}

//You do not need to alter these functions

function getHeight($image) {
$size = getimagesize($image);
$height = $size[1];
return $height;
}

//You do not need to alter these functions

function getWidth($image) {
$size = getimagesize($image);
$width = $size[0];
return $width;
}

////////////////////////////////////////////////////////////////////////

////////////start img////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////


$options4 = array (

array (	"name" => "Service headline 1",
"id" => $shortname."_edus_headline1",
"std" => "Service Headline 1",
"type" => "text"),

array (	"name" => "Service short text 1",
"id" => $shortname."_edus_text1",
"std" => "",
"type" => "textarea")

);


$options5 = array (

array (	"name" => "Service headline 2",
"id" => $shortname."_edus_headline2",
"std" => "Service Headline 2",
"type" => "text"),

array (	"name" => "Service short text 2",
"id" => $shortname."_edus_text2",
"std" => "",
"type" => "textarea")

);


$options6 = array (

array (	"name" => "Service headline 3",
"id" => $shortname."_edus_headline3",
"std" => "Service Headline 3",
"type" => "text"),

array (	"name" => "Service short text 3",
"id" => $shortname."_edus_text3",
"std" => "",
"type" => "textarea")

);


$options7 = array (

array (	"name" => "Service headline 4",
"id" => $shortname."_edus_headline4",
"std" => "Service Headline 4",
"type" => "text"),

array (	"name" => "Service short text 4",
"id" => $shortname."_edus_text4",
"std" => "",
"type" => "textarea")

);

$options8 = array (

array (	"name" => "Service headline 5",
"id" => $shortname."_edus_headline5",
"std" => "Service Headline 5",
"type" => "text"),

array (	"name" => "Service short text 5",
"id" => $shortname."_edus_text5",
"std" => "",
"type" => "textarea")

);


$options9 = array (

array (	"name" => "Service headline 6",
"id" => $shortname."_edus_headline6",
"std" => "Service Headline 6",
"type" => "text"),

array (	"name" => "Service short text 6",
"id" => $shortname."_edus_text6",
"std" => "",
"type" => "textarea")

);



function edus_features_page() { ?>

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
$gallery_folder = "thumbs";

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
$gallery_folder = "thumbs";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/";
$upload_path_check = ABSPATH . 'wp-content/' . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/" . $gallery_folder;
}




// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // do not change this
$image_ext = "";	// initialise variable, do not change this.
foreach ($allowed_image_ext as $mime_type => $ext) {
$image_ext.= strtoupper($ext)." ";
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////

$large_image_name = 'edu1.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu1_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

if (isset($_POST['upload1'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
//double refresh to clear cache..its a bit catchy but it get the job don
}
}

if (isset($_POST['upload_thumbnail1']) && strlen($large_photo_exists) > 0) {
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
//double refresh to clear cache..its a bit catchy but it get the job done
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>


<div id="admin-options">

<?php global $themename, $shortname;
if ( $_REQUEST['resetall'] )
echo '<div id="message" class="updated fade"><p><strong>All images deleted and settings reset</strong></p></div>';
?>

<?php
global $themename, $shortname, $options4;
if ( $_REQUEST['saved4'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 1 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset4'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 1 Settings reset.</strong></p></div>';
?>

<h4>Featured images 1 Setting</h4>
<div class="get-option">
<h2>Image block 1 &raquo;</h2>
<div class="option-save">


<?php
if (isset($_POST['delete_thumbnail1'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);

echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail1" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists)>0) { ?>

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
<input type="submit" name="upload_thumbnail1" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload1" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />
<form method="post">

<?php foreach ($options4 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>


<?php } ?>


<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save4" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset4" />
</p>
</form>

</div>
</div>
</div>

<?php


///////////////////////////
//// slider2 //////////////
///////////////////////////


$large_image_name = 'edu2.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu2_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

if (isset($_POST['upload2'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();

//double refresh to clear cache..its a bit catchy but it get the job don
}
}

if ( isset($_POST['upload_thumbnail2']) && strlen($large_photo_exists) > 0 ) {
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
//double refresh to clear cache..its a bit catchy but it get the job done
}
?>

<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists) > 0){
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>


<div id="admin-options">

<?php
global $themename, $shortname, $options5;
if ( $_REQUEST['saved5'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 2 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset5'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 2 Settings reset.</strong></p></div>';
?>

<h4>Featured image 2 Setting</h4>
<div class="get-option">
<h2>Image block 2 &raquo;</h2>
<div class="option-save">



<?php
if (isset($_POST['delete_thumbnail2'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);

echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail2" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists) > 0 ) { ?>

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
<input type="submit" name="upload_thumbnail2" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload2" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />

<form method="post">

<?php foreach ($options5 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>


<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save5" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset5" />
</p>
</form>

</div>
</div>
</div>

<?php



///////////////////////////
//// slider3 //////////////
///////////////////////////


$large_image_name = 'edu3.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu3_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

?>


<div id="admin-options">

<?php
global $themename, $shortname, $options6;
if ( $_REQUEST['saved6'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 3 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset6'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 3 Settings reset.</strong></p></div>';
?>

<h4>Featured image 3 Setting</h4>
<div class="get-option">
<h2>Image block 3 &raquo;</h2>
<div class="option-save">
<?php

if (isset($_POST['upload3'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file ) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST['upload_thumbnail3']) && strlen($large_photo_exists)>0) {
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>



<?php
if (isset($_POST['delete_thumbnail3'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);

echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail3" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists)>0) { ?>

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
<input type="submit" name="upload_thumbnail3" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload3" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />

<form method="post">

<?php foreach ($options6 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>

<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save6" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset6" />
</p>
</form>

</div>
</div>
</div>

<?php




///////////////////////////
//// slider4 //////////////
///////////////////////////


$large_image_name = 'edu4.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu4_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

?>


<div id="admin-options">

<?php
global $themename, $shortname, $options7;
if ( $_REQUEST['saved7'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Slider 4 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset7'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Slider 4 Settings reset.</strong></p></div>';
?>

<h4>Featured image 4 Setting</h4>
<div class="get-option">
<h2>Image block 4 &raquo;</h2>
<div class="option-save">
<?php

if (isset($_POST['upload4'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file ) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST['upload_thumbnail4']) && strlen($large_photo_exists)>0) {
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>



<?php
if (isset($_POST['delete_thumbnail4'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail4" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists)>0) { ?>

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
<input type="submit" name="upload_thumbnail4" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload4" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />

<form method="post">

<?php foreach ($options7 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>

<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save7" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset7" />
</p>
</form>

</div>
</div>
</div>

<?php




///////////////////////////
//// slider5 //////////////
///////////////////////////


$large_image_name = 'edu5.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu5_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

?>


<div id="admin-options">

<?php
global $themename, $shortname, $options8;
if ( $_REQUEST['saved8'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 5 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset8'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 5 Settings reset.</strong></p></div>';
?>

<h4>Featured image 5 Setting</h4>
<div class="get-option">
<h2>Image block 5 &raquo;</h2>
<div class="option-save">
<?php

if (isset($_POST['upload5'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file ) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST['upload_thumbnail5']) && strlen($large_photo_exists)>0) {
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>



<?php
if (isset($_POST['delete_thumbnail5'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail5" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists)>0) { ?>

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
<input type="submit" name="upload_thumbnail5" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload5" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />

<form method="post">

<?php foreach ($options8 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>

<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save8" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset8" />
</p>
</form>

</div>
</div>
</div>

<?php




///////////////////////////
//// slider6 //////////////
///////////////////////////


$large_image_name = 'edu6.jpg'; 		     // New name of the large image
$thumb_image_name = 'edu6_thumb.jpg'; 	// New name of the thumbnail image
$max_file = "1000000"; 						        // Approx below 1MB
$max_width = "850";							        // Max width allowed for the large image
$thumb_width = "200";						        // Width of thumbnail image
$thumb_height = "100";                              // Height of thumbnail image

//Image Locations
$large_image_location = $upload_path . $large_image_name;
$thumb_image_location = $upload_path . $thumb_image_name;
//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_path_check)){
mkdir($upload_path_check, 0777);
chmod($upload_path_check, 0777);
}
//Check to see if any images with the same names already exist
if (file_exists($large_image_location)){
if (file_exists($thumb_image_location)){
$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
} else {
$thumb_photo_exists = "";
}
$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
} else {
$large_photo_exists = "";
$thumb_photo_exists = "";
}

?>


<div id="admin-options">

<?php
global $themename, $shortname, $options9;
if ( $_REQUEST['saved9'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 6 Settings saved.</strong></p></div>';
if ( $_REQUEST['reset9'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' Featured image 6 Settings reset.</strong></p></div>';
?>

<h4>Featured image 6 Setting</h4>
<div class="get-option">
<h2>Image block 6 &raquo;</h2>
<div class="option-save">
<?php

if (isset($_POST['upload6'])) {
//Get the file information
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_type = $_FILES['image']['type'];
$userfile_size = $_FILES['image']['size'];
$filename = basename($_FILES['image']['name']);
$file_ext = substr($filename, strrpos($filename, '.') + 1);

//Only process if the file is a JPG, PNG or GIF and below the allowed limit

if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
foreach ($allowed_image_types as $mime_type => $ext) {
//loop through the specified image types and if they match the extension then break out
//everything is ok so go and check file size
if($file_ext==$ext && $userfile_type==$mime_type){
$error = "";
break;
} else {
$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
}
}

//check if the file size is above the allowed limit

if ($userfile_size > $max_file ) {
$error.= "Images must be under 1 MB in size";
}

} else {
$error= "Select an image for upload";
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
} else {
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
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php";
print "</script>";
print "<script>";
print " self.location='$ttpl_url/wp-admin/themes.php?page=custom-homepage.php';";
print "</script>";
exit();
}
}

if (isset($_POST['upload_thumbnail6']) && strlen($large_photo_exists)>0) {
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
} else {
return true;
}
});
});
function selectionStart(img, selection) { width:200;height:100 }
$(window).load(function () {
$('#thumbnail').imgAreaSelect({ onSelectStart: selectionStart, resizable: true, x1: 20, y1: 20, x2: 220, y2: 120, aspectRatio: '11:6', onSelectChange: preview });
});
</script>
<?php } ?>



<?php
if (isset($_POST['delete_thumbnail6'])){
unlink($upload_path . $large_image_name);
unlink($upload_path . $thumb_image_name);
echo "<h5>File successfully deleted</h5>";
echo "<a href=\"$ttpl_url/wp-admin/themes.php?page=custom-homepage.php\">upload new&raquo;</a>";
exit();
}
?>


<?php
//Display error message if there are any
if(strlen($error)>0){
echo "<p class=\"uperror\"><strong>Error!&nbsp;</strong>" . $error . "</p>";
}

if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0) { ?>
<img src="<?php echo "$upload_url/$thumb_image_name"; ?>" class="timg"/><br /><br />
<form id="form-del" name="thumbnail" action="" method="post">
<input type="submit" name="delete_thumbnail6" class="saveme" value="Delete This Image" />
</form>

<?php } else {

if(strlen($large_photo_exists)>0) { ?>

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
<input type="submit" name="upload_thumbnail6" value="Save Thumbnail" id="save_thumb" />
</form>
</div>

<?php } ?>


<?php if(strlen($large_photo_exists)==0){ ?>
<h3>Upload Images</h3>
<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
<input type="file" class="ups" name="image" />
<input type="submit" name="upload6" value="Upload &raquo;" />
<p class="onlyjpg">* only <?php echo $image_ext; ?> image file are allowed</p>
</form>
<?php } ?>
<?php } ?>

<br /><br />

<form method="post">

<?php foreach ($options9 as $value) {   ?>

<?php
switch ( $value['type'] ) {
case 'text':
?>

<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id']);
} else {
echo $value['std']; } ?>" />
</p>

<?php
break;
case 'textarea':
?>

<?php
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);
?>
<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>

<?php
break;
default;
?>



<?php
break;
} ?>

<?php } ?>

<p class="save-p">
<input name="save" type="submit" class="sbutton" value="Save setting" />
<input type="hidden" name="action" value="save9" />
</p>
</form>

<form method="post">
<p class="save-p">
<input name="reset" type="submit" class="sbutton" value="Reset setting" />
<input type="hidden" name="action" value="reset9" />
</p>
</form>

</div>
</div>
</div>

<div id="admin-options">
<br /><br />
<form method="post">
<input name="reset" type="submit" class="sbutton" value="Delete all images and reset all text options" />
<input type="hidden" name="action" value="resetall" />
</form>
<br />
<p><strong>warning:</strong> these will delete all the services images and text settings</p>
</div>

<?php



}





function edus_features_register() {
global $themename, $shortname, $options4, $options5, $options6, $options7, $options8, $options9;

if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save4' == $_REQUEST['action'] ) {
foreach ($options4 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options4 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved4=true");
die;
} else if( 'reset4' == $_REQUEST['action'] ) {
foreach ($options4 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset4=true");
die;
}
}

if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save5' == $_REQUEST['action'] ) {
foreach ($options5 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options5 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved5=true");
die;
} else if( 'reset5' == $_REQUEST['action'] ) {
foreach ($options5 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset5=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save6' == $_REQUEST['action'] ) {
foreach ($options6 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options6 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved6=true");
die;
} else if( 'reset6' == $_REQUEST['action'] ) {
foreach ($options6 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset6=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save7' == $_REQUEST['action'] ) {
foreach ($options7 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options7 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved7=true");
die;
} else if( 'reset7' == $_REQUEST['action'] ) {
foreach ($options7 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset7=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save8' == $_REQUEST['action'] ) {
foreach ($options8 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options8 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved8=true");
die;
} else if( 'reset8' == $_REQUEST['action'] ) {
foreach ($options8 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset8=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if ( 'save9' == $_REQUEST['action'] ) {
foreach ($options9 as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options9 as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } }
header("Location: themes.php?page=custom-homepage.php&saved9=true");
die;
} else if( 'reset9' == $_REQUEST['action'] ) {
foreach ($options9 as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=custom-homepage.php&reset9=true");
die;
}
}


if ( $_GET['page'] == "custom-homepage.php" ) {
if( 'resetall' == $_REQUEST['action'] ) {
foreach ($options4 as $value){ delete_option( $value['id'] ); }
foreach ($options5 as $value){ delete_option( $value['id'] ); }
foreach ($options6 as $value){ delete_option( $value['id'] ); }
foreach ($options7 as $value){ delete_option( $value['id'] ); }
foreach ($options8 as $value){ delete_option( $value['id'] ); }
foreach ($options9 as $value){ delete_option( $value['id'] ); }

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
$gallery_folder = "thumbs";
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
$gallery_folder = "thumbs";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/";
$upload_path_check = ABSPATH . 'wp-content/' . $gallery_folder;
$ttpl = get_bloginfo('template_directory');
$ttpl_url = get_bloginfo('wpurl');
$upload_url = $ttpl_url . "/" . "wp-content/" . $gallery_folder;

}

if(file_exists($upload_path . 'edu1.jpg')) {
unlink("$upload_path_check/edu1.jpg");
unlink("$upload_path_check/edu1_thumb.jpg");
}

if(file_exists($upload_path . 'edu2.jpg')) {
unlink("$upload_path_check/edu2.jpg");
unlink("$upload_path_check/edu2_thumb.jpg");
}

if(file_exists($upload_path . 'edu3.jpg')) {
unlink("$upload_path_check/edu3.jpg");
unlink("$upload_path_check/edu3_thumb.jpg");
}

if(file_exists($upload_path . 'edu4.jpg')) {
unlink("$upload_path_check/edu4.jpg");
unlink("$upload_path_check/edu4_thumb.jpg");
}

if(file_exists($upload_path . 'edu5.jpg')) {
unlink("$upload_path_check/edu5.jpg");
unlink("$upload_path_check/edu5_thumb.jpg");
}

if(file_exists($upload_path . 'edu6.jpg')) {
unlink("$upload_path_check/edu6.jpg");
unlink("$upload_path_check/edu6_thumb.jpg");
}
header("Location: themes.php?page=custom-homepage.php&resetall=true");
die;
}
}

add_theme_page(_g ('Services'),  _g ('Services Setting'),  'edit_themes', 'custom-homepage.php', 'edus_features_page');
}

add_action('admin_menu', 'edus_features_register');


 
?>