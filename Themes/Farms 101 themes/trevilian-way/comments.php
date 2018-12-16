<br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.');?><p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
	/* This variable is for comment numbering */
	$c_comment_number = 1;
	/* This variable is for alternate author styling */
	$blog_author_email_password = 'email@password.com';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

	<h4 id="comment-section-title"><?php comments_number(__('No Discussion Yet'), __('One Response'), __('% Responses'));?></h4>
	<p class="post-comments-rss"><?php _e('You can follow the comments for this article with the');?> <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed');?>.</p>
	
	<?php foreach ($comments as $comment) : ?>
		
		<div class="comment-body <?php echo $oddcomment; ?>">	
		
			<?php if ($comment->comment_approved == '0') : ?>
				<p><strong><?php _e('Your comment is awaiting moderation.');?></strong></p>
			<?php endif; ?>
			
			<?php comment_text() ?>
			
			<?php edit_comment_link('e','',''); ?>
			
		</div>
		<div class="comment-meta <?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
		
			<span class="comment-number"><?php echo $c_comment_number; ?></span>
			<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;

<cite><?php comment_author_link() ?></cite>
			<span class="comment-date"><?php comment_date('F d, Y') ?></span>
			<span class="comment-time"><?php comment_time() ?></span>
			
		</div>
		<span class="clearer"></span>
		
		<?php /* Changes every other comment to a different class */
			if ('alt' == $oddcomment) $oddcomment = '';
			else $oddcomment = 'alt';
		?>
		<?php ++$c_comment_number; //Increases the comment number by one. ?>

	<?php endforeach; ?>	

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p>Comments are closed.</p>

	<?php endif; ?>
	
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id="commentform-area">

<h4><?php _e('Leave a Reply');?></h4>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( $user_ID ) : ?>

	<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account');?>"><?php _e('Logout');?> &raquo;</a></p>

	<?php else : ?>
	
	<fieldset id="cf-identifiers">
	
		<div class="input-container">
			<label for="cf-name">Name*</label>
			<input id="cf-name" type="text" name="author" title="Name" value="<?php echo $comment_author; ?>" tabindex="1" />
		</div>
		
		<div class="input-container">
			<label for="cf-email">Email* (not published)</label>
			<input id="cf-email" type="text" name="email" title="Email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
		</div>
		
		<div class="input-container">
			<label for="cf-url"><?php _e('Website');?></label>
			<input id="cf-url" type="text" name="url" title="URL" value="<?php echo $comment_author_url; ?>" tabindex="3" />
		</div>
		
	</fieldset>

	<?php endif; ?>

	<fieldset id="cf-content-submit">
	
		<textarea id="comment" name="comment" cols="50" rows="10" tabindex="4"></textarea>
		<p class="post-comments-instructions">Required fields are marked with an asterisk (*), you may use these tags in your comment: <code><?php echo allowed_tags(); ?></code></p>
		<input id="submit" name="submit" type="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		
	</fieldset>
	
	<?php do_action('comment_form', $post->ID); ?>

</form>

</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
