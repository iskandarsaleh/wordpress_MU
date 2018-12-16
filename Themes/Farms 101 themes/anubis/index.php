<?php get_header(); ?>

<div id="left">
<div id="content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-anubis-top"); } ?>
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
   <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
 	  <div class="entry">
      <?php the_content(__('Read the rest of this entry &raquo;')); ?>
    </div>
 <p class="postmetadata">
      Posted on <!--<?php the_author() ?>--> on <span class="timr"><?php the_time(__('F jS, Y')) ?></span> in
	  <span class="catr">
      <?php the_category(', ') ?>&nbsp;&nbsp;<?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      <span class="commr">
      <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
      </span></p> 
 </div>
  <?php endwhile; ?>
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
