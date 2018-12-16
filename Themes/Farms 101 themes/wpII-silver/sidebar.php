	<div id="sidebar"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
		<ul>
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
			<?php _e('for');?> <strong>'<?php the_search_query(); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.');?></p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p>

			<?php } ?>
			</li>

			<li id="search"><h3><?php _e('Search'); ?></h3>
				<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
					<input type="text" name="s" id="s" size="15" />
					<input type="submit" value="<?php _e('Search'); ?>" />
				</form>
			</li>


	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>

			<!--<li>
				<?php //include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>-->

			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h3>Author</h3>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php wp_list_pages('title_li=<h3>'.__('Pages').'</h3>' ); ?>

			<li><h3><?php _e('Archives');?></h3>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<?php //wp_list_categories('optioncount=1&title_li=<h3>Categories</h3>'); ?>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php //wp_list_bookmarks(); ?>

				<li><h3><?php _e('Meta')?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
					<!-- Please do link back for support this theme design, thanks-->
					<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
					<li><a href="http://blogates.com/" title="<?php _e('Get free wordpress blog host'); ?>">Free Blog Host</a></li>
					<li><a href="http://doogate.com/" title="<?php _e('Web search engine'); ?>">Search Engine</a></li>
					<li><a href="http://amazon.evled.com/" title="<?php _e('Online shoping and products portal'); ?>">Shopping Portal</a></li>
					<li><a href="http://pingates.com/" title="<?php _e('Share your blog'); ?>">Blog Ping</a></li>
					<!-- Please do link back for support this theme design, thanks-->
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>
	<?php endif; ?>

		</ul>
	</div>