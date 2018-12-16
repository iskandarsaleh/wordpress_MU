<?php bb_get_header(); ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Profile') ?></h3>

<div id="profile-edu">


<div id="left-forum">
<h2 id="userlogin"><?php echo get_user_name( $user->ID ); ?></h2>

<?php if ( $updated ) : ?>
<div class="notice">
<p><?php _e('Profile updated'); ?>. <a href="<?php profile_tab_link( $user_id, 'edit' ); ?>"><?php _e('Edit again &raquo;'); ?></a></p>
</div>
<?php elseif ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>
<div class="notice">
<p><?php printf(__('This is how your profile appears to a fellow logged in member, you may <a href="%1$s">edit this information</a>. You can also <a href="%2$s">manage your favorites</a> and subscribe to your favorites&#8217; <a href="%3$s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>'), attribute_escape( get_profile_tab_link( $user_id, 'edit' ) ), attribute_escape( get_favorites_link() ), attribute_escape( get_favorites_rss_link() )); ?></p>
</div>
<?php endif; ?>

<p class="profile-avatar"><?php echo bb_get_avatar( $user->ID ); ?></p>

<?php bb_profile_data(); ?>

<?php if ( is_bb_profile() ) profile_menu(); ?>
</div>



<div id="right-forum">

<h3 id="useractivity"><?php _e('User Activity') ?></h3>

<div id="user-replies" class="user-recent"><h4><?php _e('Recent Replies'); ?></h4>

<?php $oddtopic = 'alt'; ?>

<?php if ( $posts ) : ?>

<div id="active-discussion">
<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Last'); ?></div>
<div class="discussion-poster"><?php _e('Recent'); ?></div>
<div class="discussion-freshness"><?php _e('Favourite'); ?></div>
</div>

<?php foreach ($posts as $bb_post) : $topic = get_topic( $bb_post->topic_id ) ?>

<div class="discussion-box <?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a>  </p>
</div>
<div class="discussion-box-total-post"><?php if ( $user->ID == bb_get_current_user_info( 'id' ) ) printf(__('%s ago.'), bb_get_post_time()); else printf(__('%s ago.'), bb_get_post_time()); ?></div>
<div class="discussion-box-last-poster"><?php if ( bb_get_post_time( 'timestamp' ) < get_topic_time( 'timestamp' ) ) printf(__('%s ago'), get_topic_time()); else _e('none');?></div>
<div class="discussion-box-freshness"><?php user_favorites_link('', array('mid'=>'&times;'), $user_id); ?></div>
</div>

<?php if ('alt' == $oddtopic) $oddtopic = ''; else $oddtopic = 'alt'; ?>

<?php endforeach; ?>

<?php else : if ( $page ) : ?>
<p><?php _e('No more replies.') ?></p>
<?php else : ?>
<p><?php _e('No replies yet.') ?></p>
<?php endif; endif; ?>

</div>

</div>





<div id="user-threads" class="user-recent">
<h4><?php _e('Threads Started') ?></h4>


<?php $oddtopic = 'alt'; ?>

<?php if ( $topics ) : ?>

<div id="active-discussion">
<div class="active-discussion-header">
<div class="discussion-title"><?php _e('Topics'); ?></div>
<div class="discussion-post"><?php _e('Started'); ?></div>
<div class="discussion-poster"><?php _e('Replies'); ?></div>
<div class="discussion-freshness"><?php _e('Favourite'); ?></div>
</div>

<?php foreach ($topics as $topic) : ?>

<div class="discussion-box <?php echo $oddtopic; ?>">
<div class="discussion-box-title">
<p class="discussion-box-post-title"><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a> </p>
</div>
<div class="discussion-box-total-post"><?php printf(__('%s ago'), get_topic_start_time()); ?></div>
<div class="discussion-box-last-poster"><?php if ( get_topic_start_time( 'timestamp' ) < get_topic_time( 'timestamp' ) ) printf(__('%s ago.'), get_topic_time()); else _e('No replies.'); ?></div>
<div class="discussion-box-freshness"><?php user_favorites_link('', array('mid'=>'&times;'), $user_id); ?></div>
</div>

<?php if ('alt' == $oddtopic) $oddtopic = ''; else $oddtopic = 'alt'; ?>

<?php endforeach; ?>

<?php else : if ( $page ) : ?>
<p><?php _e('No more topics posted.') ?></p>
<?php else : ?>
<p><?php _e('No topics posted yet.') ?></p>
<?php endif; endif;?>
</div>

</div>



<div id="paging">
<div id="pages">
<?php profile_pages(); ?>
</div>
</div>

</div>

</div><!-- end edu-profile -->

<?php bb_get_footer(); ?> 

