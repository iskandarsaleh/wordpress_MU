<?php bb_get_header(); ?>


<h3 class="bbcrumb">
<a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a><?php bb_forum_bread_crumb(); ?>
</h3>

<h2 id="main-forum-title"><?php forum_description('before='); ?><?php if (bb_is_user_logged_in()) : ?>&nbsp;&nbsp;&nbsp;<small><a href="#postform">Add New &raquo;</a></small><?php endif; ?></h2>


<div id="active-discussion">

<?php if ( $topics || $stickies ) : ?>

<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Posts'); ?></div>
<div class="discussion-poster"><?php _e('Last Poster'); ?></div>
<div class="discussion-freshness"><?php _e('Freshness'); ?></div>
</div>


<?php if ( $stickies ) : foreach ( $stickies as $topic ) : ?>

<div id="bb-topic-<?php topic_id(); ?>" class="discussion-box sticky">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><?php bb_topic_labels(); ?><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><?php topic_last_poster(); ?></div>
<div class="discussion-box-freshness"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
</div>

<?php endforeach; endif; ?>


<?php
if ( $topics ) :
$oddtopic = ' alt';
foreach ( $topics as $topic ) : ?>

<div id="bb-topic-<?php topic_id(); ?>" class="discussion-box<?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><?php bb_topic_labels(); ?><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><?php topic_last_poster(); ?></div>
<div class="discussion-box-freshness"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
</div>

<?php if (' alt' == $oddtopic) $oddtopic = ''; else $oddtopic = ' alt'; ?>

<?php endforeach; endif; ?>

<?php endif; ?>

</div>


<div id="paging">
<div class="rssfeed"><a href="<?php forum_rss_link(); ?>"><?php _e('RSS feed for this forum'); ?></a></div>
<div id="pages"><?php forum_pages(); ?></div>
</div>


<?php post_form(); ?>

<?php bb_get_footer(); ?>