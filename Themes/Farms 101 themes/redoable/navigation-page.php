<?php
if(is_page() and ($notfound != '1')) {
	$current_page = $post->ID;

	while($current_page) {
		$page_query =& get_post($current_page);
		$current_page = $page_query->post_parent;
	}

	$parent_id = $page_query->ID;
	$parent_title = $page_query->post_title;

	if ( get_children($parent_id) ) {
		?>
			<ul>
				<li><a href="<?php echo get_permalink($parent_id); ?>"><?php printf(__('%s','redo_domain'), $parent_title ) ?></a> <?php _e('Subpages','redo_domain'); ?> &raquo;</li>
				<?php wp_list_pages('sort_column=menu_order&title_li=&child_of='. $parent_id); ?>
			</ul>
		<?php
	}
}
?> 
