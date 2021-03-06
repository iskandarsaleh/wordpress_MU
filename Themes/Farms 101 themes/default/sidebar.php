	<div id="sidebar">
		<ul>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-default-sidebars"); } ?>
			<?php 	/* Widgetized sidebar, if you have the plugin installed. */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>

			

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
			

				<li><h2><?php _e('Meta');?> </h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
<!--							eleni comment on 19/2/08		<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
					<?php $current_site = get_current_site(); ?>
		<li><a href="http://<?php echo $current_sitdomain . $current_sitpath ?>wp-signup.php" title="Create a new blog">New Blog</a></li>-->
					<li><a href="http://<?php echo $current_site->domain . $current_site->path ?>" title="<?php echo $current_site->site_name ?>"><?php echo $current_site->site_name ?></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
				
			<?php } ?>
			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2><?php _e('Author');?></h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php if ( is_404() || is_category() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?> <li>

			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p><?php single_cat_title(''); ?>.</p>

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p><?php _e('You are currently browsing the');?>  <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a>
			<?php _e('for the day');?> <?php the_time(__('l, F jS, Y')); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> 
			<?php _e('for');?> <?php the_time('F, Y'); ?>.</p>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('Blog Archives'); ?><?php the_time('Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p><?php _e('You have searched the ');?> <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('Blog Archives'); ?>
<?php _e('for');?>			 <strong>'<?php the_search_query(); ?>'</strong>. 
			<?php _e('If you are unable to find anything in these search results, you can try one of these links.');?> </p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('Blog Archives'); ?>.</p>

			<?php } ?>

			</li> <?php }?>

			<?php wp_list_pages('title_li=<h2>'.__('Pages').'</h2>' ); ?>

			<li><h2><?php _e('Archives');?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<?php wp_list_categories('show_count=1&title_li=<h2>'.__('Categories').'</h2>'); ?>
	
						<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
			
			<?php wp_list_bookmarks(); ?>
			<?php } ?>
			<?php endif; ?>
		</ul>
	</div>

