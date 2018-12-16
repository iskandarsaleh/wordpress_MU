<?php get_header();?>
		<div id="content">		
			<!-- primary content start -->
			<?php if ($posts) {
				$AsideId = get_settings('terrafirma_asideid');
				function stupid_hack($str)
				{
					return preg_replace('|</ul>\s*<ul class="asides">|', '', $str);
				}
				ob_start('stupid_hack');
				foreach($posts as $post)
				{
					start_wp();
				?>
				<?php if ( in_category($AsideId) && !is_single() ) : ?>
					<ul class="asides">
						<li id="p<?php the_ID(); ?>">
							<?php echo wptexturize($post->post_content); ?>							
							<br/>
							<?php comments_popup_link('(0)', '(1)','(%)')?>  | <a href="<?php the_permalink(); ?>" title="Permalink: <?php echo wptexturize(strip_tags(stripslashes($post->post_title), '')); ?>" rel="bookmark">#</a> <?php edit_post_link('(edit)'); ?>
						</li>						
					</ul>
					<?php else: // If it's a regular post or a permalink page ?>
						<div class="post" id="post-<?php the_ID(); ?>">
							<div class="header">
								<div class="date"><em class="user"><?php the_author() ?></em> <br/><em class="postdate"><?php the_time('M jS, Y') ?></em></div>
								<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
							</div>
							<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
								<?php the_content('Continue Reading &raquo;'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							</div>
							<div class="footer">
								<ul>
									<li class="readmore"><?php the_category(' , ') ?><?php the_tags( '&nbsp;' . __( 'tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link('Edit'); ?></li>
									<li class="comments"><?php comments_popup_link('Comments(0)', 'Comments(1)', 'Comments(%)'); ?></li>						
								</ul>
							</div>				
						</div>	
					<?php endif; // end if in category ?>
				<?php
				}
			}
			else
			{
				echo '<p>Sorry, No Posts matched your criteria.</p>';
			}
		?>
		<p align="center"><?php posts_nav_link(' - ','&#171; Prev','Next &#187;') ?></p>		
		<!-- primary content end -->	
		</div>		
	<?php get_sidebar();?>	
<?php get_footer();?>