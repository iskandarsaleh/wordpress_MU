<br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>


<?php if ( $comments ) : ?>


<?php foreach ($comments as $comment) :
$commentcounter++;
if ($commentcounter % 2 == 0) { ?>
<div class="commentodd" id="comment-<?php comment_ID() ?>"><div class="commentcontent">
    <?php comment_text() ?>
    <p class="commentinfo"><cite><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp; <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite></p>
</div></div>
<?php } else { ?>
<div class="commenteven" id="comment-<?php comment_ID() ?>"><div class="commentcontent">
    <?php comment_text() ?>
    <p class="commentinfo"><cite><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp; <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite></p>
</div></div>
<?php } endforeach; endif; ?>

<?php if ( comments_open() ) : ?>
<div class="post">
<h3><?php _e('Leave a comment'); ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout');?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name');?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)');?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website');?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
</div>

<?php endif; endif; ?>
