<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?>
<br /><br />
<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.','benevolence'); ?></p>
<?php return; endif; ?>

<?php if ( comments_open() ) : ?>
<b><?php comments_number(__('No Comments','benevolence'), __('1 Comment','benevolence'), __('% Comments','benevolence')); ?> <?php _e('so far','benevolence'); ?></b>
<?php else : // If there are no comments yet ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?><br /> 
<a href="#postcomment" title="<?php _e('Leave a comment','benevolence'); ?>"><?php _e('Leave a comment','benevolence'); ?></a>
<?php endif; ?>
<br /><br />
<a name="comments"></a>
<?php if ( $comments ) : ?>

<div class="commentlist">
<?php foreach ($comments as $comment) : ?>
<div class="commentBox">
	<?php comment_text() ?>
    <i><?php comment_type(__('','benevolence'), __('','benevolence'), __('','benevolence')); ?> <?php _e('','benevolence'); ?> <?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;
 <?php comment_author_link() ?>
    <?php comment_date(__('m.d.y','benevolence')); ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a> <?php edit_comment_link(__('Edit This','benevolence'), ' |'); ?></i>
</div>
<br />

<?php endforeach; ?>

</div>

<?php else : // If there are no comments yet ?>

<?php endif; ?>

<div class="right"><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.','benevolence')); ?> 
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack');?> <abbr title="<?php _e('Uniform Resource Identifier');?>">URI</abbr></a>
<?php endif; ?>
</div>

<br /><br />

<a name="postcomment"></a>
<?php if ( comments_open() ) : ?>
<b><?php _e('Leave a comment','benevolence'); ?></b><br />
<?php _e('Line and paragraph breaks automatic, e-mail address never displayed, <acronym title=\"Hypertext Markup Language\">HTML</acronym> allowed:','benevolence'); ?> <code><?php echo allowed_tags(); ?></code>

<form action="<?php echo get_settings('home'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as','benevolence'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','benevolence') ?>"><?php _e('Logout','benevolence') ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','benevolence'); ?> <?php if ($req) _e('(required)','benevolence'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)','benevolence'); ?> <?php if ($req) _e('(required)','benevolence'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','benevolence'); ?></small></label></p>

<?php endif; ?>

	<p>
	  <label for="comment"><?php _e('Your Comment','benevolence'); ?></label>
	<br />
	  <textarea name="comment" style="border: 1px solid #000;" id="comment" cols="50" rows="6" tabindex="4"></textarea>
	</p>

	<p>
	  <input name="submit" id="submit" type="submit" tabindex="5" value="<?php _e('Say It!','benevolence'); ?>" />
	  <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</p>
	<?php do_action('comment_form', $post->ID); ?>
</form>

<?php else : // Comments are closed ?>

<?php endif; ?>
