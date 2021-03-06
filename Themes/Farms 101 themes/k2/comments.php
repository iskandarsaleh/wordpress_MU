<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?>
<?php
	// Do not access this file directly
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) { die (__('Please do not load this page directly. Thanks!','k2_domain')); }

	// Password Protection
	if (!empty($post->post_password)) { if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
?>

	<p class="nopassword"><?php _e('This post is password protected. Enter the password to view comments.','k2_domain'); ?></p>

<?php return; } } ?>

	<?php if (($comments) or ('open' == $post->comment_status)) : $shownavigation = 'yes'; ?>

	<div class="comments">

		<h4><?php printf(__('%1$s %2$s to &#8220;%3$s&#8221;','k2_domain'), '<span id="comments">' . get_comments_number() . '</span>', (1 == $post->comment_count) ? __('Response','k2_domain'): __('Responses','k2_domain'), wp_specialchars(get_the_title(),1) ); ?></h4>

		<div class="metalinks">
			<span class="commentsrsslink"><?php comments_rss_link(__('Feed for this Entry','k2_domain')); ?></span>
			<?php if ('open' == $post->ping_status) { ?><span class="trackbacklink"><a href="<?php trackback_url(); ?>" title="<?php _e('Copy this URI to trackback this entry.','k2_domain'); ?>"><?php _e('Trackback Address','k2_domain'); ?></a></span><?php } ?>
		</div>

		<?php /* Seperate comments and pings */
			if ( $post->comment_count > 0 ) {
				$countComments = 0;
				$countPings    = 0;
				
				$k2_comment_list = array();
				$k2_ping_list    = array();

				foreach ($comments as $comment) {
					if ( 'comment' == get_comment_type() ) {
						$k2_comment_list[++$countComments] = $comment;
					} else {
						$k2_ping_list[++$countPings] = $comment;
					}
				}
			}
		?>

	<hr />

		<?php /* Check for comments */ if ( $countComments > 0 ) { ?>
		<ol id="commentlist">

			<?php foreach ($k2_comment_list as $comment_index => $comment) { $i++;?>

			<li id="comment-<?php comment_ID(); ?>" class="<?php if ( $i%2 ) echo 'alt'; ?>">
				<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>
				<a href="#comment-<?php comment_ID(); ?>" class="counter" title="<?php _e('Permanent Link to this Comment','k2_domain'); ?>"><?php echo $comment_index; ?></a>
				<span class="commentauthor"><?php comment_author_link(); ?></span>

				<small class="comment-meta">
				<?php
					printf('<a href="#comment-%1$s" title="%2$s">%3$s</a>', 
						get_comment_ID(),
						(function_exists('time_since')?
							sprintf(__('%s ago.','k2_domain'),
								time_since(abs(strtotime($comment->comment_date_gmt . " GMT")), time())
							):
							__('Permanent Link to this Comment','k2_domain')
						),
						sprintf(__('%1$s at %2$s','k2_domain'),
							get_comment_date(),
							get_comment_time()
						)
					);
				?>
				</small>
			
				<div class="comment-content">
					<?php comment_text(); ?> 
				</div>

				<?php if ('0' == $comment->comment_approved) { ?><p class="alert"><strong><?php _e('Your comment is awaiting moderation.','k2_domain'); ?></strong></p><?php } ?>
			</li>

			<?php } /* End foreach comment */ ?>

		</ol> <!-- END #commentlist -->
		<?php } /* end comment check */ ?>
		
		<?php /* Check for Pings */ if ( $countPings > 0 ) { ?>
		<ol id="pinglist">

			<?php foreach ($k2_ping_list as $ping_index => $comment) { ?>

			<li id="comment-<?php comment_ID(); ?>">
				<?php if (function_exists('comment_favicon')) { ?><span class="favatar"><?php comment_favicon(); ?></span><?php } ?>
				<a href="#comment-<?php comment_ID() ?>" title="<?php _e('Permanent Link to this Comment','k2_domain'); ?>" class="counter"><?php echo $ping_index; ?></a>
				<span class="commentauthor"><?php comment_author_link(); ?></span>
				<small class="comment-meta">				
				<?php
					printf(__('%1$s on %2$s','k2_domain'), 
						'<span class="pingtype">' . __('Trackback','k2_domain') . '</span>',
						sprintf('<a href="#comment-%1$s" title="%2$s">%3$s</a>',
							get_comment_ID(),	
							(function_exists('time_since')?
								sprintf(__('%s ago.','k2_domain'),
									time_since(abs(strtotime($comment->comment_date_gmt . " GMT")), time())
								):
								__('Permanent Link to this Comment','k2_domain')
							),
							sprintf(__('%1$s at %2$s','k2_domain'),
								get_comment_date(),
								get_comment_time()
							)			
						)
					);
				?>				
				<?php if ($user_ID) { edit_comment_link(__('Edit','k2_domain'),'<span class="comment-edit">','</span>'); } ?>
				</small>
			</li>
			<?php } /* end foreach ping */ ?>
		</ol> <!-- END #pinglist -->
		<?php } /* end ping check */ ?>
		
		<?php /* Comments open, but empty */ if ( ($post->comment_count < 1) and ('open' == $post->comment_status) ) { ?> 
		<ol id="commentlist">
			<li id="leavecomment">
				<?php _e('No Comments','k2_domain'); ?>
			</li>
		</ol>
		<?php } ?>
		
		<?php /* Comments closed */ if (('open' != $post->comment_status) and is_single()) { ?>
			<div><?php _e('Comments are currently closed.','k2_domain'); ?></div>
		<?php } ?>

	</div> <!-- END .comments 1 -->
		
	<?php endif; ?>
	
	<?php /* Reply Form */ if ('open' == $post->comment_status) { ?>
	<div class="comments">
		<h4 id="respond" class="reply"><?php if (isset($_GET['jal_edit_comments'])) { _e('Edit Your Comment','k2_domain'); } else { _e('Leave a Reply','k2_domain'); } ?></h4>
		
		<?php if (get_option('comment_registration') and !$user_ID) { ?>
		
			<p><?php printf(__('You must <a href="%s">login</a> to post a comment.','k2_domain'), get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink()); ?></p>
		
		<?php } else { ?>

			<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
		
			<p class="comment-login"><?php printf(__('Logged in as %s.','k2_domain'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','k2_domain'); ?>"><?php _e('Logout','k2_domain'); ?> &raquo;</a></p>
	
		<?php } ?>
			
			<?php if (!$user_ID) { ?>
				<div id="comment-personaldetails">
					<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
					<label for="author"><small><strong><?php _e('Name','k2_domain'); ?></strong> <?php if ($req) { __('(required)','k2_domain'); } ?></small></label></p>

					<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
					<label for="email"><small><strong><?php _e('Mail','k2_domain'); ?></strong> (<?php _e('will not be published','k2_domain'); ?>) <?php if ($req) { __('(required)','k2_domain'); } ?></small></label></p>

					<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					<label for="url"><small><strong><?php _e('Website','k2_domain'); ?></strong></small></label></p>
				</div>
			<?php } ?>
				<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags %s:','k2_domain'), allowed_tags()) ?></small></p>-->
		
				<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

				<p>
					<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit','k2_domain'); ?>" />
					<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
				</p>
				
				<div class="clear"></div>

				<?php do_action('comment_form', $post->ID); ?>

			</form>
		
		<?php if ($shownavigation) { include (TEMPLATEPATH . '/navigation.php'); } ?>
	
	</div> <!-- END .comments #2 -->
	<?php } // comment_status ?>
