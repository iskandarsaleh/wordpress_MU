<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p>
  <?php _e('Enter your password to view comments.'); ?>
</p>
<?php return; endif; ?>
<?php if ($comments) : ?>
<h4 class="reply">
  <?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?> <?php _e('to');?>  '
  <?php the_title(); ?>
  '</h4>
<p class="comment_meta">Subscribe to comments with 
  <?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr>')); ?>
  <?php if ( pings_open() ) : ?>
  or <a href="<?php trackback_url() ?>" rel="trackback">
  <?php _e('TrackBack');?>
  </a> to '
  <?php the_title(); ?>
  '. 
  <?php endif; ?>
</p>
<ol class="commentlist">
  <?php foreach ($comments as $comment) : ?>
  <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>"> 
    <div class="comment_author"> 
    <?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;  <?php comment_author_link() ?>
      said, </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em><?php _e('Your comment is awaiting moderation.');?></em> 
    <?php endif; ?>
    <br />
    <p class="metadate"><?php _e('on');?> <?php comment_date('F jS, Y') ?> <?php _e('at');?> <?php comment_time() ?>
    </p>
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
<p class="nocomments"><?php _e('Comments are closed.');?><p>
<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<h4 id="postcomment">
  <?php _e('Leave a reply'); ?>
</h4>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
<?php else : ?>
<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
  <?php if ( $user_ID ) : ?>
  <p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
    <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>
  <?php else : ?>
  <p>
    <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
    <label for="author"><small><?php _e('Name');?> <?php if ($req) _e('(required)'); ?>
    </small></label>
  </p>
  <p>
    <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
    <label for="email"><small>Mail (will not be published) 
    <?php if ($req) _e('(required)'); ?>
    </small></label>
  </p>
  <p>
    <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
    <label for="url"><small><?php _e('Website');?></small></label>
  </p>
  <?php endif; ?>
  <!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>-->
  <script type="text/javascript">

function grin(tag) {
	var myField;
	if (document.getElementById('content') && document.getElementById('content').type == 'textarea') {
		myField = document.getElementById('content');
	}
	else if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
		myField = document.getElementById('comment');
	}
	else {
		return false;
	}
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = tag;
		myField.focus();
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		myField.value = myField.value.substring(0, startPos)
					  + tag
					  + myField.value.substring(endPos, myField.value.length);
		cursorPos += tag.length;
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos;
	}
	else {
		myField.value += tag;
		myField.focus();
	}
}

</script>
 
  <p> 
    <textarea name="comment" id="comment" cols="100%" rows="6" tabindex="4"></textarea>
  </p>
  <p>
    <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
  </p>
  <?php do_action('comment_form', $post->ID); ?>
</form>

<?php endif; // If registration required and not logged in ?>
<?php else : // Comments are closed ?>
<p>
  <?php _e('Sorry, the comment form is closed at this time.'); ?>
</p>
<?php endif; ?>
