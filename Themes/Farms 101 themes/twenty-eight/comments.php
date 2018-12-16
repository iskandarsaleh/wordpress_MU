<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
	?>			
			
		<p class="center"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
<?php	return; } }

	function k2_comment_type_detection($commenttxt = 'Comment', $trackbacktxt = 'Trackback', $pingbacktxt = 'Pingback') {
		global $comment;
		if (preg_match('|trackback|', $comment->comment_type))
			return $trackbacktxt;
		elseif (preg_match('|pingback|', $comment->comment_type))
			return $pingbacktxt;
		else
			return $commenttxt;
	}

	$templatedir = get_bloginfo('template_directory');
?>
<!-- You can start editing here. -->
<?php if (($comments) or ('open' == $post-> comment_status)) { ?><hr /><div class="comments" id="comments"><div class="center"><h4><a href="#comments"><?php comments_number('No Comments', 'One Reply', '% Replies' );?></a></h4></div><ol class="commentlist" id='commentlist'>
	<?php if ($comments) { ?><?php $count_pings = 1; foreach ($comments as $comment) { if (k2_comment_type_detection() == "Comment") { ?><li class="<?php if ($comment->comment_author_email == get_the_author_email()) { echo 'authorcomment'; } ?> item" id="comment-<?php comment_ID() ?>">  <span class="commentauthor" style="font-weight: normal;"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author_link(); ?></span><?php if ( $user_ID ) { edit_comment_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="commentseditlink">','</span>'); } ?>
				
<p class="metadata" style="color:#9c9c9c;font-size:12px;margin-top:2px;"><a href="#comment-<?php comment_ID() ?>" title="<?php { ?>Permalink to Comment<?php } ?>"><?php comment_date() ?> <?php _e('at');?> <?php comment_time() ?></a></p>

<div class="itemtext"><?php comment_text() ?></div><?php if ($comment->comment_approved == '0') : ?><p class="alert"><strong>Your comment is awaiting moderation.</strong></p><?php endif; ?></li><?php } } ?></ol>

		<?php $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '$post->ID' AND comment_approved = '1' AND comment_type!= '' ORDER BY comment_date"); ?>

		<?php if ($comments) { ?>

		<ol class="pinglist">
		<?php $count_pings = 1; foreach ($comments as $comment) { 
			if (k2_comment_type_detection() != "Comment") { ?>	
				<li class="item" id="comment-<?php comment_ID() ?>">
					
					<a href="#comment-<?php comment_ID() ?>" title="Permanent Link to this Comment" class="counter"><?php echo $count_pings; $count_pings++; ?></a>
<span class="commentauthor"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author_link() ?></span>
<small class="commentmetadata"><span class="pingtype"><?php comment_type(); ?></span> on <a href="#comment-<?php comment_ID() ?>" title="<?php if (function_exists('time_since')) { $comment_datetime = strtotime($comment->comment_date); echo time_since($comment_datetime) ?> ago<?php } else { ?>Permalink to Comment<?php } ?>"><?php comment_date('M jS, Y') ?> <?php _e('at');?> <?php comment_time() ?></a> <?php edit_comment_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="commentseditlink">','</span>'); ?></small>
					 <?php comment_text(); ?>
				</li>
		
			<?php } } /* end for each comment */ ?>

		</ol>
		<?php } ?>
		
	<?php } else { // this is displayed if there are no comments so far ?>

		<?php if ('open' == $post-> comment_status) { ?> 
			<!-- If comments are open, but there are no comments. -->
				<!--<li id="leavecomment"></li>-->

		<?php } else { // comments are closed ?>

			<!-- If comments are closed. -->

			<?php if (is_single) { // To hide comments entirely on Pages without comments ?>
			<li>Comments are currently closed.</li><?php } ?><?php } ?></ol><?php } ?><?php if ($comments) { ?><?php include (TEMPLATEPATH . '/navigation.php'); ?><?php } ?><!-- Reply Form --><?php if ('open' == $post-> comment_status) : ?><h4><?php _e('Leave a Comment');?></h4><br/><p class="metadata" style="padding-bottom:10px;"><a href="<?php trackback_url(); ?>" title="Send a trackback to this article">trackback address</a></p><?php if ( get_option('comment_registration') && !$user_ID ) : ?><p>You must <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('log in');?></a> <?php _e('to post a comment');?>.</p><?php else : ?><?php { ?><form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform"><?php } ?><div id="errors" style="display:none"><?php _e('There was an error with your comment, please try again.');?></div>
			
<?php if ( $user_ID ) { ?><p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p><?php } elseif ($comment_author != "") { ?><?php } ?>
			
<?php if ( !$user_ID ) { ?><div id="authorinfo"><p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /><label for="author"><small><strong>name</strong> <?php if ($req) _e('(required)'); ?></small></label></p><p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /><label for="email"><small><strong>email</strong> (will not be published) <?php if ($req) _e('(required)'); ?></small></label></p><p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /><label for="url"><small><strong>url</strong></small></label></p></div><?php } ?>
			
<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p><?php if (function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?><p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit');?>" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /><br class="all" /></p><?php do_action('comment_form', $post->ID); ?></form>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
</div>
<?php } ?>
