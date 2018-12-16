
		
	<td id="sidebar2">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-mandigo"); } ?>
	<ul class="sidebars">

<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 2')) : ?>
			<?php widget_mandigo_meta(); ?>
<?php endif; ?>
	</ul>
	</td>
