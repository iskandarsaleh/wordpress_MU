<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e('This post is password protected.'); ?><p>
				
				<?php
				return;
            }
        }
?>

<?php if ($comments) : ?>

	<h2 id="comments">
		<?php comments_number(__('Comments'), __('1 Response'), __('% Responses')); ?> <?php _e('so far'); ?>
		<?php if ( comments_open() ) : ?>
			<a href="#postcomment" title="<?php _e('Jump to the comments form'); ?>">&raquo;</a>
		<?php endif; ?>
	</h2>
	
	<ol id='commentlist' class="commentlist">

	<!-- Comment Counter -->
	<?php $relax_comment_count=isset($commentcount)? $commentcount+0 : 1; ?>
	
	<?php foreach ($comments as $comment) : ?>

	<!-- A different style if comment author is blog owner -->
	<li class="<?php if ($comment->comment_author_email == get_the_author_email()) { echo 'adminreply'; } ?> item" id="comment-<?php comment_ID() ?>" >

		<!-- Comment Counter -->
		<div class="commentcounter"><?php echo $relax_comment_count; ?></div>
		
		<!-- Gravatar -->
		<div class="commentgravatar">
			<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>
		</div>
		
		<h3 class="commenttitle"><?php comment_author_link() ?> <?php _e('said'); ?>,</h3>
		
		<p class="commentmeta">
			<a href="#comment-<?php comment_ID() ?>">
				<?php comment_date() ?> @ <?php comment_time() ?>
			</a>

			<!-- Quoter -->
			<?php if (function_exists('quoter_comment')) { quoter_comment(); } ?>

			<?php edit_comment_link(__("Edit"), ' &#183; ', ''); ?>

		</p>
		
		<?php comment_text() ?>
		
	</li>

	<!-- Comment Counter -->
	<?php $relax_comment_count++; ?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>
	
	<p class="small">
		<?php comments_rss_link(__('Comment <abbr title="Really Simple Syndication">RSS</abbr>')); ?>
		<?php if ( pings_open() ) : ?>
			&#183; <a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Uniform Resource Identifier">URI</abbr>'); ?></a>
		<?php endif; ?>
	</p>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post-> comment_status) : ?> 
		<?php /* No comments yet */ ?>
		
	<?php else : // comments are closed ?>
		<?php /* Comments are closed */ ?>
		<p><?php _e('Comments are closed.'); ?></p>
		
	<?php endif; ?>
	
<?php endif; ?>

<?php if ('open' == $post-> comment_status) : ?>

	<h2 id="postcomment"><?php _e('Say your words'); ?></h2>
	
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	
		<p><?php _e('You must be'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in'); ?></a> <?php _e('to post a comment.'); ?></p>
	
	<?php else : ?>
	
		<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
		
		<?php if ( $user_ID ) : ?>
		
			<p><?php _e('Logged in as'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout'); ?> &raquo;</a></p>

		<?php else : ?>
	
			<p>
			<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" tabindex="1" />
			<label for="author"><?php _e('&nbsp;Name'); ?> <?php if ($req) _e('(required)'); ?></label>
			</p>
			
			<p>
			<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" />
			<label for="email"><?php _e('&nbsp;E-mail'); ?> <?php if ($req) _e('(required, hidden to public)'); ?></label>
			</p>
			
			<p>
			<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" />
			<label for="url">&nbsp;<abbr title="<?php _e('Uniform Resource Identifier'); ?>"><?php _e('URI'); ?></abbr> (your blog or website)</label>
			</p>

		<?php endif; ?>

		<!-- Emoitions -->
		<?php if (class_exists('emotions')) { emotions::bar(); } ?>

		<p>
		<textarea name="comment" id="comment" cols="80" rows="12" tabindex="4"><?php if (function_exists('quoter_comment_server')) { quoter_comment_server(); } ?></textarea>
		</p>

		<p>
		<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="<?php _e('Submit Comment'); ?>" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		</p>
	
		<?php do_action('comment_form', $post->ID); ?>
	
		</form>

	<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
