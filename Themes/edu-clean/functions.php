<?php

////////////////////////////////////////////////////////////////////////////////
// wp 2.7 wp_list_comment
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
// Most Comments
////////////////////////////////////////////////////////////////////////////////

function gte_most_commented($limit = 8) {
    global $wpdb, $post;
    $mostcommenteds = $wpdb->get_results("SELECT  $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT $limit");
    foreach ($mostcommenteds as $post) {
			$post_title = htmlspecialchars(stripslashes($post->post_title));
			$comment_total = (int) $post->comment_total;
			echo "<li>$post_title<br /><em><a href=\"".get_permalink()."\">($comment_total) Comments - add yours too</a></em></li>";
    }
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
// wpmu global post - get all post from network blogs
////////////////////////////////////////////////////////////////////////////////

function wpmu_recent_blog_posts_mu($how_many=10, $how_long=40, $titleOnly=true, $begin_wrap="<li class='feat-img'>", $end_wrap="</li>") {
	global $wpdb;

    $post_counter = 0;

	// get a list of blogs in order of most recent update. show only public and nonarchived/spam/mature/deleted
	$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE
		public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' AND
		last_updated >= DATE_SUB(CURRENT_DATE(), INTERVAL $how_long DAY)
		ORDER BY last_updated DESC");

	if ($blogs) {



		// Should we make <ul> optional since this is a widget now?
		echo "<ul>";
		foreach ($blogs as $blog) {

			// we need _posts and _options tables for this to work
			$blogOptionsTable = "wp_".$blog."_options";
		    $blogPostsTable = "wp_".$blog."_posts";

			$options = $wpdb->get_results("SELECT option_value FROM
				$blogOptionsTable WHERE option_name IN ('siteurl','blogname')
				ORDER BY option_name DESC");

		        // we fetch the title and ID for the latest post

			$thispost = $wpdb->get_results("SELECT ID, post_date_gmt, post_title, post_author, post_content
				FROM $blogPostsTable WHERE post_status = 'publish'
				AND ID > 1
				AND post_type = 'post'
				AND post_date >= DATE_SUB(CURRENT_DATE(), INTERVAL $how_long DAY)
				ORDER BY id DESC LIMIT 0,1");


			// if it is found put it to the output
			if($thispost) {
			// get permalink by ID.  check wp-includes/wpmu-functions.php
			$thispermalink = get_blog_permalink($blog, $thispost[0]->ID);

			if ($titleOnly == false) {
			echo $begin_wrap.'<a href="'.$thispermalink
					.'">'.$thispost[0]->post_title.'</a> <br/> by <a href="'
					.$options[0]->option_value.'">'
					.$options[1]->option_value.'</a>'.$end_wrap;
					$post_counter++;

            // elseif
			} else {

            //modified the output
            $custom_this_post = $thispost[0]->post_content;
            $custom_this_post = strip_tags($custom_this_post);
            $custom_this_post = substr($custom_this_post,0,250);
            $custom_this_post = substr($custom_this_post,0,strrpos($custom_this_post,' '));
            $custom_this_post = $custom_this_post . "...";

            $custom_this_date = substr($thispost[0]->post_date_gmt,0,11);

						echo $begin_wrap.'<strong style="font-size: 14px; margin-bottom: 3px;"><a href="'.$thispermalink
						.'">'.$thispost[0]->post_title.'</a></strong><br />';

                        echo 'by <a href="' . $options[0]->option_value.'">' . $options[1]->option_value.'</a>' . ' on ' . $custom_this_date . '<br />';
                        echo '<p>' . $custom_this_post . '</p>';

                        echo $end_wrap;

						$post_counter++;
					}
			}
			// don't go over the limit
			if($post_counter >= $how_many) {
				break;
			}
		}
		echo "</ul>";
	}
}





////////////////////////////////////////////////////////////////////////////////
// Get Recent Comments With Avatar
////////////////////////////////////////////////////////////////////////////////
function get_avatar_recent_comment() {

global $wpdb;

$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,60) AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE comment_approved = '1' AND comment_type = '' AND
post_password = ''
ORDER BY comment_date_gmt DESC LIMIT 6";

$comments = $wpdb->get_results($sql);
$output = $pre_HTML;
$gravatar_status = 'on'; /* off if not using */

foreach ($comments as $comment) {

$email = $comment->comment_author_email;
$grav_name = $comment->comment_author_name;
$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($email). "&amp;size= 50";
?>

<li>
<?php if($gravatar_status == 'on') { ?>
<img class="alignleft" src="<?php echo $grav_url; ?>" alt="<?php echo $grav_namel ?>" /><br />
<?php } ?>
<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="on <?php echo $comment->post_title; ?>">
&quot;<?php echo strip_tags($comment->com_excerpt); ?>...&quot;
</a>
<br />
<small><strong><?php echo strip_tags($comment->comment_author); ?></strong> in <em><?php echo $comment->post_title; ?></em></small>
</li>
<?php
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
// get images
////////////////////////////////////////////////////////////////////////////////
function dez_get_images($the_post_id = '') {
global $wpdb;
$detect_post_id = $the_post_id;

$get_post_attachment = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$detect_post_id' AND post_type = 'attachment' ORDER BY menu_order ASC LIMIT 1");

if(!$get_post_attachment){
$img_dir = get_bloginfo('template_directory');
$dImgString = $img_dir . '/images/default.jpg';
echo $dImgString;
} else {
foreach($get_post_attachment as $attach) {
$attach_img = $attach->guid;
echo "$attach_img";
}
}
}
////////////////////////////////////////////////////////////////////////////////
// excerpt features
////////////////////////////////////////////////////////////////////////////////

function the_excerpt_feature($excerpt_length=20, $allowedtags='', $filter_type='none', $use_more_link=true, $more_link_text="", $force_more_link=false, $fakeit=1, $fix_tags=true) {
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



// below are widget custom to custom the widget looks without the default //


if ( function_exists('register_sidebar') ) {

register_sidebar(array('name'=> __('Home Side Left'),
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

register_sidebar(array('name'=> __('Home Side Right'),
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

register_sidebar(array('name'=> __('Sidebar'),
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));

}


///////////////////////////////////////////////////////////////
// multiple option page/////////////////////////////////////////
////////////////////////////////////////////////////////////////

function _g($str)
{
return __($str, 'option-page');
}




////////////////////////////////////////////////////////////////////////////////
// theme option menu for edublogs v3 - jUNE 2009
////////////////////////////////////////////////////////////////////////////////

$themename = "Edublogs v3";
$shortname = "tn";

$wp_dropdown_rd_admin = $wpdb->get_results("SELECT $wpdb->term_taxonomy.term_id,name,description,count FROM $wpdb->term_taxonomy LEFT JOIN $wpdb->terms ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id WHERE parent = 0 AND taxonomy = 'category' AND count != '0' GROUP BY $wpdb->terms.name ORDER by $wpdb->terms.name ASC");
$wp_getcat = array();
foreach ($wp_dropdown_rd_admin as $category_list) {
$wp_getcat[$category_list->term_id] = $category_list->name;
}
$category_bulk_list = array_unshift($wp_getcat, "Choose a category:");

$options = array (

array(
"name" => __("Blog General Settings"),
"type" => "heading",
),

array(
"name" => __("Choose your <strong>Home</strong> featured category"),
"id" => $shortname."_edus_sidebar_featured",
"inblock" => "post-config",
"type" => "select",
"std" => "Choose a category:",
"options" => $wp_getcat),


array(
"name" => __("Do you want to used author avatar in post"),
"id" => $shortname."_edus_author_avatar",
"inblock" => "post-config",
"std" => "yes",
"type" => "select",
"options" => array("yes", "no")),

array(
"name" => __("Do you want to show category in post"),
"id" => $shortname."_edus_post_cat",
"inblock" => "post-config",
"std" => "yes",
"type" => "select",
"options" => array("yes", "no")),


array("name" => __("Do you want to used social tools for post"),
"id" => $shortname."_edus_social",
"inblock" => "post-config",
"std" => "yes",
"type" => "select",
"options" => array("yes", "no")),


array(
"name" => "</div></div>",
"type" => "close",
),


array(
"name" => __("Blog Header Settings"),
"type" => "heading",
),

array(
"name" => __("Insert your logo full url here<br /><em>*you can upload your logo in <a href='media-new.php'>media panel</a> and copy paste the url here</em>"),
"id" => $shortname."_edus_header_logo",
"type" => "text",
"std" => "",
),


array(
"name" => __("Insert your top header main text"),
"id" => $shortname."_edus_header_text",
"type" => "text",
"std" => "Your WordPress MU Header Title Will Be Here",
),

array(
"name" => __("Insert your top header featured listing&nbsp;&nbsp;&nbsp;<em>HTML alllowed</em>"),
"id" => $shortname."_edus_header_listing",
"type" => "textarea",
"std" => "<ul>
<li>Effortlessly create and manage blogs</li>
<li>Packed with useful features and customizable themes</li>
<li>Ready made for podcasting, videos, photos and more</li>
<li>Step by step support with our helpful video tutorials</li>
</ul>",
),


array(
"name" => "</div></div>",
"type" => "close",
),



array(
"name" => __("Blog Typography CSS Settings"),
"type" => "heading",
),


array(	"name" => __("Choose your body font"),
			"id" => $shortname . "_edus_body_font",
            "type" => "select",
            "std" => "Arial, sans-serif",
			"options" => array(
            "Arial, sans-serif",
            "Helvetica, Arial, sans-serif",
            "Helvetica LT Light, Helvetica, Arial",
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



array(	"name" => __("Choose your headline font"),
			"id" => $shortname . "_edus_headline_font",
            "type" => "select",
            "std" => "Arial, sans-serif",
			"options" => array(
            "Arial, sans-serif",
            "Helvetica, Arial, sans-serif",
            "Helvetica LT Light, Helvetica, Arial",
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


   array(	"name" => __("Choose your font size"),
			"id" => $shortname."_edus_font_size",
			"type" => "select",
            "std" => "normal",
			"options" => array("normal","small", "bigger", "largest")),






array(
"name" => "</div></div>",
"type" => "close",
),



array(
"name" => __("Blog CSS Colour Settings"),
"type" => "heading",
),

  array (	"name" => __("Choose your priority background color?<br /><em>this will effect main-header, footer, login-panel and sidebar-header color</em>"),
			"id" => $shortname . "_edus_pri_bg_colour",
            "std" => "",
			"type" => "colourpicker"),


  array (	"name" => __("Choose your priority border color?"),
			"id" => $shortname . "_edus_pri_bg_border_colour",
            "std" => "",
			"type" => "colourpicker"),

  array (	"name" => __("Choose your priority text color?"),
			"id" => $shortname . "_edus_pri_text_colour",
            "std" => "",
			"type" => "colourpicker"),


  array (	"name" => __("<div class='inline'></div>Choose your global links color?"),
			"id" => $shortname . "_edus_link_colour",
            "std" => "",
			"type" => "colourpicker"),




array(
"name" => "</div></div>",
"type" => "close",
),




array(
"name" => __("Tabbed RSS Feeds CSS Settings"),
"type" => "heading",
),

  array (	"name" => __("Choose your tab background color"),
			"id" => $shortname . "_edus_tab_bg_colour",
            "std" => "",
			"type" => "colourpicker"),


  array (	"name" => __("Choose your tab border color?"),
			"id" => $shortname . "_edus_tab_border_colour",
            "std" => "",
			"type" => "colourpicker"),

  array (	"name" => __("Choose your tab text color?"),
			"id" => $shortname . "_edus_tab_text_colour",
            "std" => "",
			"type" => "colourpicker"),


  array (	"name" => __("Choose your tab links color?"),
			"id" => $shortname . "_edus_tab_link_colour",
            "std" => "",
			"type" => "colourpicker"),




array(
"name" => "</div></div>",
"type" => "close",
),


/* rss feed options */


array(
"name" => __("Tabbed RSS Feeds Settings"),
"type" => "heading",
),




    array(	"name" => __("<span class=\"important-stuff\">Do you want to used the rss feeds network? *if this disable then below config will not activate</span>"),
			"id" => $shortname."_edus_rss_network_status",
            "inblock" => "netrss",
            "std" => "no",
			"type" => "select",
            "options" => array("no", "yes")),

    array(	"name" => __("How many word count to pull from your feeds?"),
			"id" => $shortname."_edus_feed_word",
            "inblock" => "netrss",
            "std" => "150",
			"type" => "text"),

/* if yes then here we go */

    array(	"name" => __("<div class='inline'></div><strong>Do you want to use the first rss network feed block?</strong>"),
			"id" => $shortname."_edus_feedone_status",
            "inblock" => "netrss",
            "std" => "no",
			"type" => "select",
            "options" => array("no", "yes")),

    array(	"name" => __("Insert your first network or sitename here"),
			"id" => $shortname."_edus_network_one",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the first site rss feeds url here"),
			"id" => $shortname."_edus_network_one_url",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
			"id" => $shortname."_edus_network_one_sum",
            "inblock" => "netrss",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),

    array(	"name" => __("<div class='inline'></div><strong>Do you want to use the second rss network feed block?</strong>"),
			"id" => $shortname."_edus_feedtwo_status",
            "inblock" => "netrss",
            "std" => "no",
			"type" => "select",
            "options" => array("no", "yes")),

   array(	"name" => __("Insert your second network or sitename here"),
			"id" => $shortname."_edus_network_two",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the second site rss feeds url here"),
			"id" => $shortname."_edus_network_two_url",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("How many post feeds to show?"),
			"id" => $shortname."_edus_network_two_sum",
            "inblock" => "netrss",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),

    array(	"name" => __("<div class='inline'></div><strong>Do you want to use the third rss network feed block?</strong>"),
			"id" => $shortname."_edus_feedthree_status",
            "inblock" => "netrss",
            "std" => "no",
			"type" => "select",
            "options" => array("no", "yes")),


   array(	"name" => __("Insert your third network or sitename here"),
			"id" => $shortname."_edus_network_three",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the third site rss feeds url here"),
			"id" => $shortname."_edus_network_three_url",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),


    array(	"name" => __("How many post feeds to show?"),
			"id" => $shortname."_edus_network_three_sum",
            "inblock" => "netrss",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),

    array(	"name" => __("<div class='inline'></div><strong>Do you want to use the fourth rss network feed block?</strong>"),
			"id" => $shortname."_edus_feedfour_status",
            "inblock" => "netrss",
            "std" => "no",
			"type" => "select",
            "options" => array("no", "yes")),

    array(	"name" => __("Insert your fourth network or sitename here"),
			"id" => $shortname."_edus_network_four",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("Insert the fourth site rss feeds url here"),
			"id" => $shortname."_edus_network_four_url",
            "inblock" => "netrss",
            "std" => "",
			"type" => "text"),

    array(	"name" => __("How many post feeds to show?"),
			"id" => $shortname."_edus_network_four_sum",
            "inblock" => "netrss",
       		"type" => "select",
            "std" => "3",
			"options" => array("3", "4", "5", "6", "7", "8", "9", "10")),


array(
"name" => "</div></div>",
"type" => "close",
),





);


function mytheme_edus_admin() {

echo "<div id=\"admin-options\">";

global $themename, $shortname, $options;
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>



<h4><?php echo "$themename"; ?> <?php _e('Theme Options'); ?></h4>

<form action="" method="post">

<?php foreach ($options as $value) { ?>

<?php

switch ( $value['type'] ) {

case 'heading':

?>

<div class="get-option">

<h2><?php echo $value['name']; ?></h2>

<div class="option-save">


<?php
break;
case 'colourpicker':
?>

<div class="description"><?php echo $value['name']; ?></div>
<?php $i == $i++ ; ?>
<p>
<input class="color {required:false,hash:true}" name="<?php echo $value['id']; ?>" id="colorpickerField<?php echo $i; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
 </p>


<?php
break;
case 'text':
?>


<div class="description"><?php echo $value['name']; ?></div>
<p><input name="<?php echo $value['id']; ?>" class="myfield" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></p>


<?php
break;
case 'select':
?>


<div class="description"><?php echo $value['name']; ?></div>
<p><select name="<?php echo $value['id']; ?>" class="myselect" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
<?php } ?>
</select>
</p>



<?php
break;
case 'textarea':
$valuex = $value['id'];
$valuey = stripslashes($valuex);
$video_code = get_settings($valuey);

?>



<div class="description"><?php echo $value['name']; ?></div>
<p><textarea name="<?php echo $valuey; ?>" class="mytext" cols="40%" rows="8" /><?php if ( get_settings($valuey) != "") { echo stripslashes($video_code); } else { echo $value['std']; } ?></textarea></p>



<?php

break;

case 'close':

?>



</div></div>



<?php

break;

default;

?>



<?php

break; } ?>


<?php } ?>



<p class="save-p">
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

function mytheme_add_edus_admin() {
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
add_theme_page(_g ('EduClean Options'),  _g ('Theme Options'),  'edit_themes', basename(__FILE__), 'mytheme_edus_admin');
}

////////////////////////////////////////////////////////////////////////////////
// add theme cms pages
////////////////////////////////////////////////////////////////////////////////

function mytheme_wp_edus_head() { ?>
<link href="<?php bloginfo('template_directory'); ?>/admin/edus-admin.css" rel="stylesheet" type="text/css" />


<?php if(($_GET["page"] == "custom-homepage.php") || ($_GET["page"] == "functions.php")) { ?>


<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jscolor.js"></script>


<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.imgareaselect-0.3.min.js"></script>


<?php } ?>

<?php }


add_action('admin_head', 'mytheme_wp_edus_head');
add_action('admin_menu', 'mytheme_add_edus_admin');



$includes_path = TEMPLATEPATH . '/';
require_once ($includes_path . 'services.php');

?>