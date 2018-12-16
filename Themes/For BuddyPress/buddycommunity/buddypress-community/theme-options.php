<?php


require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');


/* only in member theme for calling functions.php
define( 'ABSPATH', dirname(__FILE__) . '/' );
$current_theme = get_current_theme();
$site_directory = ABSPATH . '/';
require_once($site_directory . 'wp-content/themes/' . $current_theme . '/functions.php');
*/

header("Content-type: text/css");



global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
// wp theme option
?>



body {
font-family: <?php echo $tn_buddycom_body_font; ?>!important;
background: <?php if($tn_buddycom_bg_color == ""){ ?><?php echo "#E4E4E4"; } else { ?><?php echo $tn_buddycom_bg_color; ?><?php } ?><?php if($tn_buddycom_bg_image == "") { ?><?php } else { ?> url(<?php echo $tn_buddycom_bg_image; ?>)<?php } ?> <?php echo $tn_buddycom_bg_image_repeat; ?> <?php echo $tn_buddycom_bg_image_attachment; ?> <?php echo $tn_buddycom_bg_image_horizontal; ?> <?php echo $tn_buddycom_bg_image_vertical; ?>
!important;
}

ul.pagenav li.selected a, ul.pagenav li a:hover {
background: <?php echo $tn_buddycom_global_links; ?>!important;
}

ul.wpnv li a:hover {
color: <?php echo $tn_buddycom_global_links; ?>!important;
}

#sidebar, #sidebar h2, #sidebar h2 a, #sidebar .bpside .time-since {
color: <?php echo $tn_buddycom_sidebar_text_color; ?>!important;
}

<?php if($tn_buddycom_sidebar_text_links_color == "") { ?>
<?php } else { ?>
#sidebar .bpside h2 {
border-bottom: 2px solid <?php echo $tn_buddycom_sidebar_text_links_color; ?>!important;
}
<?php } ?>

#sidebar a, #sidebar .textwidget a, #sidebar .widget_tag_cloud a  {
color: <?php echo $tn_buddycom_sidebar_text_links_color; ?>!important;
}

#sidebar .bpside blockquote {
background: <?php echo $tn_buddycom_sidebar_border_color; ?>!important;
border: none 0px!important;
}

#sidebar ul#bp-nav, #sidebar ul#options-nav  {
background: <?php echo $tn_buddycom_sidebar_memberbar_color; ?>!important;
}



<?php if($tn_buddycom_footer_text_color == "") { ?>
<?php } else { ?>
#footer {
color: <?php echo $tn_buddycom_footer_text_color; ?>!important;
}
<?php } ?>


<?php if($tn_buddycom_footer_text_link_color == "") { ?>
<?php } else { ?>
#footer a {
color: <?php echo $tn_buddycom_footer_text_link_color; ?>!important;
}
#footer a:hover {
color: <?php echo $tn_buddycom_footer_text_link_color; ?>!important;
text-decoration: underline!important;
}
<?php } ?>


<?php if($tn_buddycom_sidebar_text_color == "") { ?>
<?php } else { ?>
#sidebar {
color: <?php echo $tn_buddycom_sidebar_text_color; ?>!important;
}
<?php } ?>



<?php if($tn_buddycom_sidebar_header_color == "") { ?>
<?php } else { ?>
#sidebar h2.widgettitle {
color: <?php echo $tn_buddycom_sidebar_header_color; ?>!important;
}
<?php } ?>



<?php if($tn_buddycom_sidebar_userbar_li_color == "") { ?>
<?php } else { ?>
ul#options-nav li a, ul#bp-nav li a {
color: <?php echo $tn_buddycom_sidebar_userbar_li_color; ?>!important;
}
<?php } ?>


<?php if($tn_buddycom_member_header_text_color == "") { ?>
<?php } else { ?>
#member-content h4 {
color: <?php echo $tn_buddycom_member_header_text_color; ?>!important;
}
<?php } ?>



#sidebar li.current a {
color: <?php echo $tn_buddycom_sidebar_userbar_link_color; ?>!important;
}

ul#options-nav li.current a  {
background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/options.png) no-repeat 8px center;
}



ul#bp-nav .current #my-activity  {
background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/activity-bullet.png) no-repeat 8px center;
}

ul#bp-nav .current #my-profile {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/profile-bullet.png) no-repeat 8px center;
}

ul#bp-nav .current #my-blogs {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/blog-bullet.png) no-repeat 8px center;
}

ul#bp-nav .current #my-wire {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/wire-bullet.png) no-repeat 8px center;
}


ul#bp-nav .current #my-messages {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/message-bullet.png) no-repeat 8px center;
}

ul#bp-nav .current #my-friends {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/friend-bullet.png) no-repeat 8px center;
}



ul#bp-nav .current #my-groups {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/group-bullet.png) no-repeat 8px center;
}

ul#bp-nav .current #my-settings {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/setting-bullet.png) no-repeat 8px center;
}


