<?php get_header(); ?>

<div id="content" class="narrowcolumn">
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
  <h2 class="pagetitle"><php _e('Search Results');?></h2>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link(__('&larr; Previous Entries')) ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link(__('Next Entries &rarr;')) ?>
    </div>
    <br class="clear" />
  </div>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post">
    <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
	  	  <p class="postmeta">
	  <span class="timr">
      Post <?php _e('on');?> <?php the_time(__('F jS, Y')) ?>
      </span>
       by <?php the_author() ?>
	  </a>
 </p><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
     <?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
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
  <h2 class="center"><?php _e('No posts found. Try a different search?');?></h2>
  <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
