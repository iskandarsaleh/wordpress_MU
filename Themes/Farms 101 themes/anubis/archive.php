<?php get_header(); ?>
<div id="left">
<div id="content" class="narrowcolumn">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-anubis-top"); } ?>
  <?php if (have_posts()) : ?>
  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
  <?php /* If this is a category archive */ if (is_category()) { ?>
  <h2 class="pagetitle"><?php _e('Archive for the');?> &#8216;<?php echo single_cat_title(); ?>&#8217;</h2>
  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
  <h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?>
  </h2>
  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
  <h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?>
  </h2>
  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
  <h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('Y'); ?>
  </h2>
  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
  <h2 class="pagetitle"><?php _e('Author Archive');?></h2>
  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2 class="pagetitle"><?php _e('Blog Archives');?></h2>
    <?php } ?>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link(__('&larr; Previous Entries')) ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link(__('Next Entries &rarr;')) ?>
    </div>
  </div>
  <br class="clear" />
  <?php while (have_posts()) : the_post(); ?>
  <div class="post">
   <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h2>
    <div class="entry">
      <?php the_content() ?>
    </div>
	<p class="postmetadata">
      Posted on <!--<?php the_author() ?>--> on <span class="timr"><?php the_time(__('F jS, Y')) ?></span> in
	  <span class="catr">
      <?php the_category(', ') ?>
      </span> |
      <?php edit_post_link(__('Edit'), '<span class="editr">', ' | </span>'); ?>
      <span class="commr">
      <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
      </span></p> 
  </div>
  <?php endwhile; ?>
  <div class="navigation">
    <div class="alignleft">
      <?php next_posts_link(__('&laquo; Previous Entries')) ?>
    </div>
    <div class="alignright">
      <?php previous_posts_link(__('Next Entries &raquo;')) ?>
    </div>
  </div>
  <?php else : ?>
  <h2 class="center"><?php _e('Not Found');?></h2>
  <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
