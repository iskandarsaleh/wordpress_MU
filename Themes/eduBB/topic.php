<?php bb_get_header(); ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <a href="<?php forum_link(); ?>"><?php forum_name(); ?></a></h3>


<div id="the-help-zone">

<div id="help-comments">

<!-- here we make the thread stater more prominent -->

<?php if ($posts) : ?>

<?php
$count_comment = 0;
$this_topic_paged = $_GET['page'];
?>

<h1<?php topic_class( 'topictitle' ); ?>><?php topic_title(); ?></h1>

<div id="paging" class="top">
<div class="rssfeed"><a href="<?php topic_rss_link(); ?>"><?php _e('RSS feed for this topic') ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="rss.php"><?php _e('RSS feed for all topics') ?></a>
</div>
<div id="pages"><?php topic_pages(); ?></div>
</div>

<?php foreach ($posts as $bb_post) : $del_class = post_del_class(); ?>

<?php if(($count_comment < 1) && ($this_topic_paged < 2)) { ?>

<div class="post-comment">
<div id="post-<?php post_id(); ?>"<?php alt_class('post', $del_class); ?>>
<div class="myavatar"><?php if ( function_exists('avatar_display_bbpress') ) {avatar_display_bbpress(get_post_author_id( $bb_post->post_id ),'48',''); } ?></div>
<div class="mycom threadstarter">

<div class="post-author"><?php post_author_link(); ?>&nbsp;<small>(<?php post_author_title(); ?>)</small></div>
<div class="post-date"><?php printf( __('Started %s ago'), bb_get_post_time() ); ?>&nbsp;&nbsp;<a href="<?php post_anchor_link(); ?>">#</a>&nbsp;<?php post_ip_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php post_edit_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php post_delete_link(); ?><?php if (function_exists('report_post_link')) : ?>&nbsp;&nbsp;&nbsp;&nbsp;<? report_post_link(); ?><?php endif; ?></div>

<div class="post-text">
<?php post_text(); ?>
</div>

</div>
</div>
</div>




<?php do_action('under_title', ''); ?>

<?php if ( 1 < get_topic_posts() ) : ?>
<h3 id="we-are-the-angel">Answers from fellow members and edublogs support</h3>
<?php endif; ?>


<?php } else { ?>

<div class="post-comment">
<div id="post-<?php post_id(); ?>"<?php alt_class('post', $del_class); ?>>
<div class="myavatar"><?php avatar_display_bbpress(get_post_author_id( $bb_post->post_id ),'48',''); ?></div>
<div class="mycom">
<?php bb_post_template(); ?>
</div>
</div>
</div>


<?php } ?>

<?php $count_comment++; ?>

<?php endforeach; ?>

<?php endif; ?>

</div> <!-- help-comments -->



<div id="help-meta">
<div class="thread-meta">
<h4>Post Meta</h4>
<?php if ( 1 < get_topic_posts() ) : ?>
<div class="latest-reply"><?php printf(__('<a href="%1$s">Latest reply</a> from %2$s'), attribute_escape( get_topic_last_post_link() ), get_topic_last_poster()) ?></div>
<?php endif; ?>

<div class="tag-related">
<strong>Tags:</strong>
<?php topic_tags(); ?></div>
<div class="com-related"><strong><?php topic_posts_link(); ?> already</strong><?php if (bb_is_user_logged_in()) : ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ( topic_is_open( $bb_post->topic_id ) ) : ?><br /><br /><a href="#postform">Add Reply</a><?php endif; ?><?php endif; ?></div>

<?php if ( bb_is_user_logged_in() ) : $class = 0 === is_user_favorite( bb_get_current_user_info( 'id' ) ) ? ' class="is-not-favorite"' : ''; ?>
<div class="tag-related">
<div<?php echo $class;?> id="favorite-toggle"><?php user_favorites_link() ?></div>
</div>
<?php endif; do_action('topicmeta'); ?>



<!-- related from author -->
<div class="thread-related">
<h4>Also started by this author</h4>
<?php
$t_author = get_topic_author();
$topics_this = $bbdb->get_results("SELECT * FROM $bbdb->topics WHERE topic_poster_name = '$t_author' ORDER BY topic_time DESC LIMIT 0,5")
?>
<ul>
<?php foreach ( $topics_this as $my_post ) : ?>
<?php
$t_id = $my_post->topic_id;
$t_title = $my_post->topic_title;
?>
<li><a href="topic.php?id=<?php echo "$t_id"; ?>"><?php echo "$t_title"; ?></a></li>
<?php endforeach; ?>
</ul>
</div>
<!-- end -->
</div>
<!-- end thread-meta -->
</div>


</div><!-- end help zone -->


<div id="paging">
<div class="rssfeed"><a href="<?php topic_rss_link(); ?>"><?php _e('RSS feed for this topic') ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="rss.php"><?php _e('RSS feed for all topics') ?></a>
</div>
<div id="pages"><?php topic_pages(); ?></div>
</div>


<?php if ( topic_is_open( $bb_post->topic_id ) ) : ?>
<?php post_form(); ?>
<?php else : ?>
<h2><?php _e('Topic Closed') ?></h2>
<p><?php _e('This topic has been closed to new replies.') ?></p>
<?php endif; ?>

<?php if ( bb_current_user_can( 'delete_topic', get_topic_id() ) || bb_current_user_can( 'close_topic', get_topic_id() ) || bb_current_user_can( 'stick_topic', get_topic_id() ) || bb_current_user_can( 'move_topic', get_topic_id() ) ) : ?>
<div class="admin-pre">
<?php topic_delete_link(); ?> <?php topic_close_link(); ?> <?php topic_sticky_link(); ?><br />
<?php topic_move_dropdown(); ?>
</div>
<?php endif; ?>

<?php bb_get_footer(); ?>