<?php 
get_header();
?>

<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<!--
<div class="postbyline">
  by <a href="mailto:<?php // the_author_email() ?>"><?php // the_author() ?></a>
</div>
--><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<?php the_content(__('Read more &#187;')); ?><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<div class="postfooter">
<?php
wp_link_pages();
?>
	<!--
	<?php trackback_rdf(); ?>
	-->
<?php edit_post_link(__('Edit This')); ?>
</div>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<div class="pageFooter">
<?php posts_nav_link(' ', __('<div class="navLast"></div>'), __('<div class="navNext"></div>')); ?>
</div>
</div>

<?php get_footer(); ?>