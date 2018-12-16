	<div id="sidebar">
		<ul>

			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>

			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<li>
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p><?php _e('You are currently browsing the archives for the');?> <?php single_cat_title(''); ?> <?php _e('category.');?></p>

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p>

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			for <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for the year');?> <?php the_time('Y'); ?>.</p>

		 <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p><?php _e('You have searched the');?> <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.');?></p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p>

			<?php } ?>
			</li>

			<?php wp_list_pages('title_li=<h2>'.__('Pages').'</h2>' ); ?>

			<li><h2><?php _e('Archives');?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<?php wp_list_categories('optioncount=1&hierarchical=0&title_li=<h2>'.__('Categories').'</h2>'); ?>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>

				<li><h2><?php _e('Meta');?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
					<?php $current_site = get_current_site(); ?>
					<li><a href="http://<?php echo $current_site->domain . $current_site->path ?>wp-signup.php" title="<?php _e('Create a new blog');?>"><?php _e('New Blog');?></a></li>
					<li><a href="http://<?php echo $current_site->domain . $current_site->path ?>" title="<?php echo $current_site->site_name ?>"><?php echo $current_site->site_name ?></a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>

		</ul>
	</div>

