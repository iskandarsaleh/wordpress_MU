<?php 
get_header();
?>

<div id="content">
<!--
You can post an announcement that will linger at the top of your blog here if you'd like.
Just uncomment the DIV tag below and enter your text.
-->
<!--
<div id="announcement">ANNOUNCEMENT TEXT GOES HERE</div>
-->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><?php the_date() ?></h2>
<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<div class="postbyline">
by <a href="mailto:<?php the_author_email() ?>"><?php the_author() ?></a><br />
</div><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<?php the_content(__('Read more &#187;')); ?><div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?></div>
<div class="postfooter">
<?php _e('Filed under');?> <?php the_category(' and ','single',' &#187; ') ?> <?php _e('at');?> <?php the_time() ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?><br />
<?php edit_post_link(__('Edit'), '','<strong>| </strong>'); ?><?php comments_popup_link(__('Add a comment &#187;'), __('1 comment &#187;'), __('% comments &#187;')); ?>
<br />
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
<?php posts_nav_link(' ', __('<div class="navLast"></div>'), __('<div class="navNext"></div>')); ?>
</div>
</div>

<?php get_footer(); ?>