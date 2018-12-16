<?php get_header(); 
	$siteurl = get_settings('siteurl');
?>
		<!-- START Loop --> 	
		
		<!-- START THE PAGE -->
		<!-- already in pageContainer -->
		<div id="narrowcolumn"> 
		<?php $i = 0; ?>
		<?php if (have_posts()) : ?>

		 <?php if (($wp_query->post_count) > 1) : ?>
			<?php while (have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>">
				   <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
				   <div class="entrytext"> 
				   <?= commentpress_the_excerpt(); ?> 
				   
				   <!-- END entrytext --> 
				   </div>
				   <p class="postmetadata"><?php _e('Posted by');?> <?php the_author() ?> 
				   <strong>|</strong>
				   <?php edit_post_link(__('Edit'),'','<strong> |</strong>'); ?>  
				   <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></p>
			   <!-- end post -->	
			   </div>
					
		<!-- END Loop --> 
		<?php endwhile; ?>
		<?php endif; /* end post_count > 1 if */?>
		<?php endif; ?>	
		

				</div>
		<!-- START blog_rightCol -->	
				<div id="extrawidecolumn">
					<div style="padding-left: 10px; line-height: 1.35em; margin-right: 10px;">
					

				<?php
				$id = getPostID(get_option('commentpress_welcome_message'));
				$post = get_post($id); 
				?>
					<h3 class="sansRed"><?php echo $post->post_title; ?></h3>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					<p><?php echo $thecontent = balancetags(wpautop($post->post_content)); ?></p>
					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					<div class="divider"></div>
					</div>
					<br />
					<div id="sectionContainer">
					
						<!-- IF NO WIDGETS, 3 sidebars. IF WIDGETS, 1 wide column, and floated widgets -->
						
						 <ul class="<?php echo ( function_exists('dynamic_sidebar')) ? "wideSidebar" : "sidebar" ?>"> 
							<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('widgets1') ) : ?>
							<li class="section"> 
								<h3 class="sansRed">Browse Comments</h3> 
								<ul class="sidebarList"> 
									<? $siteurl = get_settings('siteurl'); ?>
									<li><a href="<?= $siteurl."/comments-by-user" ?>" class="sidebarLink">by Commenter</a></li> 
									<li><a href="<?= $siteurl."/comments-by-section" ?>" class="sidebarLink">by Post</a></li> 
									<li><a href="<?= $siteurl."/general-comments" ?>" class="sidebarLink">General Comments</a></li>
								</ul> 
							</li> 

						<li class="section">
							<h3 class="sansRed">Identify yourself</h3> 
							<ul> 
							<?php wp_loginout(); ?>
							</ul>
						</li>
						<li class="section"> 
							<h3 class="sansRed">Recent Posts</h3> 
							<ul class="sidebarList"> 
							 <?php
								 $myposts = get_posts('numberposts=10');
								 foreach($myposts as $post) :
								 ?>
								 <li class="sidebarLink"><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></li>
							 <?php endforeach; ?>
							</ul> 
						</li> 
					</ul>
					<ul class="sidebar">
						<li class="section">
							<h3 class="sansRed"><?php _e('Archives');?></h3>
							<ul class="sidebarList"> 
								 <?php wp_get_archives(); ?>
							</ul>
						</li>
						<li class="section">
						<h3 class="sansRed"><?php _e('Categories');?></h3> 
							<ul class="sidebarList"> 
								 <?php wp_list_categories('title_li='); ?>
							</ul>	
						</li>
					</ul>
					<ul class="sidebar">
					<li class="section">
						<h3 class="sansRed"><?php _e('Recent Comments'); ?></h3> 
							<ul class="sidebarList"> 
						<?php if (function_exists('get_recent_comments')) { ?>
							  	 	<?php get_recent_comments(); ?>
						<?php } else {?>
									<?php $recent_comments = getRecentComments();
					
									foreach($recent_comments as $c){
									?>
									<li class="sidebarLink"><a href="<?= get_permalink($c->comment_post_ID); ?>#<?= $c->comment_contentIndex; ?>"><?php echo $c->post_title."</a><br /><i>".$c->comment_author; ?> <?php _e('says');?>: </i><?php echo (strlen($c->comment_content) > 90) ? substr(strip_tags($c->comment_content),0 , 90) . "<a href=\"".get_permalink($c->comment_post_ID)."#". $c->comment_contentIndex."\">[...]</a>" : strip_tags($c->comment_content); ?>
						<?php } 
						}
						?>
							</ul>
						</li> 	
						<li class="section">
						<h3 class="sansRed"><?php _e('Links');?></h3> 
							<ul class="sidebarList"> 
					<?php get_links('-1', '<li>', '</li>', '', FALSE, 'name', FALSE, 
					FALSE, -1, FALSE, TRUE); ?>
							</ul>
						</li>
						<?php endif; ?>
						</ul>
						
					<br class="clear">						
						
					</div>
		<!-- END pages_rightCol -->	
					</div>

		<?php get_footer(); ?>
		<!-- END mainContainer --> 
		</div> 



