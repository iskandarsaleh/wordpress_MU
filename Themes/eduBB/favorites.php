<?php bb_get_header(); ?>

<div id="profile-edu">

<h2 id="userlogin">
<?php _e('Current Favorites'); ?><?php if ( $topics ) echo ' (' . $favorites_total . ')'; ?>
</h2>

<h2 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Favorites'); ?></h2>

<div class="notice">
<p>
<?php _e("Your Favorites allow you to create a custom <abbr title=\"Really Simple Syndication\">RSS</abbr> feed which pulls recent replies to the topics you specify.\nTo add topics to your list of favorites, just click the \"Add to Favorites\" link found on that topic&#8217;s page."); ?>
<br /><br />
<?php if ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>

<strong><?php printf(__('Subscribe to your favorites&#8217; <a href="%s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>.'), attribute_escape( get_favorites_rss_link( bb_get_current_user_info( 'id' ) ) )) ?> </strong>

<?php endif; ?>
</p>
</div>


<?php if ( $topics ) : ?>

<div id="active-discussion">

<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Posts'); ?></div>
<div class="discussion-poster"><?php _e('Freshness'); ?></div>
<div class="discussion-freshness"><?php _e('Remove'); ?></div>
</div>

<?php $oddtopic = 'alt'; ?>

<?php foreach ( $topics as $topic ) : ?>

<div class="discussion-box <?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></p>
</div>
<div class="discussion-box-total-post"><?php topic_posts(); ?></div>
<div class="discussion-box-last-poster"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></div>
<div class="discussion-box-freshness">[<?php user_favorites_link('', array('mid'=>'&times;'), $user_id); ?>]</div>
</div>

<?php if ('alt' == $oddtopic) $oddtopic = ''; else $oddtopic = 'alt'; ?>

<?php endforeach; ?>

<?php else: if ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>

<div class="notice"><p><?php _e('You currently have no favorites.'); ?></p></div>

<?php else : ?>

<div class="notice"> <p><?php echo get_user_name( $user_id ); ?> <?php _e('currently has no favorites.'); ?></p></div>


<?php endif; endif; ?>

</div>

<div id="paging">
<div id="pages"><?php favorites_pages(); ?></div>
</div>


</div>

<?php bb_get_footer(); ?>