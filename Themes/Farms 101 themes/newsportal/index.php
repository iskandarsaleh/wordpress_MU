<?php get_header(); ?>

<?php get_sidebar(); ?>



  <div id="content">
  
 
        

  
  <!-- begin content --><div id="first-time">
			
<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>

<?php the_time(__('F jS, Y')) ?> <?php _e('by');?> <?php the_author() ?> <?php the_tags( '' . __( 'and tagged' ) . ' ', ', ', ''); ?>

<div class="entry">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
</div>

<p class="info"><?php _e('Posted in ');?> <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link(__('Edit'), '','<strong>|</strong>'); ?> <?php comments_popup_link('No Comments &raquo;', '1 Comment &raquo;', '% Comments &raquo;'); ?></p>

</div>

<?php comments_template(); ?>

<?php endwhile; ?>

<p align="center"><?php next_posts_link(__('&laquo; Previous Entries')) ?> <?php previous_posts_link(__('Next Entries &raquo;')) ?></p>

<?php else : ?>

<h2 align="center"><?php _e('Not Found');?></h2>

<p align="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>

<?php endif; ?>
			
			
	  </div><!-- end content --> 

	  </div>

	  <?php get_footer(); ?>
</div>
</body>
</html>
