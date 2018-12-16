<br /><br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br />

<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<h2 id="comments"><?php comments_number(__('No comments yet'), __('1 Comment'), __('% Comments')); ?> 
<?php if ( comments_open() ) : ?>
<a href="#postcomment" title="<?php _e("Leave a comment"); ?>">&raquo;</a>
<?php endif; ?>
</h2>

<?php if ( $comments ) : ?>

<?php foreach ($comments as $comment) : ?>
<div class="comentarios">
<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<a href="<?php comment_author_url(); ?>"> 
<?php comment_author(); ?></a> wrote @ <?php comment_date('F jS, Y') ?> <?php _e('at');?> <?php comment_time() ?>

</div>		
<?php comment_text() ?>

<?php endforeach; ?>

<?php else : // If there are no comments yet ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>
<h2 id="postcomment"><?php _e('Your comment'); ?></h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" class="input" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name');?> <?php if ($req) echo "__('(required)')"; ?></small></label></p>

<p><input type="text" class="input" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-Mail');?> <?php if ($req) echo "(Required, not published )"; ?></small></label></p>

<p><input type="text" class="input" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website');?></small></label></p>

<?php endif; ?>

<p><textarea name="comment" class="textarea" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
<?php if (function_exists('lmbbox_smileys_display')) { lmbbox_smileys_display(true); } ?>
<p><input name="submit" class="sub" type="submit" id="submit" tabindex="5" value="<?php _e('Submit');?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<p> <strong>HTML-<?php _e('Tags');?>:</strong>
<br />
<small><?php echo allowed_tags(); ?></small>
</p>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
