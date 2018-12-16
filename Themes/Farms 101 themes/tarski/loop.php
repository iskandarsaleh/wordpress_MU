<?php is_tag(); ?>
<?php if (have_posts()) { ?>

<div id="primary">

<?php if(!is_single() && !is_home() &&!is_page()) { ?>
		<div class="entry archive">
			<div class="post-meta">
		<?php if(is_category()) { ?>
			<h1 class="post-title">Category Archive</h1>
		</div>
		<div class="post-content">
			<p><?php _e('You are currently browsing the category archive for the');?> '<?php echo single_cat_title(); ?>' <?php _e('category.');?></p>
		<?php } ?>
		<?php if(is_tag()) { ?>
			<h1 class="post-title">Tag Archive</h1>
		</div>
		<div class="post-content">
			<p><?php _e('You are currently browsing the');?> tag archive for the '<?php echo single_tag_title(); ?>' tag.</p>
		<?php } ?>
		<?php if(is_author()) { ?>
				<h1 class="post-title"><php _e('Author Archive');?></h1>
			</div>
			<div class="post-content">
				<p>You are currently browsing <?php $post = $wp_query->post;
				$the_author = $wpdb->get_var("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$post->post_author' AND meta_key = 'nickname'"); echo $the_author; ?>'s articles.</p>
		<?php } ?>
		<?php if(is_day()) { ?>
				<h1 class="post-title">Daily Archive</h1>
			</div>
			<div class="post-content">
				<p><?php _e('You are currently browsing the');?> daily <?php _e('Archive for');?> <?php the_time(__('F jS, Y')); ?>.</p>
		<?php } ?>
		<?php if(is_month()) { ?>
				<h1 class="post-title">Monthly Archive</h1>
			</div>
			<div class="post-content">
				<p><?php _e('You are currently browsing the');?> monthly <?php _e('Archive for');?> <?php the_time('F, Y'); ?>.</p>
		<?php } ?>
		<?php if(is_year()) { ?>
				<h1 class="post-title">Yearly Archive</h1>
			</div>
			<div class="post-content">
				<p><?php _e('You are currently browsing the');?> yearly <?php _e('Archive for');?> <?php the_time('Y'); ?>.</p>
		<?php } ?>
		<?php if(is_search()) { ?>
				<h1 class="post-title"><php _e('Search Results');?></h1>
			</div>
			<div class="post-content">
				<p>You searched for '<?php echo $s; ?>'.</p>
		<?php } ?>
			</div>
		</div>
<?php } ?>

<?php if (is_single() || is_page()) { while (have_posts()) { the_post(); ?>
	<div class="entry<?php if (is_page()) { echo " static"; } ?>">
		<div class="post-meta">
			<h1 class="post-title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
			<?php if (is_single()) { ?><p class="post-metadata"><?php the_time(get_option('date_format')) ?><?php if(!get_option('tarski_hide_categories')) { ?> <?php _e('in');?> <?php the_category(', '); ?><?php } ?><?php /* If there is more than one author, show author's name */ $count_users = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->usermeta WHERE `meta_key` = '" . $table_prefix . "user_level' AND `meta_value` > 1"); if ($count_users > 1) { ?> <?php _e('by');?> <?php the_author_posts_link(); ?><?php } ?><?php edit_post_link(__('Edit'),' (',')'); ?></p><br /> <?php the_tags(__('Tags: '), ', ', '<br />'); ?><?php } ?>
		</div>
		<div class="post-content">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		</div>
		<?php if (is_page()) { edit_post_link('edit page', '<p class="post-metadata">(', ')</p>'); } ?>
	</div>
	<?php } } else { while (have_posts()) { the_post(); ?>
	<div class="entry">
		<div class="post-meta">
			<h2 class="post-title" id="post-<?php the_ID(); ?>"><?php if(!is_single()) { ?><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a><?php } else { the_title(); } ?></h2>
			<p class="post-metadata"><?php the_time(get_option('date_format')) ?><?php if(!get_option('tarski_hide_categories')) { ?> <?php _e('in');?> <?php the_category(', '); ?><?php } ?><?php the_tags( '&nbsp;' . __( 'and tagged' ) . ' ', ', ', ''); ?><?php /* If there is more than one author, show author's name */ $count_users = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->usermeta WHERE `meta_key` = '" . $table_prefix . "user_level' AND `meta_value` > 1"); if ($count_users > 1) { ?> <?php _e('by');?> <?php the_author_posts_link(); } ?> | <?php comments_popup_link('No comments', '1 comment', '% comments', '', 'Comments closed'); ?><?php edit_post_link(__('Edit'),' (',')'); ?></p>
		</div>

		<div class="post-content">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		</div>
	</div>
<?php } } ?>
</div>
<?php } else { ?>
	<div id="primary">
		<div class="entry static">
			<div class="post-meta">
				<h1 class="post-title" id="error-404">Error 404</h1>
			</div>

			<div class="post-content">
				<p>The page you are looking for does not exist; it may have been moved, or removed altogether. You might want to try the search function. Alternatively, return to the <a href="<?php echo get_settings('home'); ?>">front page</a>.</p>
			</div>
		</div>
	</div>
<?php } ?>
