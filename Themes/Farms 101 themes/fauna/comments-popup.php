<?php 
/* Don't remove these lines. */
add_filter('comment_text', 'popuplinks');
foreach ($posts as $post) { start_wp();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/1">

     <title><?php echo get_settings('blogname'); ?> | <?php echo sprintf(__("Comments on %s"), the_title('','',false)); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo get_settings('blog_charset'); ?>" />

	<!-- Stylesheet -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" title="Fauna" href="<?php bloginfo('stylesheet_directory'); ?>/fauna-default.css" />
	
	<!-- JavaScripts -->
	<script language="javascript" type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/meta/scripts.js"></script>
</head>

<body id="commentspopup">

<?php
// this line is WordPress' motor, do not delete it.
$comment_author = (isset($_COOKIE['comment_author_' . COOKIEHASH])) ? trim($_COOKIE['comment_author_'. COOKIEHASH]) : '';
$comment_author_email = (isset($_COOKIE['comment_author_email_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_email_'. COOKIEHASH]) : '';
$comment_author_url = (isset($_COOKIE['comment_author_url_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_url_'. COOKIEHASH]) : '';
$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $id AND comment_approved = '1' ORDER BY comment_date");
$commentstatus = $wpdb->get_row("SELECT comment_status, post_password FROM $wpdb->posts WHERE ID = $id");
if (!empty($commentstatus->post_password) && $_COOKIE['wp-postpass_'. COOKIEHASH] != $commentstatus->post_password) {  // and it doesn't match the cookie
	echo(get_the_password_form());
} else { ?>

<div class="box">
	<h2><?php echo sprintf(__("Comments on %s"), the_title('','',false)); ?></h2>

	<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
		// Both Comments and Pings are open ?>

		<p><?php _e('There are');?> <?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?>.</p>
		<p>&darr; <a href="#comments">Read comments</a>, <a href="#respond">respond</a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
		<?php if (function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); }; ?>

		<span id="trackback">
			<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
		</span>
		<span id="trackback-hidden" style="display: none;">
			<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
			<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
		</span>
	<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
		// Only Pings are Open ?>

		<span id="trackback">
			<a href="<?php trackback_url(display) ?>" onclick="show('trackback');return false;" title="Trackback URI to this entry" rel="nofollow">Trackback</a> this entry.
		</span>
		<span id="trackback-hidden" style="display: none;">
			<input name="textfield" type="text" value="<?php trackback_url() ?>" class="inputbox" onclick="select();" />
			<input name="hide" type="button" id="hide" value="Hide" onclick="hide('trackback');return false;" />
		</span>
	<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
		// Comments are open, Pings are not ?>

		<p><?php _e('There are');?> <?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?>.</p>
		<p>&darr; <a href="#comments"><?php _e('Jump to Comments');?></a> or follow responses via <?php comments_rss_link(__("XML")); ?>.</p>
		<?php show_manual_subscription_form(); ?>
	<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
		// Neither Comments, nor Pings are open ?>
	<?php } ?>
	<? /* END Post Status */ ?>

</div>

<?php if ( $comments ) : ?>
<div class="box">

	<?php include (TEMPLATEPATH . '/template-trackbacks.php'); ?>
	
	<?php include (TEMPLATEPATH . '/template-comments.php'); ?>

<?php else : // If there are no comments yet ?>

	<?php if ( comments_open() ) { ?><div class="box"><? } ?>
	<?php /* <p><?php _e('No comments yet.'); ?></p> */ ?>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<?php include (TEMPLATEPATH . '/template-commentform.php'); ?>

<?php else : // Comments are closed ?>
<? /* <p><?php _e('Comments are not allowed at this time.'); ?></p> */ ?>
<?php endif; ?>

<? } ?>
<? } ?>

<?php // Seen at http://www.mijnkopthee.nl/log2/archive/2003/05/28/esc(18) ?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {	
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>

</body>
</html>