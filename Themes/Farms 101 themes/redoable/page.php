<?php get_header(); ?>

<div class="content">

	<div id="middlecolumn">
		<div id="primary"  class="primaryPage">
			
				<div id="<?php echo $prefix; ?>primarycontent" class="hfeed">
				
					<div class="page-head">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php printf( __('Permanent Link to "%s"','redo_domain'), wp_specialchars(get_the_title(),1) ); ?>'><?php the_title(); ?></a></h2>
					</div>
					
					<div class="page-nav">
						<?php include(TEMPLATEPATH . '/navigation-page.php'); ?>
					</div>

					<?php while (have_posts()) { the_post(); ?>
				
						<div id="post-<?php the_ID(); ?>" class="<?php redo_post_class(); ?>">
							
							<div class="page-meta">

								<div class="meta-row">
									<?php /* Date & Author */
										printf(	__('%1$s','redo_domain'), sprintf(__('<span class="authordata">By %s</span>','redo_domain'), '<span class="vcard author"><a href="' . get_author_link(0, $authordata->ID, $authordata->user_nicename) .'" class="url fn">' . get_the_author() . '</a></span>') );
									?>

									<?php if(function_exists('the_ratings')) { the_ratings(); } ?>

									<?php if (function_exists('WordCount')) { ?>
										<span class="word-count"><?php echo WordCount(1, $post -> ID) . " words."; ?></span>
									<?php } ?>

									<?php if(function_exists('the_views')) { ?>
										<span class="page-views"><?php the_views(); ?></span>
									<?php } ?>

									<span class="share-link"><?php if(function_exists('akst_share_link')) { akst_share_link(); } ?></span>								
								</div>

							</div> <!-- .entry-meta -->

							<div class="entry-content page-content">
								<?php if(function_exists('show_digg_button') or function_exists('digg_button')) { echo '<div class="diggButton">'; } ?>
									<?php if(function_exists('show_digg_button')) { show_digg_button(); }
									else if(function_exists('digg_button')) { digg_button(); } ?>
								<?php if(function_exists('show_digg_button') or function_exists('digg_button')) { echo '</div>'; } ?>
								<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
								<?php the_content(); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>
								<?php if( get_bloginfo('version') < 2.1 ) { ?>
									<?php link_pages('<p><strong>'.__('Pages:','redo_domain').'</strong> ', '</p>','number'); ?>
								<?php } else { ?>
									<?php wp_link_pages('before=<p><strong>'.__('Pages:','redo_domain').'</strong>&after=</p>&next_or_number=number')?>
								<?php } ?>
							</div>

						</div> <!-- #post-ID -->
					
					<?php } // End the Loop ?>

				</div> <!-- #primarycontent .hfeed -->
			
			<?php if( get_option('redo_livesearchposition') == 1 ) { ?>
			</div> <!-- #current-content -->
			
			<div id="dynamic-content"></div>
			<?php } ?>

		</div> <!-- #primary -->
	</div>

	<?php if ( comments_open() ) comments_template(); ?>

	<div id="rightcolumn">
		<?php get_sidebar(); ?>
	</div>
	<div class="clear"></div>

</div> <!-- .content -->

<?php get_footer(); ?>
