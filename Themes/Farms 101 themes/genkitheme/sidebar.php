
<div id="sidebar_left" class="sidebar">
	<div id="logo"><h3><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name') ?></a><!--alternative color <a class="logoalt" href="<?php //echo get_settings('home'); ?>/"></a> --></h3></div><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
	<div id="aboutme">
		<ul>
			<li>
				<img src="<?php bloginfo('template_url') ?>/images/aboutme.gif" alt="About me" /><strong><?php _e('About');?></strong><br /><?php bloginfo('description') ?>
			</li>
		</ul>
	</div>
	<div id="navcontainer">
		<ul id="navlist">
			<?php wp_list_pages('title_li=&depth=1'); ?>
		</ul>
	</div>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_left') ) : ?>	
    <h2><?php _e('Categories');?></h2>    
	<ul>
    	<?php wp_list_cats('&title_li='); ?>
    </ul>    

	<br />
<?php endif; ?>
</div>
<div id="sidebar_right" class="sidebar">
	<div class="search">
		<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">
		<input class="searchinput" type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="search_query" />
		<input class="searchbutton" type="submit" value="Find"  />
		</form>
	</div>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_right') ) : ?>	
	<h2><?php _e('Archives');?></h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
	<h2>Links</h2>
	<ul>
		<?php wp_list_bookmarks(); ?>
	</ul>
<?php endif; ?>
</div>
