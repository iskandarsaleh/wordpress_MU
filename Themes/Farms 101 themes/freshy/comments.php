<br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments',TEMPLATE_DOMAIN); ?><p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
		$gravatar_size= get_option('gravatar_options');
		$gravatar_size= $gravatar_size['gravatar_size'];
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?><?php __('No responses',TEMPLATE_DOMAIN); ?>
	<h3 id="comments"><?php comments_number(__('No responses',TEMPLATE_DOMAIN), __('One response',TEMPLATE_DOMAIN), __('% responses',TEMPLATE_DOMAIN));?> <?php _e('to',TEMPLATE_DOMAIN); ?> &#8220;<?php the_title(); ?>&#8221;</h3>

	<dl class="commentlist">

	<?php foreach ($comments as $comment) : ?>
		
	<?php
	$author_comment_class=' none';
	if($comment->comment_author_email == get_the_author_email()) $author_comment_class=' author_comment';

	?>
	
		<dt class="<?php echo $author_comment_class; ?>">
				<small class="date">
					<span class="date_day"><?php comment_time('j') ?></span>
					<span class="date_month"><?php comment_time('m') ?></span>
					<span class="date_year"><?php comment_time('Y') ?></span>
				</small>
		</dt>

		<dd class="commentlist_item <?php echo $oddcomment; echo $author_comment_class; ?>" id="comment-<?php comment_ID() ?>">			

			<div class="comment">
				<strong class="author" style="height:32px;line-height:32px;">
				
				
				<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author_link() ?></strong> <small>(<?php comment_time('H:i:s'); ?>)</small> : <?php edit_comment_link(__('edit',TEMPLATE_DOMAIN),'',''); ?>
				<?php if ($comment->comment_approved == '0') : ?>
				<small><?php _e('Your comment is awaiting moderation',TEMPLATE_DOMAIN); ?></small>
				<?php endif; ?>
				
				<br style="display:none;"/>
			
				<div class="comment_text">				
				<?php comment_text(); ?>
				</div>
			</div>
		</dd>


	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</dl>

<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond"><?php _e('Leave a comment',TEMPLATE_DOMAIN); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be',TEMPLATE_DOMAIN); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in',TEMPLATE_DOMAIN); ?></a> <?php _e('to post a comment',TEMPLATE_DOMAIN); ?></p>
<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as',TEMPLATE_DOMAIN); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><?php _e('Logout',TEMPLATE_DOMAIN); ?> &raquo;</a></p>

<?php else : ?>

<p>
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	<label for="author"><?php _e('Name',TEMPLATE_DOMAIN); ?> <?php if ($req) _e('(required)',TEMPLATE_DOMAIN); ?></label>
</p>
<p>
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	<label for="email"><?php _e('Mail',TEMPLATE_DOMAIN); ?> <?php _e('(will not be published)',TEMPLATE_DOMAIN); ?> <?php if ($req) _e('(required)',TEMPLATE_DOMAIN); ?></label>
</p>
<p>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><?php _e('Website',TEMPLATE_DOMAIN); ?></label>
</p>

<?php endif; ?>

<p><small><?php _e('You can use these tags',TEMPLATE_DOMAIN); ?> : <?php echo allowed_tags(); ?></small></p>

<p>
<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
</p>
<p>
<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit comment',TEMPLATE_DOMAIN); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
