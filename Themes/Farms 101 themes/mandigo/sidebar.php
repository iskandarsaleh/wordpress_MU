<?php 
	$tag_sidebar = get_option('mandigo_tag_sidebar');
?>


	<td id="sidebar1">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-mandigo"); } ?>
	<ul class="sidebars">
	
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar 1')) : ?>
			<?php widget_mandigo_search(); ?>

			<?php widget_mandigo_calendar(); ?>

			<?php if (is_category()) { ?>
			<li><p><?php printf(__('You are currently browsing the archives for the \'%s\' category.','mandigo'),single_cat_title('',false));?></p></li>

			<?php } elseif(function_exists(is_tag) && is_tag() ) { ?>
			<li><p><?php printf(__('You are currently browsing the %s weblog archives for posts tagged \'%s\'.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>',single_tag_title('',false));?></p></li>

			<?php } elseif (is_day()) { ?>
			<li><p><?php printf(__('You are currently browsing the %s weblog archives for the day %s.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>',get_the_time(__('l, F jS, Y','mandigo')));?></p></li>

			<?php } elseif (is_month()) { ?>
			<li><p><?php printf(__('You are currently browsing the %s weblog archives for %s.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>',get_the_time(__('F, Y','mandigo')));?></p></li>

			<?php } elseif (is_year()) { ?>
			<li><p><?php printf(__('You are currently browsing the %s weblog archives for the year %s.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>',get_the_time('Y'));?></p></li>

			<?php } elseif (is_search()) { ?>
			<li><p><?php printf(__('You have searched the %s weblog archives for %s. If you are unable to find anything in these search results, you can try one of these links.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>','<strong>\''. wp_specialchars($s) .'\'</strong>');?></p></li>

			<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<li><p><?php printf(__('You are currently browsing the %s weblog archives.','mandigo'),'<a href="'. get_bloginfo('home') .'/">'. get_bloginfo('name') .'</a>');?></p></li>

			<?php } ?>

			<?php wp_list_pages(array('title_li' => "<$tag_sidebar class=\"widgettitle\">". str_replace('&','%26',__('Pages','mandigo')) ."</$tag_sidebar>",'sort_column' => "menu_order")); ?>

			<li><<?php echo $tag_sidebar; ?> class="widgettitle"><?php _e('Categories','mandigo'); ?></<?php echo $tag_sidebar; ?>>
				<ul>
				<?php wp_list_cats(array('sort_column' => 'name', 'optioncount' => 1, 'hide_empty' => 0, 'hierarchical' => 1)); ?>
				</ul>
			</li>

				<?php if (function_exists('wp_tag_cloud')) { ?>
			<li><<?php echo $tag_sidebar; ?> class="widgettitle"><?php _e('Tags','mandigo'); ?></<?php echo $tag_sidebar; ?>>
				<?php wp_tag_cloud(); ?>
			</li>
				<?php } ?>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php get_links_list(); ?>
			<?php } ?>

			<?php widget_mandigo_meta(); ?>

<?php endif; ?>
	</ul>
	</td>
