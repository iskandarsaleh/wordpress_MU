<div id="left-forum">


<?php if ( bb_forums() ) : ?>

<div id="active-forum">

<h5 class="header-hline">Select a forum from to post in:</h5>
<br /><br/>

<div class="active-header">

<div class="main-title"><?php _e('Active Forums'); ?></div>
<div class="main-topic"><?php _e('Topics'); ?></div>
<div class="main-post"><?php _e('Posts'); ?></div>

</div>


<?php while ( bb_forum() ) : ?>

<div id="forum-<?php forum_id(); ?>" class="active-forum-category">
<div class="forum-category-title">
<h2><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a></h2>
<p class="forum-description"><?php forum_description(); ?></p>
</div>

<div class="forum-category-topic"><?php forum_topics(); ?></div>
<div class="forum-category-post"><?php forum_posts(); ?></div>
</div>

<?php endwhile; ?>


<?php if ( bb_is_user_logged_in() ) : ?>
<p id="get-info">
<?php foreach ( bb_get_views() as $the_view => $title ) : ?>
<a href="<?php view_link( $the_view ); ?>"><?php view_name( $the_view ); ?></a>
<?php endforeach; ?>
</p>
<?php endif; // bb_is_user_logged_in() ?>

</div>

<?php endif; // bb_forums() ?>



<div id="leftbox">

<!-- <div class="leftbox">
<h3>Video Intro</h3>

<p>

<object width="300" height="225"><param name="movie" value="http://www.youtube.com/v/1XGpdy7c8DQ&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/1XGpdy7c8DQ&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="300" height="225"></embed></object>

</p>


</div> -->






<div class="leftbox">
<h3><?php _e('Browse Hot Tags'); ?></h3>
<p id="heatmap">
<?php bb_tag_heat_map( 9, 24, 'pt', 55 ); ?>
</p>

<p id="get-info">
<a href="<?php bb_option('uri'); ?>tags.php">View all tags</a>
</p>

</div>

</div>
</div>