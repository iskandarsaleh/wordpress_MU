</div>

<div id="sidebar">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
<br /><br />
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : ?>
</ul>
</div>
<?php else : ?>

	<!-- Search -->
	<li id="sb-search">
		<h2><?php _e('Search'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</li>


	<!-- Recent Posts -->
	<?php
		$today = current_time('mysql', 1);
		if ( $recentposts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_date_gmt < '$today' ORDER BY post_date DESC LIMIT 10")):
	 ?>
	<li id="sb-posts">
	<h2><?php _e("Latest"); ?></h2>
		<ul>
			<?php foreach ($recentposts as $post) {
			if ($post->post_title == '')
			$post->post_title = sprintf(__('Post #%s'), $post->ID);
			echo "<li><a href='".get_permalink($post->ID)."'>";
			the_title();
			echo '</a></li>';
		}?>
		</ul>
	</li>
	<?php endif; ?>


	<!-- Archives -->
	<li id="sb-archives">
		<h2><?php _e('Archives'); ?></h2>
		<ul>
			<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
		</ul>
	</li>


	<!-- Categories -->
	<li id="sb-cates">
		<h2><?php _e('Categories'); ?></h2>
		<ul>
			<?php wp_list_cats('sort_column=id&hide_empty=0&optioncount=1&hierarchical=1'); ?> 
		</ul>
	</li>


	<!-- Feeds -->
	<li id="sb-feeds">
		<h2><?php _e('Feeds'); ?></h2>
		<ul>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS 2.0'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a>
			</li>
		</ul>
	</li>


	<!-- Links -->
		<?php get_links_list(); ?> 


	<!-- Misc -->
	<li id="sb-misc">
		<h2><?php _e('Misc'); ?></h2>
		<ul>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</li>

</ul>

</div>
<?php endif; ?>