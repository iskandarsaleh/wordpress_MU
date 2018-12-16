<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php

// if comments are closed and is page then do nothing
if( !comments_open() && is_page() ) {

} else { ?>

<div id="comments">

	<h2><?php _e('Comments'); if ( comments_open() ) : ?><a href="#postComment" title="leave a comment">&raquo;</a><?php endif; ?></h2>

	<?php

	global $usePassword;
	
	if ( $usePassword ) { ?>
	
		<p>Enter your password to view comments</p>
		
 	<?php
 	
	} else if ( $comments ) {

		$commentCount = 1;

		?>

		<dl class="commentlist">

		<?php foreach ($comments as $comment) : 
		
			$class = bm_author_highlight();

		?>

			<dt id="comment-<?php comment_ID() ?>" class="<?php echo $class; ?>">
		
			<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;
			<a href="#comment-<?php comment_ID() ?>"><?php echo $commentCount."."; ?></a> <?php comment_author_link() ?> - <?php comment_date(); edit_comment_link( "[Edit]" ); ?>
			</dt>
			<dd class="<?php echo $class; ?>">

			<?php

			comment_text();

			$commentCount ++; ?>
			</dd>

		<?php endforeach; ?>

		</dl>

	<?php } else { // If there are no comments yet

		if ( comments_open() ) {

			echo "<p>no comments yet - be the first?</p>";
			
		} else {
		
			echo "<p>Sorry comments are closed for this entry</p>";

		}
		
	} ?>
	
</div>

	<?php if ( comments_open() && !$usePassword ) { ?>

<form action="<?php echo get_settings('home'); ?>/wp-comments-post.php" method="post" id="postComment">

	<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>" />

	<label for="comment">message</label><br /><textarea name="comment" id="comment" tabindex="1"></textarea>

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>

<?php else : ?>

	<label for="author"><?php _e('Name');?></label><input name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="2" />
	<label for="email">email</label><input name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="3" />
	<label for="url">url</label><input name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="4" />

<?php endif ; ?>
	<input class="button" name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('Say It!');?>" />
	<?php do_action('comment_form', $post->ID); ?>
</form>

<?php

		}
	}
	
?>
