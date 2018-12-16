<?php get_header(); ?>

		<div id="narrowcolumn">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; /* Hack. Set $post so that the_date() works.*/ ?>
		 <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle">Archive for the '<?php echo single_cat_title(); ?>' Category</h2>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time(__('F jS, Y')); ?></h2>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?> <?php the_time('Y'); ?></h2>

	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><php _e('Search Results');?></h2>

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><php _e('Author Archive');?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><php _e('Blog Archives');?></h2>

		<?php } ?>


		<div class="navigation">
				<table>
				<tr>
					<td class="alignLeft"><?php previous_post_link('&laquo; Older: %link'); ?></td>
					<td class="alignRight"><?php next_post_link('Newer: %link &raquo;'); ?></td>
				</tr>
				</table>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
					    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
				   		<div class="entrytext"> 
						<?php echo commentpress_the_excerpt(); ?> 
						
						<!-- END entrytext --> 
						</div>
						<p class="postmetadata">
						<?php _e('Posted in ');?> <?php the_category(', ') ?> 
						<strong>|</strong>
						<?php edit_post_link(__('Edit'),'','<strong> |</strong>'); ?>  
						<?php comments_popup_link('No Comments', '1 Comment?', '% Comments'); ?></p>
					<!-- end post -->	
					</div>
					<br />
		<?php endwhile; ?>

		
		<!-- Navigation -->
			<div class="navigation">
				<table>
				<tr>
					<td class="alignLeft"><?php previous_post_link('&laquo; Older: %link'); ?></td>
					<td class="alignRight"><?php next_post_link('Newer: %link &raquo;'); ?></td>
				</tr>
				</table>
				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
			</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>
<!-- START blog_rightCol -->	
				<div id="extrawidecolumn">
					<div id="sectionContainer">
					<!-- IF NO WIDGETS, 3 sidebars. IF WIDGETS, 1 wide column, and floated widgets -->
						
						 <ul class="<?php echo ( function_exists('dynamic_sidebar')) ? "wideSidebar" : "sidebar" ?>"> 
							<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('widgets1') ) : ?>
							<li class="section"> 
								<h3 class="sansRed">Browse Comments</h3> 
								<ul class="sidebarList"> 
									<li><a href="<?php bloginfo('url'); ?>/comments-by-user/" class="sidebarLink">by Commenter</a></li> 
									<li><a href="<?php bloginfo('url'); ?>/comments-by-section/" class="sidebarLink">by Post</a></li> 
									<li><a href="<?php bloginfo('url'); ?>/general-comments/" class="sidebarLink">General Comments</a></li>
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
						<?php endif; ?>
						</ul>						
		<!-- END pages_rightCol -->	
				</div>
				</div>

<?php get_footer(); ?>