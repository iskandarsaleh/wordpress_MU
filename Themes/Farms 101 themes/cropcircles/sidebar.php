	<div id="sidebar">
		
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
		
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		

			<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>

	<h3><?php bloginfo('description'); ?></h3>
<ul>

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

	<?php wp_list_pages('title_li=<h2>' . __('Pages') . '</h2>' ); ?>
	<li>
		<h2><?php _e('Archives'); ?></h2>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
	<li>
		<h2><?php _e('Categories'); ?></h2>
		<ul>
		<?php wp_list_cats(); ?> 
		</ul>
	</li>
	<li>
		<h2><?php _e('Search'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>
	
	<?php if (function_exists('wp_theme_switcher')) { ?>
	<li>
		<h2><?php _e('Themes'); ?></h2>
		<?php wp_theme_switcher(); ?>
	</li>
	<?php } ?>

	<?php if ( is_home() ) { get_links_list(); } ?>	
	
	<li>
		<h2><?php _e('Meta'); ?></h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a></li>
			<li><a href="<?php bloginfo('atom_url'); ?>" title="<?php _e('Syndicate this site using Atom'); ?>"><?php _e('Atom'); ?></a></li>
			<li><a href="http://wordpress.org" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress</a></li>
			<?php wp_meta(); ?>
		</ul>
	</li>
<?php endif; ?>

</ul>

	</div>

