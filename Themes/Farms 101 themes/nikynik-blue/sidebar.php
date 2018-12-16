<div id="sidebar">
		<ul>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) { ?>

<?php if (function_exists('wp_theme_switcher')) { ?>
<li><h2><?php _e('Themes','nikynik'); ?></h2>
		
		<?php wp_theme_switcher(); ?></li>
		<?php } ?>
<li>
<h2><?php _e('Last Posts','nikynik'); ?></h2>
<ul><?php
$posts = get_posts('numberposts=5');
foreach ($posts as $post) :
?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
<?php
endforeach;
?>
</ul> 
			<li><h2><?php _e('Archives:'); ?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2><?php _e('Categories:'); ?></h2>
				<ul>
				<?php list_cats(); ?>
				</ul>
			</li>

<?php get_links_list(); ?>
				
				<li><h2><?php _e('Meta'); ?></h2>
				<ul>
					<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a></li>
		<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
		<li><a href="http://jigsaw.w3.org/css-validator/validator?uri=http://www.nikynik.com/wpstyles"><?php _e('Valid <abbr title="Valid Css!">CSS</abbr> ','nikynik'); ?></a></li>
<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
		<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','nikynik'); ?>"><abbr title="WordPress">WP</abbr></a></li>
		<?php wp_meta(); ?>
				</ul>
				</li>
			<li><h2><?php _e('Search') ?></h2>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>
<?php } ?>
<?php if(function_exists(wp_onlinecounter)) { wp_onlinecounter(); } ?>		
		</ul>
	</div>