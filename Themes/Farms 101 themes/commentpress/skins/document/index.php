<?php get_header(); ?>
		<!-- SIDEBAR -->
		<?php include "sidebar.php" ?>

	
		<!-- BEGIN PAGE CONTAINER -->
		<div id="container_page"> 
			<div id="narrowcolumn"> 
		<!-- START Loop -->
			<h2><?= get_option('commentpress_table_contents') ?></h2>
			<ol class="tocList"> 
			<?php
				$post_menu = getParentPosts();
				//print_r($post_menu);
				foreach($post_menu as $item){
			?>
				<li><a href="<?= get_permalink($item->ID); ?>"><?= $item->post_title; ?></a>  <span class="normalLight">(<?= $item->comment_count; ?>)</span>  </li>
			<?
			}
			?>
			</ol> 		
		<!-- end pages_leftCol -->
			</div>

			<div id="widecolumn">
			<div id="documentIntro">
				<?php
				
				$id = getPostID(get_option('commentpress_welcome_message'));

				if($id):
				$post = get_post($id); 
				?>
				<h2><?php echo $post->post_title; ?></h2>
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php echo 	 $thecontent = balancetags(wpautop($post->post_content)); ?>
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php endif; ?>
			</div>
			</div>
		<!-- END pageContainer --> 
		</div> 
		<!-- END mainContainer --> 
<?php get_footer(); ?>
</div> 
		

