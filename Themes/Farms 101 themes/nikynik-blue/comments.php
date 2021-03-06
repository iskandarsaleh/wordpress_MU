<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','nikynik'); ?><p>
				<?php
				return;
            }
        }
		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

	<h3 id="comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments'));?> </h3> 
	<ol class="commentlist">
	<?php foreach ($comments as $comment) : ?>
		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>"> 
		   <div class="gravatar"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?></div><cite><?php comment_author_link() ?></cite> <?php _e('Says:','nikynik') ?>
<?php if ($comment->comment_approved == '0') : ?>

			<em><?php _e('Your comment is awaiting moderation.','nikynik'); ?></em>

			<?php endif; ?>

			<br />



			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date(__('l, F jS, Y','nikynik')) ?> @ <?php comment_time() ?></a> <?php edit_comment_link(__('Edit','nikynik'),'',''); ?></small>



			<?php comment_text() ?>



		</li>



	<?php /* Changes every other comment to a different class */	

		if ('alt' == $oddcomment) $oddcomment = 'alt';

		else $oddcomment = 'alt';

	?>
<?php endforeach; /* end for each comment */ ?>



	</ol>



 <?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post-> comment_status) : ?> 

		<!-- If comments are open, but there are no comments. -->

		

	 <?php else : // comments are closed ?>

		<!-- If comments are closed. -->

		<p class="nocomments"><?php _e('Sorry, the comment form is closed at this time.','nikynik'); ?></p>

		

	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post-> comment_status) : ?>



<h3 id="respond"><?php _e("Leave a reply",'nikynik'); ?></h3>



<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p><?php _e('You must be','nikynik'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','nikynik'); ?></a> <?php _e('to post a comment.','nikynik'); ?></p>

<?php else : ?>



<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">



<?php if ( $user_ID ) : ?>



<p><?php _e('Logged in as','nikynik'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','nikynik') ?>"><?php _e('Logout &raquo;','nikynik'); ?></a></p>



<?php else : ?>



<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />

<label for="author"><small><?php _e('Name','nikynik'); ?>
<?php if ($req) _e('(required)','nikynik'); ?></small></label></p>



<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />

<label for="email"><small><?php _e('Mail (will not be published)','nikynik'); ?>
<?php if ($req) _e('(required)','nikynik'); ?></small></label></p>



<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />

<label for="url"><small><?php _e('Website','nikynik'); ?></small></label></p>



<?php endif; ?>



<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>-->



<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>



<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','nikynik'); ?>" />

<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />

</p>

<?php do_action('comment_form', $post->ID); ?>



</form>



<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>