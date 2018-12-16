<?php get_header(); ?>

<div id="content">
  <?php if (have_posts()) : 
	$i = 1; 
  ?>
    <?php while (have_posts()) : the_post(); ?>
  <div class="post<?php if ($i == 1) { echo' new'; } ?>" id="post-<?php the_ID(); ?>">
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
	<p class="postmetadata"><span class="timr">
      <?php the_time(__('F jS, Y')) ?>
      </span>
      <span class="user">by <?php the_author() ?> </span>
    </p>  
	<br class="clear" />
    <div class="entry">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
      <?php the_content(__('Read the rest of this entry &raquo;')); ?>
	  <?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
    </div>
  <p class="postmetadata">
	  <span class="catr">
      Category <?php the_category(', ') ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      <span class="commr">
      <?php comments_popup_link('No Comments &rarr;', '1 Comment &rarr;', '% Comments &rarr;'); ?> <?php the_tags( '&nbsp;' . __( '| Tagged' ) . ' ', ', ', ''); ?>
      </span></p>
  </div>
  <?php 
	$i = $i + 1;
  endwhile; ?>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link(__('&larr; Previous Entries')) ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link(__('Next Entries &rarr;')) ?>
    </div>
  </div>
  <?php else : ?>
  <h2 class="center"><?php _e('Not Found');?></h2>
  <p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
  <?php include (TEMPLATEPATH . "/searchform.php"); ?>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
