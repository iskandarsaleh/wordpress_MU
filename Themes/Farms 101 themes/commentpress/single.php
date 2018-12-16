<?php get_header(); ?>
<!-- SIDEBAR -->
<? 
	global $siteurl;
	$skin = get_option('skin');
	include($siteurl."skins/".$skin."/sidebar.php"); ?>
	
<!-- START container_page -->
<div id="page">

	<?php 
	/* start the loop */
		if (have_posts()) {
		while (have_posts()) { the_post(); 
	?>				
			<div id="content"> 
				<div class="navigation">
				<table>
				<tr>
					<td class="alignLeft"><?php ($skin=='blog')? previous_post_link('&laquo; Older: %link'): previous_post_link('&laquo; Previous: %link'); ?></td>
					<td class="alignRight"><?php ($skin=='blog')? next_post_link('Newer: %link &raquo;'): next_post_link('Next: %link &raquo;'); ?></td>
				</tr>
				</table></div>
			
			
			
			<!-- Title -->
			<? $commentpress_stylize = true; ?>
			<? the_title(); ?>
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<!-- Content -->
			<? the_content(); ?>
			<? $commentpress_stylize = false; ?>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>



		<p class="smLight"><?php _e('Posted by');?> <? the_author() ?> on <? the_date(); ?> <?php edit_post_link(__('Edit'),'',''); ?> <br /> 
			<?php _e('Tags');?>		<?php
			//http://codex.wordpress.org/Template_Tags/get_the_category
			$thecategories = get_the_category();
			$count  = count($thecategories);
			foreach($thecategories as $key=>$cat) { 
				echo $cat->cat_name;
				if($key != (int)$count-1){
					echo ", ";
				}
			} 
			?>
		</p> 
	<!-- END container_content -->
	</div> 
	
			<!-- Navigation -->
			<div class="navigation">
				<table>
				<tr>
					<td class="alignLeft"><?php ($skin=='blog')? previous_post_link('&laquo; Older: %link'): previous_post_link('&laquo; Previous: %link'); ?></td>
					<td class="alignRight"><?php ($skin=='blog')? next_post_link('Newer: %link &raquo;'): next_post_link('Next: %link &raquo;'); ?></td>
				</tr>
				</table>
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
			</div>
			
		<?php } ?>

		<?php } else { ?>

		<p><?php _e('Sorry, no posts matched your criteria.');?></p>

	<?php } ?>

<?php comments_template(); ?>
<!-- END container_page -->
	</div>

<?php get_footer(); ?>

