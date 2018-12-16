<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-top"); } ?>
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="postwrapper wideposts" id="post-<?php the_ID(); ?>">
			  <div class="title">

				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>

                   <small>Posted by: <strong><?php the_author() ?></strong> | <?php the_time(get_option('date_format')) ?> <span class="comment-a"><?php comments_popup_link('| No Comment', '| 1 Comment', '| % Comments'); ?></span> | <?php edit_post_link('(edit)'); ?></small>

			  </div>
			  <div class="post">
			    <div class="entry">
			    
				<?php the_content(__('Read More...')); ?>

	</div>


                <div class="entry-cat">
                <?php _e('under:'); ?>&nbsp;<?php the_category(', ') ?><br />
                <?php if(function_exists("the_tags")) : ?><?php the_tags('Tags: ', ', ', '<br />'); ?><?php endif; ?>
                </div>

			  </div>
			</div>
	
		<?php endwhile; ?>
		<p align="center"><?php posts_nav_link(' - ','&#171; Newer Posts','Older Posts &#187;') ?></p>
	<?php else : ?>

		<div class="title">
		  <h2>Not Found</h2>
		</div>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-bottom"); } ?>
	<div class="title">
	  <h2>Categories</h2>
	</div>
	<div class="post">
	  <ul class="catlist">
        <?php wp_list_cats('sort_column=name&hide_empty=0'); ?>	
	  </ul>
	</div>
  </div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
