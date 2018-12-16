<br /><br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
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
?>

<!-- You can start editing here. -->



<?php if ('open' == $post->comment_status) : ?>

<h2 class="top_border" id="respond">Make A Comment: ( <a href="#respond"><?php comments_number('None', '1', '%'); ?></a> so far )</h2>
				
				<div id="comment_form">
				
				<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
				<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
				<?php else : ?>
				
				<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
				
				<?php if ( $user_ID ) : ?>				
				<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account');?>"><?php _e('Logout');?> &raquo;</a></p>
				
							<label for="comment"><small><?php _e('Your Comment');?></small><br /><textarea name="comment" id="comment" cols="20" rows="5" tabindex="1" style="width:95%;"></textarea></label>
							<p><small>Change comment box size: <a style="cursor: pointer;" onclick="document.getElementById('comment').rows += 5;" title="Click to enlarge the comments textarea">+</a> | <a style="cursor: pointer;" onclick="document.getElementById('comment').rows -= 5;" title="Click to decrease the comments textarea">&#8211;</a><br />
							(<em>blockquote</em> and <em>a</em> tags work here.)</small></p>
					
		
					<div class="clear"></div>
					
						<input name="submit" type="submit" id="submit" tabindex="2" value="<?php _e('Submit Comment');?>" class="float_right" />
						<div class="clear"></div>
						<input type="hidden" class="button" name="comment_post_ID" value="<?php echo $id; ?>" />
				
				<?php else : ?>

					<div class="comment_wrapper">
						<div class="comment_content">
					
							<label for="comment"><small><?php _e('Your Comment');?></small><br /><textarea name="comment" id="comment" cols="20" rows="5" tabindex="1" style="width:95%;"><?php if (function_exists('quoter_comment_server')) { quoter_comment_server(); } ?></textarea></label>
					
						</div>
					</div>
					
					<div class="comment_details">				
					
						<label for="author"><small><?php _e('Name');?> <?php if ($req) echo "__('(required)')"; ?></small><br /><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="2" style="width:95%;" /></label>
						
						
						<label for="email"><small>Mail <?php if ($req) echo "__('(required)')"; ?> (hidden)</small><br /><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="3" style="width:95%;" /></label>
						
						<label for="url"><small><?php _e('Website');?></small><br /><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="4" style="width:95%;" /></label>
						
						<!--<p><small><strong>XHTML:</strong> You can use these tags: &lt;a href=&quot;&quot; title=&quot;&quot;&gt; &lt;abbr title=&quot;&quot;&gt; &lt;acronym title=&quot;&quot;&gt; &lt;b&gt; &lt;blockquote cite=&quot;&quot;&gt; &lt;code&gt; &lt;em&gt; &lt;i&gt; &lt;strike&gt; &lt;strong&gt; </small></p>-->
										
					</div>
					<div class="clear"></div>
					
					
					
						<input name="submit" class="button" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
						
						<p><small><em>blockquote</em> and <em>a</em> tags work here.</small></p>
						
					
					<?php endif; ?>
					<?php do_action('comment_form', $post->ID); ?>
					
					<div class="clear"></div>
					
				</form>
				</div>
				
				<?php endif; // If registration required and not logged in ?>
				

<?php endif; // if you delete this the sky will fall on your head ?>


<?php if ($comments) : ?>
	<h2 id="comments" class="top_border"><?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?> <?php _e('to');?>  &#8220;<?php the_title(); ?>&#8221;</h2>
	<p class="author"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon_rss.gif" alt="RSS Feed for <?php bloginfo('name'); ?>" border="0" class="vertical_align" /> <strong><?php comments_rss_link('Comments RSS Feed', 'file'); ?></strong></p>

	<div class="commentlist">
	<?php foreach ($comments as $comment) : ?>
	
	<?php
	$authorcomment = '';
	if($comment->comment_author_email == get_the_author_email()) {
	$authorcomment = ' authorcomment';
	}
	?>

		<?php if($authorcomment ) { echo '<div class="authorcomment">';} ?>
		<div class="<?php echo $oddcomment; ?> comment_wrapper" id="comment-<?php comment_ID() ?>">
			<div class="comment_content">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.');?></em>
				<?php else : ?>
				<?php comment_text() ?>
				<?php endif; ?>
			</div>
		</div>
		
		<div class="comment_details">
			<p class="comment_meta"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<strong><?php comment_author_link() ?></strong><br /><?php comment_date() ?><br /></p>
					</div>
		<div class="clear comment_bottom"></div>
		<?php if($authorcomment ) { echo '</div>';} ?>
			

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>
	</div>

	<p><a href="#respond">Where's The Comment Form?</a></p>
 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post->comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<!-- ><p class="nocomments"><?php _e('Comments are closed.');?><p> -->
		
	<?php endif; ?>
<?php endif; ?>
