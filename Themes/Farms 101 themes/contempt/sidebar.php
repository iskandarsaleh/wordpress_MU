	<div id="sidebar">
		<ul>
		
<br />
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-contempt-sidebar"); } ?>

			<li>
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p><?php _e('You are currently browsing the archives for the','contempt'); ?> <?php single_cat_title(''); ?><?php _e(' category.','contempt'); ?></p>
			
			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p><?php _e('You are currently browsing the','contempt'); ?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> 
			<?php _e('weblog archives for the day','contempt'); ?> <?php the_time(__('l, F jS, Y','contempt')); ?>.</p>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p><?php _e('You are currently browsing the','contempt'); ?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> 
			<?php _e('weblog archives for','contempt'); ?> <?php the_time(__('F, Y','contempt')); ?>.</p>

             <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p><?php _e('You are currently browsing the','contempt'); ?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> 
			<?php _e('weblog archives for the year','contempt'); ?> <?php the_time('Y'); ?>.</p>
			
		    <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p><?php _e('You have searched the','contempt'); ?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> 
			<?php _e('weblog archives for ','contempt'); ?><strong>'<?php echo wp_specialchars($s); ?>'</strong><?php _e('. If you are unable to find anything in these search results, you can try one of these links.','contempt'); ?></p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p><?php _e('You are currently browsing the','contempt'); ?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives.','contempt'); ?></p>

			<?php } ?>
			</li>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
		</ul>
	</div>
<?php return; endif; ?>
			<?php
			// Remove the comments and php tags around this to add an image of you
			/*
			<li><h2>About</h2>
			<p class="about"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/my_photo.jpg" alt="Me" />
			<br />
				<a href="mailto:my@email" title="Email me">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog/figure_ver1.gif" alt="" /> <b>My Name</b>
				</a>
				<br />
				This is my personal blog about anything that interests me...
			</p>
			</li>	
			*/ ?>		
			

			<li><h2><?php _e('Archives','contempt'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories','contempt'); ?></h2>
				<ul>
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
				</ul>
			</li>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>				
				<?php get_links_list(); ?>
				
				<li><h2><?php _e('Meta','contempt'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional','contempt'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>','contempt'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
					<li><a href="http://<?php _e('wordpress.org','contempt'); ?>/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','contempt'); ?>"><?php _e('WordPress.org','contempt'); ?></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>
			
		</ul>
	</div>