<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br /><?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<div id="comment">
	<br>
<?php if ($comments) : ?>
	<p><?php comments_number(__('No Responses'), __('One Response'), __('% Responses') );?> <?php _e('to');?>  &#8220;<?php the_title(); ?>&#8221;</p> 
<ol id="commentlist">
    <?php foreach ($comments as $comment) : ?>
    <li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
        <?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author_link()?> <?php _e('on');?> <?php comment_date('F j, Y') ?>
        <?php comment_time()?>
		<?php edit_comment_link(__("Edit This"), ''); ?> 

      <?php if ($comment->comment_approved == '0') : ?>
      <em><?php _e('Your comment is awaiting moderation.');?></em>
      <?php endif; ?>
      <?php 
					if(the_author('', false) == get_comment_author())
						echo "<div class='commenttext-admin'>";
					else
						echo "<div class='commenttext'>";
					comment_text();
					echo "</div>";
					
					?>
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

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		
		
	<?php endif; ?>
<?php endif; ?>
<div class="entry">
<p>
<?php if ($post->ping_status == "open") { ?>
	<a href="<?php trackback_url(display); ?>">Trackback URI</a>  |
<?php } ?>
<?php if ($post-> comment_status == "open") {?>
	<?php comments_rss_link(__('Comments RSS')); ?>
<?php }; ?>
<?php if ($post-> comment_status == "closed") {?>
	Comments are closed.
<?php }; ?>
</p>
</div>

<?php if ('open' == $post-> comment_status) : ?>

<p><?php _e('Leave a Reply');?></p>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p></div>
<?php else : ?>

<div id="commentsform">
    <form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      
      <p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"> Logout &raquo; </a> </p>
      <?php else : ?>
      
      <p><?php _e('Name ');?><?php if ($req) _e('(required)'); ?><br />
      <input type="text" name="author" id="s1" value="<?php echo $comment_author; ?>" size="30" tabindex="1" />
      </p>
      
      <p><?php _e('Email ');?><?php if ($req) _e('(required)'); ?><br />
      <input type="text" name="email" id="s2" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" />
      </p>
      
      <p><?php _e('Website');?><br />
      <input type="text" name="url" id="s3" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" />
      </p>
      
      <?php endif; ?>
      <!--<p>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></p>-->
      <p><?php _e('Speak your mind');?><br />
      <textarea name="comment" id="s4" cols="90" rows="10" tabindex="4"></textarea>
      </p>
      
      <p>
        <input name="submit" type="submit" id="hbutt" tabindex="5" value="<?php _e('Submit Comment');?>" />
        <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form></div>

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
</div>

<!-- end comment -->