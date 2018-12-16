<hr/>
<div class="secondary">
	<div class="left">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
	<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
		<li class="<?php if (((is_home()) && !(is_paged())) or (is_archive()) or (is_single()) or (is_paged()) or (is_search())) { ?>current_page_item<?php } else { ?>page_item<?php } ?>"><a href="<?php echo get_settings('home'); ?>"><?php _e('Home');?></a></li><?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
<?php endif; ?>
</ul>
	</div>
	<div class="right">
	<div class="search"><?php include (TEMPLATEPATH . '/searchform.php'); ?></div>
<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
<?php endif; ?>
</ul>
	</div> <!-- close right -->

</div>
<div class="clear"></div>
