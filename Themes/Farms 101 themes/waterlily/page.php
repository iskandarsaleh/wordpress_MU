<?php get_header(); ?>

<div id="main">

<!-- end header -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<div class="main_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>

<div class="main_post">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?>
<?php the_content(__('<strong>&raquo; Continue Reading</strong>')); ?></div><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?>
<!--
	<?php trackback_rdf(); ?>
	-->



<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>


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