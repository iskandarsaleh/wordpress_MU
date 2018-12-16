<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
	<p><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
<?php
		return;
	}
}

/* This variable is for alternating comment background */
$oddcomment = 'alt';

?>

<?php if ($comments) : ?>
<div id="comments" class="commentlist">
<?php if ('open' == $post->comment_status) : ?>

	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments'));?></h2>
		<p class="comments-feed"><?php comments_rss_link('Comments feed for this article'); ?></p>
	</div>

<?php else : // comments are closed ?>

	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments'));?></h2>
	</div>

<?php endif; ?>










<?php foreach ($comments as $comment) : ?>
	<?php if ($comment->comment_approved == '0') : ?>
		<p>Your comment is awaiting moderation.</p>
	<?php endif; ?>
	
	<div class="comment<?php /* Style differently if comment author is blog author */ if ($comment->comment_author_email == get_the_author_email()) { echo ' author-comment'; } ?>" id="comment-<?php comment_ID() ?>">
		<div class="comment-metadata">
			<p class="comment-permalink"><a href="#comment-<?php comment_ID() ?>" title="Permalink to this comment"><?php comment_date('F jS, Y') ?> <?php _e('at'); ?> <?php comment_time() ?></a></p>
			<p class="comment-author"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;

<strong><?php comment_author_link(); ?></strong></p>
			<?php edit_comment_link(__('Edit'), '<p class="comment-permalink">(', ')</p>'); ?> 
		</div>
		
		<div class="comment-content">
			
			<?php comment_text() ?>
		</div>
	</div>
<?php endforeach; /* end for each comment */ ?>






</div>
<?php else : // this is displayed if there are no comments so far ?>

<?php if ('open' == $post->comment_status) : ?>
<div id="comments">
	<div id="comments-meta">
		<h2 class="comments-title"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments'));?></h2>
		<p class="comments-feed"><a title="Subscribe to this article&#8217;s comments feed" href="<?php the_permalink() ?>feed/"><?php _e('Comments feed for this article'); ?></a></p>
	</div>
</div>
<?php else : // comments are closed ?>

<?php endif; ?>

<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div id="respond">

<?php // if registration is mandatory
	if ( get_option('comment_registration') && !$user_ID ) : ?>

		<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
	</div>
<?php else : ?>

		<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform"><fieldset>

<?php // if user is logged in
	if ( $user_ID ) : ?>

		<div id="info-input">
			<p class="userinfo">You are <?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.</p>
			<p><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>
			<?php if(function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
		</div>

<?php // if user is not logged in - name, email and website fields
	else : ?>

			<div id="info-input">
				<label for="author">Name<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></label>
				<label for="email">Email<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /></label>
				<label for="url">Website<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></label>
				<?php if(function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
			</div>


<?php // actual comment form
endif; ?>
			<div id="comment-input">
				<label for="comment"><?php _e('Your Comment');?></label>
				<textarea name="comment" id="comment" cols="60" rows="12" tabindex="4"></textarea>
				<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
				<?php if (function_exists('live_preview')) { live_preview(); } ?>
				<?php @include('constants.php'); echo $commentsFormInclude; ?>
			</div>
<?php do_action('comment_form', $post->ID); ?>
		</fieldset></form>
	</div>

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head / O RLY / YA RLY ?>
