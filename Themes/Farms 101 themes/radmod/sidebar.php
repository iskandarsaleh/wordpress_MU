	<div id="sidebar">
		<ul>	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("18090linkunitshadow"); } ?><?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?><!--
			<li><h2><?php _e('Author'); ?></h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<li>
			<?php /* If this is a category archive */ if (is_category()) { ?>
			<p><?php _e('You are currently browsing the archives for the');?> <?php single_cat_title(''); ?> <?php _e('category.');?></p>
			
			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			for <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for the year');?> <?php the_time('Y'); ?>.</p>
			
		 <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p><?php _e('You have searched the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
			<?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.');?></p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p>

			<?php } ?>
			</li>

			<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>

			<li><h2><?php _e('Archives'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories'); ?></h2>
				<ul id="categories">
				<?php wp_list_cats('sort_column=name'); ?>								
				</ul>
			</li>
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>
			<!--			
			Requires Krischan Jodies' Get Recent Comments plug-in, which you can get at:
			http://blog.jodies.de/archiv/2004/11/13/recent-comments/
			-->			
			
			<?php if (function_exists('get_recent_comments')) { ?>
				<li><h2><?php _e('Recent Comments');?></h2>
				<ul id="recentComments">
				<?php get_recent_comments(5,25,'<li><a href="%comment_link"><strong>%comment_author</strong>: %comment_excerpt</a></li>'); ?>
				</ul>
				</li>
			<?php } ?>
			
			<?php /* If this is the frontpage */ if ( is_home() ) { ?>				
				
				<li><h2><?php _e('Links');?></h2><ul id="links"><?php get_links_list(); ?></ul></li>				

			<?php } ?>
			
			<?php if (function_exists('wp_theme_switcher')) { ?>
				<li><h2><?php _e('Themes'); ?></h2>
				<?php wp_theme_switcher(); ?>
				</li>
			<?php } ?>
			
			<li id="poweredByWordpress"><?php _e('Powered by');?> <a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress</a><br />
			<?php wp_meta(); ?>			
			<br />			
			<a href="feed:<?php bloginfo('rss2_url'); ?>">Entries RSS</a><br />
			<a href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a><br /><br />
			RadMod theme <?php _e('designed by');?> <a href="http://www.radicalgeorgiamoderate.org/">Rusty</a><br /><nr />
			Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
			</li>			
<?php endif; ?>		</ul>
<div class="filler"></div>
	</div>
