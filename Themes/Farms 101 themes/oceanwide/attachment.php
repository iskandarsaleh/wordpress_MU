<?php get_header(); ?>





  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>

<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>



				<div class="item_class" id="post-<?php the_ID(); ?>">

					<div class="item_class_title">

						<div class="item_class_title_text">

						

							<div class="date">

								<div class="date_month"><?php the_time('M') ?></div>

								<div class="date_day"><?php the_time('d') ?></div>

							</div>

							<div class="titles">

								<div class="top_title"><h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1></div>

								<div class="end_title">Filed Under (<?php the_category(', ') ?>) by <?php the_author() ?> <?php _e('on');?> <?php the_time('d-m-Y') ?></div>

							</div>

							

						</div>

					</div>

					<div class="item_class_text">

					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__('Read the rest of this entry &raquo;')); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
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



	<?php comments_template(); ?>



	<?php endwhile; else: ?>



		<div id="content" class="narrowcolumn"><p><?php _e('Sorry, no attachments matched your criteria.');?></p>

							<?php _e('Both comments and pings are currently closed.');?></div>



<?php endif; ?>



<?php get_footer(); ?>

