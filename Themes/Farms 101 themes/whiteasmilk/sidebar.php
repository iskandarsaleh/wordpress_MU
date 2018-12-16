	<div id="sidebar"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("16090linkunitnocolor"); } ?>
		<ul>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
			<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2><?php _e('Author'); ?></h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
			</li>
			-->

			<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>

			<li><h2><?php _e('Archives'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories'); ?></h2>
				<ul>
				<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
				</ul>
			</li>

				<?php get_links_list(); ?>

		<?php if (function_exists('wp_theme_switcher')) { ?>
			<li><h2><?php _e('Themes'); ?></h2>
			<?php wp_theme_switcher(); ?>
			</li>
		<?php } ?>
				
				<li><h2><?php _e('Meta'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress</a></li>
					<li><a href="http://www.azeemazeez.com/" title="<?php _e('Theme Designed by Azeem Azeez'); ?>">Azeem Azeez</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			
			<li>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>			
			<?php endif; ?>
		</ul>
	</div>
