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

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2>
      <?php the_title(); ?>
    </h2>
    <div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
      <?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
      <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    </div>
  </div>
  <?php endwhile; endif; ?>
  <?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
