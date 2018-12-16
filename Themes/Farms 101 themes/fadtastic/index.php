<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); $loopcounter++; ?>
				<?php if ($loopcounter == 1) { ?>
				<h1 id="post-<?php the_ID(); ?>" ><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<p class="author fresh" >Posted on <em><?php the_time(get_option('date_format')) ?><?php the_tags( ' &#183;' . __( 'Tagged' ) . ' ', ', ', ''); ?></em>.</p>
				
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

				<big>
					<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>">Read Full Post</a></strong> | 
					<strong>
						<?php if ('open' == $post->comment_status) : ?> 
						<a href="<?php the_permalink() ?>#respond" title="Make a comment">Make a Comment</a>
						<?php else : ?> 
						Comments are Closed
						<?php endif;?>
					</strong> 
					<small>
						<?php if ('open' == $post->comment_status) : ?> 
						 ( <strong><?php comments_popup_link('None', '1', '%'); ?></strong> so far )
						<?php endif; ?>
					</small>
				</big>
				<?php } ?>
				<?php endwhile; ?>
								
				<?php else : ?>

				<h2><?php _e('Not Found');?></h2>
				<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>
				
				<!-- Minor posts start here -->
				
				<h2 class="recently">Recently <?php _e('on');?> <?php bloginfo('name'); ?>...</h2>
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); $loop2counter++; ?>
				<?php if ($loop2counter > 1 and $loop2counter < 10 ) { ?>
				
				<div class="recent_post">
					<h2 id="post-<?php the_ID(); ?>" ><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<p class="author" >Posted on <em><?php the_time(get_option('date_format')) ?></em>.</p>
				</div>
				<?php } ?>
				<?php endwhile; ?>
								
				<?php else : ?>

				<h2><?php _e('Not Found');?></h2>
				<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			
				<?php endif; ?>

			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
