<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="right-sidebar">



<?php if($tn_wpmu_dixi_show_profile == "yes"){ ?>
<?php include (TEMPLATEPATH . '/profiles.php'); ?>
<?php } ?>




<ul class="list">


<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Right-Sidebar') ) : ?>

<li>
<h3><?php _e('Recent Articles'); ?></h3>
<ul>
<?php get_archives('postbypost', 10); ?>
</ul>
</li>



<?php if(function_exists("akpc_most_popular")) : ?>
<li>
<h3><?php _e('Most Popular'); ?></h3>
<ul>
<?php akpc_most_popular(); ?>
</ul></li>
<?php endif; ?>


<?php if (function_exists('get_most_viewed')): ?>
<li>
<h3>Most Viewed Post</h3>
<ul><?php get_most_viewed(); ?></ul>
<li>
<?php endif; ?>


<?php if(function_exists("wp_tag_cloud")) { ?>
<li>
<h3><?php _e('Popular Tags'); ?></h3>
<ul>
<li>
<?php wp_tag_cloud('smallest=10&largest=20&'); ?>
</li>
</ul>
</li>
<?php } ?>



<li>
<h3><?php _e('Recent Comments'); ?></h3>
<ul class="list">
<?php get_avatar_recent_comment($avatar_size='32'); ?>
</ul>
</li>



<?php if(function_exists("get_hottopics")) : ?>
<li>
<h3><?php _e('Most Commented'); ?></h3>
<ul class="list">
<?php get_hottopics(); ?>
</ul>
</li>
<?php endif; ?>


<?php endif; ?>

</ul>




</div>