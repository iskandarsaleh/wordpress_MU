<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<?php if ( $comments ) : ?>
<h4 id="comments"><?php _e('Comments so far:');?></h4>
<div id="commentlist">

<?php foreach ($comments as $comment) : 
	if (function_exists('gravatar')) { 
		if ('' != get_comment_author_url()) {
	  		echo "<a href='$comment->comment_author_url' title='Visit $comment->comment_author'>";
		} else { 
	  		echo "<a href='http://www.gravatar.com' title='Create your own gravatar at gravatar.com!'>";
		}
	echo "<img src='";
	if ('' == $comment->comment_type) {
		echo gravatar($comment->comment_author_email);
	} elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
		echo gravatar($comment->comment_author_url);
	}
	echo "' alt='' class='gravatar' width='80' height='80' /></a>";
	} ?>
	<div class="commentbox">
		
		<p class="commentinfo"> <a href="#comment-<?php comment_ID() ?>" title=""><?php _e('Link Here');?></a> | <?php comment_date() ?>, <?php get_comment_time(); ?></p>
		<?php comment_text() ?>

<p class="commentby" id="comment-<?php comment_ID() ?>"><?php if ('' != get_comment_author_url()) { ?><a href="<?php comment_author_url(); ?>" title="<?php _e('Visit');?> <?php comment_author() ?>"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author() ?></a> | <?php edit_comment_link(__("Edit This"), ' |'); ?>
		<?php } else { comment_author(); } ?>
</p>
	</div>
<br/>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?> 
<?php endif; ?>
<?php if ( pings_open() ) : ?>
	<br /><a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack');?> <abbr title="<?php _e('Uniform Resource Identifier');?>">URI</abbr></a>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<h2 id="postcomment"><?php _e('Share your thoughts'); ?></h2>

<p><?php _e("Line and paragraph breaks automatic, e-mail address never displayed, <acronym title=\"Hypertext Markup Language\">HTML</acronym> allowed:"); ?></p>
<code><?php echo allowed_tags(); ?></code>

<form action="<?php echo get_settings('home'); ?>/wp-comments-post.php" method="post" id="commentform">
	<p>
	  <input type="text" name="author" id="textbox" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
	   <label for="author"><?php _e('Name'); ?></label> <?php if ($req) _e('(required)'); ?>
	<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo wp_specialchars($_SERVER['REQUEST_URI']); ?>" />
	</p>

	<p>
	  <input type="text" name="email" id="textbox" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
	   <label for="email"><?php _e('E-mail'); ?></label> <?php if ($req) _e('(required)'); ?>
	</p>

	<p>
	  <input type="text" name="url" id="textbox" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />
	   <label for="url"><acronym title="<?php _e('Uniform Resource Identifier');?>">URI</acronym>'</label>
	</p>

	<p>
	  <label for="comment"><?php _e('Your Comment'); ?></label>
	<br />
	  <textarea name="comment" id="textbox" cols="60" rows="8" tabindex="4"></textarea>
	</p>

	<p>
	  <input id="searchbutton" name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('Say It!');?>" />
	</p>
	<?php do_action('comment_form', $post->ID); ?>
</form>
<?php _e('Sign up at');?> <a href="http://www.gravatar.com">Gravatar.com</a> <?php _e('to personalize your comments!');?>

<?php else : // Comments are closed ?>
<!-- <p><?php _e('Sorry, the comment form is closed at this time.'); ?></p> -->
<?php endif; ?>