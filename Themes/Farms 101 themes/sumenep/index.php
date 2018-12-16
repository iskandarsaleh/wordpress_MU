<?php get_header(); ?>

<div id="content">
<div id="pre">
  <div id="headr">
    <h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?>
      </a></h1>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>
</div>

  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
	  <p class="postmeta">
	  <span class="timr">
      Post <?php _e('on');?> <?php the_time(__('F jS, Y')) ?>
      </span>
       by <?php the_author() ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?>
	  </a>
 </p>
 <div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
      <?php the_content('Read the rest of this entry &rarr;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
    </div>
	<p class="postmetadata">
      Category
	  <span class="catr">
      <?php the_category(', ') ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      <span class="commr">
      <?php comments_popup_link('No Comments &rarr;', '1 Comment &rarr;', '% Comments &rarr;'); ?>
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
