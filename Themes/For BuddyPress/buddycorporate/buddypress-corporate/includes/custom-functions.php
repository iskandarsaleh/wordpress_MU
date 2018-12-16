<?php

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
// excerpt features
////////////////////////////////////////////////////////////////////////////////

function the_excerpt_feature($excerpt_length=150, $allowedtags='', $filter_type='none', $use_more_link=true, $more_link_text="...Click here to read more &raquo;", $force_more_link=true, $fakeit=1, $fix_tags=true) {
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




?>