<?php bb_get_header(); ?>

<!--<h3 class="bbcrumb"><a href="http://edublogs.org/forums/">The Edublogs Forums</a> &raquo; <a href="http://edublogs.org/forums/forum.php?id=9">How do I do that then?</a></h3> -->



<div id="right-forum">
<h5 class="header-hline">Browse recently updated forum topics:</h5>
<div id="active-stats">
<?php include_once("bb-includes/functions.bb-statistics.php"); ?>
<strong><?php total_users(); ?></strong> users have made <strong><?php total_posts(); ?></strong> posts!
</div>

<div id="active-discussion">

<?php if ( $topics || $super_stickies ) : ?>

<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Posts'); ?></div>
<div class="discussion-poster"><?php _e('Last Poster'); ?></div>
<div class="discussion-freshness"><?php _e('Freshness'); ?></div>
</div>


<?php if ( $super_stickies ) : foreach ( $super_stickies as $topic ) : ?>
<div id="topic-<?php topic_id(); ?>" class="discussion-box sticky">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><?php bb_topic_labels(); ?><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><?php topic_last_poster(); ?></div>
<div class="discussion-box-freshness"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
</div>
<?php endforeach; endif; // $super_stickies ?>

<?php if ( $topics ) :
$oddtopic = ' alt';
foreach ( $topics as $topic ) : ?>

<div id="topic-<?php topic_id(); ?>" class="discussion-box<?php echo $oddtopic; ?>">
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




<?php /* include("active-post.php"); */ ?>





</div>


<?php include("leftbar.php"); ?>


<?php bb_get_footer(); ?>