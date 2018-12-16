<?php
	global $dirs;

	get_header();

	$tag_posttitle_single = get_option('mandigo_tag_posttitle_single');
?>
	<td id="content" class="narrowcolumn">

		<div class="four04">
			<span class="four04-big">404</span><br />
			Not Found
		</div>

	</td>

<?php
	if (!get_option('mandigo_nosidebars')) {
		include (TEMPLATEPATH . '/sidebar.php');
		if (get_option('mandigo_1024') && get_option('mandigo_3columns')) include (TEMPLATEPATH . '/sidebar2.php');
	}

	get_footer(); 
?>
