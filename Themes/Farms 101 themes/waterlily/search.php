<?php get_header(); ?>

<div id="main">
<h2>Search This Site:</h2><br />
<form method="get" action="<?php echo $PHP_SELF; ?>" />
<input type="text" name="s" id="s" />&nbsp;&nbsp;
<input type="submit" id="button" name="submit" value="Go!" />
</form><br />
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<div class="archive_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>

<div class="main_post">
<?php the_excerpt(__('Continue Reading &raquo;')); ?><br />
<?php _e('Posted at:');?> <?php the_time('F jS, Y - g:i a');?> - <?php comments_popup_link(__('Number of Comments &raquo; 0'), __('Number of Comments &raquo; 1'), __('Number of Comments &raquo; %')); ?><hr />
</div>




<!--
	<?php trackback_rdf(); ?>
	-->



<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<div class="navi" align="right"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></div>
</div> 


<div id="menu">
<?php get_sidebar(); ?>
</div>

</div>
<div class="clearfix"></div>
<div id="footer"><?php get_footer(); ?></div>
</div>

</body>
</html>