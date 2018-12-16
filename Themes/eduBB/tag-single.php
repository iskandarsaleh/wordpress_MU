<?php bb_get_header(); ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <a href="<?php bb_tag_page_link(); ?>"><?php _e('Tags'); ?></a> &raquo; <?php bb_tag_name(); ?></h3>

<h2 id="main-forum-title"><?php bb_tag_name(); ?></h2>


<?php do_action('tag_above_table', ''); ?>
		
<?php if ( $topics ) : ?>

<div id="active-discussion">

<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Posts'); ?></div>
<div class="discussion-poster"><?php _e('Last Poster'); ?></div>
<div class="discussion-freshness"><?php _e('Freshness'); ?></div>
</div>


<?php
if ( $topics ) :
$oddtopic = 'alt';
foreach ( $topics as $topic ) : ?>

<div class="discussion-box <?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><?php topic_last_poster(); ?></div>
<div class="discussion-box-freshness"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
</div>

<?php if ('alt' == $oddtopic) $oddtopic = ''; else $oddtopic = 'alt'; ?>

<?php endforeach; endif; ?>

<?php endif; ?>

</div>


<div id="paging">
<div class="rssfeed"><a href="<?php bb_tag_rss_link(); ?>" class="rss-link"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> link for this tag.') ?></a></div>
<div id="pages"><?php tag_pages(); ?></div>
</div>


<?php post_form(); ?>

<?php do_action('tag_below_table', ''); ?>

<?php manage_tags_forms(); ?>

<?php bb_get_footer(); ?>