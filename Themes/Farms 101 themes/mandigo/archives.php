<?php
/*
Template Name: Archives Template
*/
?>
<?php 
	get_header();

	$tag_pagetitle = get_option('mandigo_tag_pagetitle'      );
?>
	<td id="content" class="narrowcolumn">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mandigo-fafafa"); } ?>
	<div class="post">


	<<?php echo $tag_pagetitle; ?> class="pagetitle"><?php _e('Search','mandigo'); ?>:</<?php echo $tag_pagetitle; ?>>
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<<?php echo $tag_pagetitle; ?> class="pagetitle"><?php _e('Archives by Month','mandigo'); ?>:</<?php echo $tag_pagetitle; ?>>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

	<<?php echo $tag_pagetitle; ?> class="pagetitle"><?php _e('Archives by Subject','mandigo'); ?>:</<?php echo $tag_pagetitle; ?>>
	<ul>
		<?php wp_list_cats(); ?>
	</ul>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mandigo-bottom"); } ?>
	</div>
	</td>

<?php
	if (!get_option('mandigo_nosidebars')) {
		include (TEMPLATEPATH . '/sidebar.php');
		if (get_option('mandigo_1024') && get_option('mandigo_3columns')) include (TEMPLATEPATH . '/sidebar2.php');
	}

	get_footer(); 
?>
