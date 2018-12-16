<?php // Do not delete these lines
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
$oddcomment ='alt';
?>

<?php $i = 0; ?>
<?php if ($comments) : ?>

<!---------------- start comments ---------------->

<!-- open comments --><div class="comments-wrapper">
<!-- open content --><div class="comments">

<h3 id="comments">
<?php comments_number(__('No comments <span>so far</span>'), __('1 comment <span>so far</span>'), __('% comments <span>so far</span>')); ?>
</h3>

<div class="metalinks">
<span class="commentsrsslink">
<small><?php comments_rss_link(__('Feed for this Entry','k2_domain')); ?></small>
</span>
<?php if ('open' == $post->ping_status) { ?>
<span class="trackbacklink">
<small>
<a href="<?php trackback_url(); ?>" title="<?php _e('Copy this URI to trackback this entry.','k2_domain'); ?>">
<?php _e('Trackback Address','k2_domain'); ?></a>
</small>
</span>
<?php } ?>
</div>

<ol class="commentlist">

<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type == 'comment') { ?>
<?php $i++; ?>

<li class="<?php echo $oddcomment; ?> comment" id="comment-&lt?php comment_ID() ?>"" id="comment-<?php comment_ID() ?>">
<?php if (function_exists('gravatar')) { ?><a href="<?php comment_author_url(); ?>" title="<?php comment_author(); ?>'s website"><img src="<?php gravatar("X", 32, ""); ?>" class="gravatar" alt="Gravatar Icon" /></a>
<?php } ?>

<span class="count">
<?php echo $i; ?>
</span>
<span class="commentauthor"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?> <?php comment_author_link() ?></span><br />
<small class="comment-meta">
<?php comment_time() ?> - <?php comment_date('n-j-Y'); ?> <?php edit_comment_link(__('Edit'),'',''); ?>
</small>

<div class="comment-content">
<div class="cc"><?php comment_text(); ?> </div>
</div>

<?php if ('0' == $comment->comment_approved) { ?><p class="alert"><strong><?php _e('Your comment is awaiting moderation.'); ?></strong></p><?php } ?>

</li>

<?php /* Changes every other comment to a different class */	
if ('alt' == $oddcomment) $oddcomment = '';
else $oddcomment = 'alt';
?>

<?php } /* End of is_comment statement */ ?>
<?php endforeach; /* end for each comment */ ?>

</ol>

<ol>
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type != 'comment') { ?>
<li><?php comment_author_link() ?></li>
<?php } ?>
<?php endforeach; ?>
</ol>

<?php else : // this is displayed if there are no comments so far ?>
<!-- open comments --><div class="comments-wrapper">
<!-- open content --><div class="comments">

<?php if ('open' == $post->comment_status) : ?> 
<!-- If comments are open, but there are no comments. -->

<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php _e('Comments are closed.');?><p>

<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond"><?php _e('Leave a Reply');?></h3><br /><?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?>
<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
<?php else : ?>

<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment-form">

<?php if ( $user_ID ) : ?>
<!-- open comment form --><div class="comment_form">
<p><?php _e('Logged in as');?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account');?>"><?php _e('Logout');?> &raquo;</a></p>

<?php else : ?>
<!-- open comment form --><div class="comment_form">
<fieldset>
<legend><?php _e('Your Details');?></legend>
<label for="author"><?php _e('Enter your full name ');?> <?php if ($req) echo "__('(required)')"; ?><br />
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="35" maxlength="40" tabindex="1" class="med" />
</label>
<br /> 
<label for="email"><?php _e('Mail (will not be published)');?> <?php if ($req) echo "__('(required)')"; ?><br />
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="35" maxlength="40" tabindex="2" class="med"  />
</label>
<br /> 
<label for="url"><?php _e('Website');?><br />
<input type="text" name="url" id="url"  value="<?php echo $comment_author_url; ?>" size="35" maxlength="40" tabindex="3" class="med"  />
</label>
</fieldset>
<?php endif; ?>

<fieldset>
<legend><?php _e('Your Comment');?></legend>
<label for="author"><span class="off"><?php _e('Author');?></span><br />
<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4" class="textbox"></textarea>
</label>
<br /> 
<input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" class="submit-button" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>
</fieldset>
<!-- close comment_form--></div>

</form>

<!-- close comments --></div>
<!-- close comments-wrapper --></div>

<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>