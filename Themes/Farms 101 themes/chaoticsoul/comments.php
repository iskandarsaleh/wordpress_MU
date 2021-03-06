<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>

				<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'chaoticsoul'); ?><p>

				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
<div class="comments">
	<h3><?php comments_number(__('No Responses', 'chaoticsoul'), __('One Response', 'chaoticsoul'), __('% Responses', 'chaoticsoul') );?> to &#8220;<?php the_title(); ?>&#8221;</h3> 

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<?php comment_text() ?>
			
			<p class="commentmetadata">
				<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?> 
				<small>
				<cite><?php comment_author_link() ?></cite> <?php _e('said this on', 'chaoticsoul'); ?>
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'chaoticsoul'); ?></em>
				<?php endif; ?>
				<a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date(get_option('date_format')) ?> <?php _e('at', 'chaoticsoul');?> <?php comment_time(get_option('time_format')) ?></a> <?php edit_comment_link(__('edit', 'chaoticsoul'),'(',')'); ?>
				</small>
			</p>
		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

</div>
<?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.', 'chaoticsoul'); ?></p>

	<?php endif; ?>

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>
<div class="comments clearfix">
	<h3 id="respond"><?php _e('Leave a Reply', 'chaoticsoul'); ?></h3>

	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'chaoticsoul'), get_option('siteurl').'/wp-login.php?redirect_to='.get_permalink()); ?></p>
	<?php else : ?>

	<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( $user_ID ) : ?>

	<p><?php printf(__('Logged in as %s.', 'chaoticsoul'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?>
	<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account', 'chaoticsoul'); ?>"><?php _e('Logout &raquo;', 'chaoticsoul'); ?></a></p>
	<p><textarea name="comment" id="comment" cols="65" rows="10" tabindex="4"></textarea></p>

	<?php else : ?>

	<p><textarea name="comment" id="comment" cols="65" rows="5" tabindex="4"></textarea></p>

	<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="20" tabindex="1" /><br />
	<label for="author"><small><?php if ($req) echo "*"; ?> <?php _e('Name', 'chaoticsoul'); ?></small></label></p>

	<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="20" tabindex="2" /><br />
	<label for="email"><small><?php if ($req) echo "*"; ?> <?php _e('Mail (private)', 'chaoticsoul'); ?></small></label></p>

	<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="19" tabindex="3" /><br />
	<label for="url"><small><?php _e('Website', 'chaoticsoul'); ?></small></label></p>

	<?php endif; ?>

	<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

	<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'chaoticsoul'); ?>" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</p>
	<?php do_action('comment_form', $post->ID); ?>

	</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