ul#bp-nav .current #wp-logout {
	background: <?php echo $tn_buddycom_sidebar_userbar_current_color; ?> url(images/members/logout-bullet.png) no-repeat 8px center;
}





<?php if($tn_buddycom_sidebar_memberbar_border_color == '') { ?>
<?php } else { ?>
#sidebar ul#bp-nav li a, #sidebar ul#options-nav li a {
border-bottom: 1px solid <?php echo $tn_buddycom_sidebar_memberbar_border_color; ?>!important;
}
<?php } ?>


#post-entry .bpside blockquote, #member-content blockquote {
background: <?php echo $tn_buddycom_post_meta_color; ?>!important;
border: none 0px!important;
}


<?php if($tn_buddycom_global_links == '') { ?>
<?php } else { ?>
#member-content li a, #member-content #activity-rss p a, #member-content form a, #main-column a, .bpside li a, #post-entry .textwidget a, #post-entry div.widget_tag_cloud a, .message-box a, .item-options a, .post-content a, h1 a, .post-author a, p.tags a, #post-navigator-single a, table a, .group-button a, .generic-button a {
color: <?php echo $tn_buddycom_global_links; ?>!important;
}


#commentpost a, #cf a, #respond a {
color: <?php echo $tn_buddycom_global_links; ?>;
}
<?php } ?>


div.create-account a, #rss-com p a, #rss-com p a:hover, ul#letter-list li a, ul.content-header-nav li a, div.reply a, .content-header-nav .current a {
background: <?php echo $tn_buddycom_global_links; ?>!important;
}

#searchbox {
background: <?php echo $tn_buddycom_searchbox_color; ?>!important;
<?php if($tn_buddycom_searchbox_bottom_border_color == '') { ?>
border-bottom: 2px solid <?php echo $tn_buddycom_searchbox_color; ?>!important;
<?php } else { ?>
border-bottom: 2px solid <?php echo $tn_buddycom_searchbox_bottom_border_color; ?>!important;
<?php } ?>
}

#header, #meprofile, #optionsbar h3, #optionsbar p.avatar {
background: <?php echo $tn_buddycom_header_color; ?>!important;
<?php if($tn_buddycom_header_bottom_border_color == '') { ?>
border-bottom: 10px solid <?php echo $tn_buddycom_header_color; ?>!important;
<?php } else { ?>
border-bottom: 10px solid <?php echo $tn_buddycom_header_bottom_border_color; ?>!important;
<?php } ?>
}

#header #intro-text h2, #header #intro-text span, #header a, div#meprofile, div#optionsbar h3  {
color: <?php echo $tn_buddycom_header_text_color; ?>!important;
}

#footer {
background: <?php echo $tn_buddycom_footer_color; ?>!important;
<?php if($tn_buddycom_footer_bottom_border_color == '') { ?>
<?php } else { ?>
border-bottom: 10px solid <?php echo $tn_buddycom_footer_bottom_border_color; ?>!important;
<?php } ?>
}

<?php if($tn_buddycom_global_links == '') { ?>
<?php } else { ?>
#post-entry .bpside h2 {
border-bottom: 3px solid <?php echo $tn_buddycom_global_links; ?>!important;
}
<?php } ?>


#sidebar {
background: <?php echo $tn_buddycom_sidebar_color; ?>!important;

<?php if($tn_buddycom_sidebar_border_color == '') { ?>
<?php } else { ?>
border-left: 5px solid <?php echo $tn_buddycom_sidebar_border_color; ?>!important;
<?php } ?>
}


#post-entry .bpside .item-meta {
background: <?php echo $tn_buddycom_post_meta_color; ?>!important;
}

#sidebar .bpside .item-meta {
background: <?php echo $tn_buddycom_sidebar_meta_color; ?>!important;
}

.post-tagged p.com a {
border: 1px solid <?php echo $tn_buddycom_post_meta_color; ?>!important;
}

.post-tagged p.com a:hover {
border: 1px solid <?php echo $tn_buddycom_sidebar_meta_color; ?>!important;
}

#post-navigator .current {
border: 1px solid <?php echo $tn_buddycom_global_links; ?>!important;
}


.wp-pagenavi .pages, #post-navigator a, #post-navigator a:hover {
border: 1px solid <?php echo $tn_buddycom_global_links; ?>!important;
}



#member-content h4 {
background: <?php echo $tn_buddycom_member_header_color; ?>!important;
border-bottom: 5px solid <?php echo $tn_buddycom_member_header_bottom_line_color; ?>!important;
}

#member-content h4 a, ul#letter-list li a, #member-content ul.content-header-nav li a {
color: <?php echo $tn_buddycom_member_header_links_color; ?>!important;
}

#signup-button a, div.create-account a {
background: <?php echo $tn_buddycom_member_header_color; ?>!important;
color: #FFF!important;
}
