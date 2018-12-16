<?php get_header(); ?>

<div id="content" class="widecolumn">
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


  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="navigation">
    <div class="alignleft">
      <?php previous_post_link('&larr; %link') ?>
    </div>
    <div class="alignright">
      <?php next_post_link('%link &rarr;') ?>
    </div>
  </div>
  <br class="clear" />
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>">
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
      <?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
      <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
   <p class="postmetadata">
      Category 
      <span class="catr">
      <?php the_category(', ') ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      <span class="commr">
      <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
      </span></p>
  </div>
  <?php comments_template(); ?>
  <?php endwhile; else: ?>
  <p><?php _e('Sorry, no posts matched your criteria.');?></p>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
