<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
<p class="nocomments">
  <?php _e("This post is password protected. Enter the password to view comments."); ?>
<p>
  <?php
				return;
            }
        }
		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>
<div id="commentblock">
  <!--comments area-->
  <h2 id="comments">
    <?php comments_number(__('No Comment'), __('1 Comment so far'), __('% Comments so far')); ?>
  </h2>
  <ol class="commentlist" id="commentlist">
    <?php if ($comments) : ?>
    <?php foreach ($comments as $comment) : ?>
    <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
      <div class="commentname">
      <?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;  <?php comment_author_link()?>
        <?php _e('on');?> <?php comment_date('F jS, Y') ?>
        <?php edit_comment_link(__("Edit This"), ''); ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
      <em><?php _e('Your comment is awaiting moderation.');?></em>
      <?php endif; ?>
      <div class='commenttext'>
        <div class="commentp">
          <?php if($isByAuthor ) { echo '<div class="authorcomment">';} ?>
          <?php comment_text();?>
        </div>
</div>
      <?php if($isByAuthor ) { echo '</div>';} ?>
    </li>
    <?php /* Changes every other comment to a different class */	
					if ('alt' == $oddcomment){
						$oddcomment = 'standard';
					}
					else {
						$oddcomment = 'alt';
					}
				?>
    <?php endforeach; /* end for each comment */ ?>
  </ol>
  <?php else : // this is displayed if there are no comments so far ?>
  <?php if ('open' == $post->comment_status) : ?>
  <!-- If comments are open, but there are no comments. -->
  <li id="hidelist" style="display:none"></li>
  </ol>
  <h2 id="nocomment">No comments yet</h2>
  <?php else : // comments are closed ?>
  <!-- If comments are closed. -->
  <li style="display:none"></li>
  </ol>
  <p>Comments are closed.</p>
  <?php endif; ?>
  <?php endif; ?>
  <div id="loading" style="display: none;">Posting your comment.</div>
  <div id="errors"></div>
  <?php if ('open' == $post-> comment_status) : ?>
  <h2><?php _e('Leave a Reply');?></h2>
  <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
  <p> <?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
  <?php else : ?>
  <div id="commentsform">
    <form id="commentform" action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" onsubmit="new Ajax.Updater({success: 'commentlist'}, '<?php bloginfo('stylesheet_directory') ?>/comments-ajax.php', {asynchronous: true, evalScripts: true, insertion: Insertion.Bottom, onComplete: function(request){complete(request)}, onFailure: function(request){failure(request)}, onLoading: function(request){loading()}, parameters: Form.serialize(this)}); return false;">
      <?php if ( $user_ID ) : ?>
      <p> <?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"> Logout &raquo; </a> </p>
      <?php else : ?>
      <p>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
        <label for="author"><small>
        <?php _e('name');?>
        <?php if ($req) _e('(required)'); ?>
        </small></label>
      </p>
      <p>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
        <label for="email"><small>
        <?php _e('email');?>
        (
        <?php _e('will not be shown');?>
        )
        <?php if ($req) _e('(required)'); ?>
        </small></label>
      </p>
      <p>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
        <label for="url"><small>
        <?php _e('website');?>
        </small></label>
      </p>
      <?php endif; ?>
      <!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>-->
      <p>
        <textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
      </p>
      <p>
        <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
        <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form>
  </div>
  <?php endif; // If registration required and not logged in ?>
  <?php endif; // if you delete this the sky will fall on your head ?>
</div>
