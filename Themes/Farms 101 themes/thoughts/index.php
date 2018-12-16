<?php get_header(); ?>
<div id="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<h1 class="main_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>

<div class="main_post">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<?php the_content(__('<strong>&raquo; Continue Reading</strong>')); ?></div><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
<div class="main_feedback">
<?php the_time(__('F jS, Y'));?> <?php _e('at');?> <?php the_time() ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?>&nbsp;|&nbsp;<?php comments_popup_link(__('Comments &amp; Trackbacks (0)'), __('Comments &amp; Trackbacks (1)'), __('Comments &amp; Trackbacks (%)')); ?>&nbsp;|&nbsp;<a href="<?php the_permalink() ?>" rel="bookmark"><?php _e('Permalink');?></a> </div>


<br /><br />
<!--
	<?php trackback_rdf(); ?>
	-->
<?php comments_template(); // Get wp-comments.php template ?>


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<div class="navi" align="right"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></div>

</div> 


<div id="sidebar">
<?php get_sidebar(); ?>
</div>

</div>
<div id="frame2"><div id="footer"><?php get_footer(); ?></div></div>
</div>

</body>
</html>
