<?php 
get_header();
?>
<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><?php the_date() ?></h2>
<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<div class="postbyline">
by <a href="mailto:<?php the_author_email() ?>"><?php the_author() ?></a><br />
</div><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<?php the_content(__('Read more &#187;')); ?><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<div class="postfooter">
<?php _e('Filed under');?> <?php the_category(' and ','single',' &#187; ') ?> <?php _e('at');?> <?php the_time() ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?>
 <?php edit_post_link(__('Edit This')); ?><br />
<?php
wp_link_pages();
?>
	<!--
	<?php trackback_rdf(); ?>
	-->
</div>
<?php comments_template(); // Get wp-comments.php template ?>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<div class="pageFooter">
<?php posts_nav_link(' ', __('<img class="navLast" src="/wp-content/images/last.gif" alt="Next" />'), __('<img class="navNext" src="/wp-content/images/next.gif" alt="Next" />')); ?>
</div>
</div>

<?php get_footer(); ?>