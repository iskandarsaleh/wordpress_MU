<?php get_header(); ?>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("250x250-oceanwide-top"); } ?>

	<?php if (have_posts()) : ?>



		<?php while (have_posts()) : the_post(); ?>



				<div class="item_class" id="post-<?php the_ID(); ?>">

					<div class="item_class_title">

						<div class="item_class_title_text">

						

							<div class="date">

								<div class="date_month"><?php the_time('M') ?></div>

								<div class="date_day"><?php the_time('d') ?></div>

							</div>

							<div class="titles">

						<div class="top_title"><h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1></div>

								<div class="end_title">Filed Under (<?php the_category(', ') ?>) by <?php the_author() ?> <?php _e('on');?> <?php the_time('d-m-Y') ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?></div>

							</div>

							

						</div>

					</div>

					<div class="item_class_text">

					<?php the_content(__('Read the rest of this entry &raquo;')); ?>

					</div>

					<div class="item_class_panel">

						<div>

							<div class="links_left">

								<span class="panel_comm"><a href="<?php the_permalink() ?>#respond">Post a Comment</a></span>&nbsp;&nbsp;&nbsp;

							<?php edit_post_link(__('Edit'), '', ''); ?>

							</div>

							<div class="links_right">

								<?php comments_popup_link('(0) Comments', '(1) Comment', '(%) Comments'); ?>&nbsp;&nbsp;

								<a href="<?php the_permalink() ?>" class="panel_read">Read More</a>

							</div>

						</div>

					</div>

				</div>



		<?php endwhile; ?>

					<div class="navigation">

						<ul>

							<li class="alignleft"><?php next_posts_link('Previous Page') ?></li>

							<li class="alignright"><?php previous_posts_link('Next Page') ?></li>

						</ul>

					</div>

		



	<?php else : ?>



		<h2 class="center"><?php _e('Not Found');?></h2>

		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>

		<?php include (TEMPLATEPATH . "/searchform.php"); ?>



	<?php endif; ?>



<?php get_footer(); ?>

