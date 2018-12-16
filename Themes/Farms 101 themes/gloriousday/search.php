<?php get_header();?>
<div id="main">
	<div id="content">
      <h2>Search Results for "<?php echo $s; ?>"</h2>
	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	        <div class="post" id="post-<?php the_ID(); ?>">
            <p class="box right">
              <span class="month">
                <?php the_time('M') ?>
              </span>
              <span class="day">
                <?php the_time('d') ?>
              </span>
              <span class="year">
                <?php the_time('Y') ?>
              </span>
            </p>
            <p class="box left"><img src="<?php bloginfo('stylesheet_directory');?>/img/<?php the_author_login();?>.jpg" alt="Profile Image of <?php the_author();?>" title="Profile Image of <?php the_author();?>" /><br/><?php the_author_posts_link(); ?></p>
            <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="meta">
				      <p><?php _e('Filed under');?> <?php the_category(',') ?> <?php edit_post_link(); ?></p>
			      </div>
			      <div class="entry">
						<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Continue Reading &#187;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
						<?php wp_link_pages(); ?>
						<p class="post-tags"><?php if (function_exists('the_tags')) the_tags(__('Tags: '), ', ', '<br/>'); ?></p>
      			</div>
            <p class="comments">
              <?php comments_popup_link(__('No responses yet'), __('One response so far'), __('% responses so far')); ?>
            </p>	          
	        </div>
      <?php endwhile; else: ?>
          <p><?php _e('Sorry, Your search did not find any posts on this site. Please use a different keyword.'); ?></p>
      <?php endif; ?>
    <p align="center">
      <?php posts_nav_link(' - ',__('&#171; Newer Posts'),__('Older Posts &#187;')) ?>
    </p>
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>