<br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br />
<div class="comments">
	<div class="comments-nice-bg">
		<div class="comments-nice">

<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>

				<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.');?></p>

				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<?php if ($comments) : ?>
	<h3 class="reply"><?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?> <?php _e('to');?>  '<?php the_title(); ?>'</h3> 
<p class="comment_meta">Subscribe to comments with <?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr>')); ?> 
<?php if ( pings_open() ) : ?>
	or <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack');?></a> to '<?php the_title(); ?>'.
<?php endif; ?>
</p>
	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<div class="comment_author">
			<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;	<?php comment_author_link() ?> said,
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.');?></em>
			<?php endif; ?>
			<br />

			<p class="metadate"><?php _e('on');?> <?php comment_date('F jS, Y') ?> <?php _e('at');?> <?php comment_time() ?> <?php edit_comment_link(__('Edit'),' | ',''); ?></p>

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->

<div class="comments-nice-bg">
	<div class="comments-nice">
		<div class="postinput">

		<p class="nocomments"><?php _e('Comments are closed.');?><p>
		
	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

		
		
<h3 id="reply">Post a comment</h3>

<div class="postinput">



<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>



<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
	


<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>

<?php else : ?>

<p>
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name');?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)');?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url"><small><?php _e('Website');?></small></label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>

<p><input name="submit" type="image" id="submit" class="input-submit" tabindex="5" value="<?php _e('Submit Comment');?>" title="Please review your comment before submitting" alt="Post a comment" src="<?php bloginfo('template_url'); ?>/images/post-a-comment.png" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>




<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>




</div> <!-- /post-input -->
</div> <!-- /comments-nice -->
</div> <!-- /comments-nice-bg -->
	
	
</div> <!-- /comments -->