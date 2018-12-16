<?php get_header(); ?>
<div id="main">

<!-- end header -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<div class="main_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>

<div class="main_post">

<<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?><?php the_content(__('<strong>&raquo; Continue Reading</strong>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280shadow"); } ?></div>
<div class="main_feedback"><?php the_time(__('F jS, Y'));?> <?php _e('at');?> <?php the_time() ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?></div>

<!--
	<?php trackback_rdf(); ?>
	-->
<?php comments_template(); // Get wp-comments.php template ?>


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