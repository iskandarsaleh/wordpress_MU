<div class="pad-top" id="active-discussion">
<?php
$topics = $bbdb->get_results("SELECT * FROM $bbdb->topics ORDER BY topic_posts DESC LIMIT 0,10")
?>
<?php if ( $topics ) : ?>

<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Most Active Topics'); ?></div>
<div class="discussion-post"><?php _e('Posts'); ?></div>
<div class="discussion-poster"><?php _e('Last Poster'); ?></div>
<div class="discussion-freshness"><?php _e('Freshness'); ?></div>
</div>

<?php if ( $topics ) :
$oddtopic = ' alt';
foreach ( $topics as $topic ) : ?>

<div id="topic-active-<?php topic_id(); ?>" class="discussion-box<?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><?php bb_topic_labels(); ?><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><?php topic_last_poster(); ?></div>
<div class="discussion-box-freshness"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
</div>

<?php if (' alt' == $oddtopic) $oddtopic = ''; else $oddtopic = ' alt'; ?>

<?php endforeach; endif; // $topics ?>

<?php endif; // $topics or $super_stickies ?>

</div>