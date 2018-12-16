<?php get_header(); ?>

	<div id="content">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-top"); } ?>
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
			<div class="postwrapper wideposts" id="post-<?php the_ID(); ?>">


             <div class="title">

				<h2><?php the_title(); ?></h2>

                   <small>Posted by: <strong><?php the_author() ?></strong> | <?php the_time(get_option('date_format')) ?> <span class="comment-a"><?php comments_popup_link('| No Comment', '| 1 Comment', '| % Comments'); ?></span> | <?php edit_post_link('(edit)'); ?></small>

			  </div>



			  <div class="post">
			    <div class="entry">
			
			      <?php the_content(''); ?>
				 
				  <?php wp_link_pages('<p class="pages">Pages: ', '</p>', '', '', '', ''); ?>
		        </div>

                <div class="entry-cat">
                <?php _e('under:'); ?>&nbsp;<?php the_category(', ') ?><br />
                <?php if(function_exists("the_tags")) : ?><?php the_tags('Tags: ', ', ', '<br />'); ?><?php endif; ?>
                </div>


			  </div>


		<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
		</div>




			</div>




	<?php comments_template(); ?>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-oceanmist-bottom"); } ?>
	<?php endwhile; else: ?>
	
		<div class="title">
		  <h2>Not Found</h2>
		</div>
		<div class="post">
		<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    </div>
<?php endif; ?>


	
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
