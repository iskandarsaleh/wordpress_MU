<?php /*
	Comments Template
	This page holds the code used by comments.php for showing comments.
	It's separated out here for ease of use, because the comments.php file is already pretty cluttered.
	*/
?>
<h2 id="comments"><?php _e('Comments') ?></h2>
<?
	$even = "comment-even";
	$odd = "comment-odd";
	$author = "comment-author";
	$bgcolor = $even;
?>
<ol id="commentlist">
<?php foreach ($comments as $comment) : ?>
	<? if ($comment->comment_type != "trackback" && $comment->comment_type != "pingback") { ?>
	<? /* Comment number and bg colors */ 
	$comment_number++;
	if($odd == $bgcolor) { $bgcolor = $even; } else { $bgcolor = $odd; }

	/* Assign .comment-author CSS class to weblog administrator */
	$is_author = false;
	if($comment->comment_author_email == get_settings(admin_email)) {
		$is_author = true;
	}
	?>	
	
	<li class="<? if ($is_author == true) { echo $author; } else { echo $bgcolor; }?>">
		<a name="comment-<?php comment_ID() ?>"></a>
		<div class="comment-body">
			<div class="comment-header">
				<?php if (function_exists('avatar_display_comments')){ avatar_display_comments(get_comment_author_email(),'48',''); } ?>&nbsp;&nbsp;<?php if (function_exists('comment_favicon')) { ?><a href="<? echo($comment->comment_author_url); ?>" title="<?php _e('Visit');?> <? echo($comment->comment_author); ?>"><? comment_favicon($before='<img src="', $after='" alt="" class="comment-avatar" />'); ?></a><?php } ?>
				
				<em><a href="#comment-<? echo($comment->comment_ID) ?>" title="<?php _e('Permanent link to this comment') ?>"><? echo($comment_number) ?></a></em>
				<strong><? comment_author_link(); ?></strong> 
				<?php if ( function_exists(comment_subscription_status) ) { if (comment_subscription_status()) { ?><?php _e('(subscribed to comments)') ?><? }} ?>
				<?php _e('says:') ?>
				<?php if ($comment->comment_approved == '0') : ?>
				<small><?php _e('Your comment is awaiting moderation. This is just a spam counter-measure, and will only happen the first time you post here. Your comment will be approved as soon as possible.') ?></small>
				<?php endif; ?>

			</div>

			<?php comment_text() ?>
			<small>
				<?php _e('Posted') ?> 
				<?php if (function_exists('time_since')) {
				echo time_since(abs(strtotime($comment->comment_date_gmt . " GMT")), time()) . " ago";
				} else { ?>
				<?php comment_date(); ?>, <?php comment_time(); } ?> 
				<?php edit_comment_link(__("Edit This"), ' | '); ?>
			</small>
		</div>
	</li>

	<? } ?>
<?php endforeach; ?>
</ol><br />
