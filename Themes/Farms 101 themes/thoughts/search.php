<?php get_header(); ?>

<div id="main">
Searching for something in particular?  Enter your keywords below:
<form id="searchform" method="get" action="<?php echo $PHP_SELF; ?>">
<input type="text" name="s" id="s" size="15" />&nbsp;<input type="submit" id="b" name="submit" value="<?php _e('Go!'); ?>" />
</form><br />

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<h1 class="main_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
<?php comments_popup_link(__('Number of Comments &raquo; 0'), __('Number of Comments &raquo; 1'), __('Number of Comments &raquo; %')); ?>

<div class="main_post">

<?php the_excerpt(__('&raquo; Read The Rest')); ?>
</div>


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<div class="navi"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></div>
</div> 


<div id="sidebar">
<?php get_sidebar(); ?>
</div>

</div>
<div id="frame2"><div id="footer"><?php get_footer(); ?></div></div>
</div>

</body>
</html>
