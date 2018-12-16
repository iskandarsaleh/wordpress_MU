
<!-- begin left sidebar -->
<div id="navibar">
	<div class="links"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("16090linkunitnocolor"); } ?>
		<ul>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Left Navigation') ) : else : ?>
	<li><h2><?php _e('Categories');?></h2>
				<ul>
				<?php wp_list_cats(); ?>
				</ul>
	</li>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	<li><h2><?php _e('Meta'); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="feed:<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
					<li><a href="http://jigsaw.w3.org/css-validator/check/referer" title="Valid CSS">Valid CSS</a></li>
					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
					<li><a href="http://wordpress.org/" title="Powered by WordPress">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>
	</li>
<?php if (function_exists('wp_theme_switcher')) { ?>
	<li><h2><?php _e('Themes'); ?></h2>
					<?php wp_theme_switcher(); ?>
	</li>
<?php } ?>
<?php endif; ?>
</ul>
		</div> <!-- /links -->
	<div id="navi_end_left"> </div>
</div> <!-- /navibar -->
<!-- begin right sidebar -->
<div id="right">
	<div class="links"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("16090linkunitnocolor"); } ?>
		<ul>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Right Sidebar') ) : else : ?>
	<li><h2><?php _e('Last Entries'); ?></h2>
		<ul><?php get_archives('postbypost', '10', 'custom', '<li>', '</li>'); ?></ul>
	</li>
	<?php wp_list_bookmarks(); ?>
	<li><h2><?php _e('Archives'); ?></h2>
		<ul><?php wp_get_archives('type=monthly'); ?></ul>
	</li>
<?php endif; ?>
</ul>
		</div> <!-- /links -->
	<div id="navi_end_right"> </div>
</div> <!-- end right sidebar -->