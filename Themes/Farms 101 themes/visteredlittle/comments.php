<?php if (function_exists('comment_form_text_output')){ comment_form_text_output(); } ?><br /><br />
<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<?php return; endif; ?>

<span id="comments"></span>

<?php if ( $comments ) : ?>

<?php foreach ($comments as $comment) : ?>

<div class="blogbefore named">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post">
<div class="comment-author named" id="comment-<?php comment_ID() ?>"><?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php comment_author_link(); ?></div>
<div class="headertext"><?php comment_type(); ?> <?php _e('on');?> <?php comment_time(__('F jS, Y')); ?>. <?php edit_comment_link('e', '', ''); ?></div>
<?php if ($comment->comment_approved == '0') : ?>
<p><em><?php _e('Your comment is awaiting moderation.', VL_DOMAIN ); ?></em></p>
<?php endif; ?>
<?php comment_text(); ?>
</div>
<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>

<?php endforeach; ?>

<?php else : ?>

<?php if ('open' == $post->comment_status) : ?>

<?php else : ?>

<?php endif; ?>
<?php endif; ?>

<?php require( TEMPLATEPATH .'/comments-form.php'  );