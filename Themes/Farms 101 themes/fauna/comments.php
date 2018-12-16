<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php
				return;
            }
        }
?>

<!-- You can start editing here. -->

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
<?php if ( $comments ) { ?></div><!--//.box--><?php } ?>
<?php endif; ?>