<?php 
	the_post();

	// Post is an aside
	$post_asides = in_category($redo_asidescategory);
?>

<?php /* Only display asides if sidebar asides are not active */ if(!$post_asides || $redo_asidescheck == '0') { ?>

<div id="post-<?php the_ID(); ?>" class="<?php redo_post_class($post_index++, $post_asides); ?><?php echo " first" ?>">
	<div class="entry-head">
		<?php
		printf(	__('%1$s','redo_domain'), 
			'<div class="published_sm" title="'. get_the_time('Y-m-d\TH:i:sO') . '">' .
			( '<div class="day">' . get_the_time('d') . '</div><div class="month">' . get_the_time('M') . '</div><div class="year">' . get_the_time('y') . '</div>' ) 
			. '</div>'
			);
		?>
		<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title='<?php printf( __('Permanent Link to "%s"','redo_domain'), wp_specialchars(get_the_title(),1) ); ?>'><?php the_title(); ?></a></h3>
		<?php /* Support for Noteworthy plugin */ if (function_exists('nw_noteworthyLink')) { nw_noteworthyLink($post->ID); } ?>
	</div> <!-- .entry-head -->	
	
	<div class="meta-column">
		<div class="entry-meta">
			<h2>post info</h2>
			<div class="meta-row">
				<?php /* Date & Author */
				printf(	__('%1$s','redo_domain'), sprintf(__('<span class="authordata">By %s</span>','redo_domain'), '<span class="vcard author"><a href="' . get_author_link(0, $authordata->ID, $authordata->user_nicename) .'" class="url fn">' . get_the_author() . '</a></span>') );
				?>
			</div>
			
			<div class="meta-row">
				<?php /* Categories */ printf(__('<span class="entry-category">Categories: %s</span>','redo_domain'), redo_nice_category(', ', ' '.__('and','redo_domain').' ') ); ?>
				<br />
				<span class="entry-category"><?php the_tags(__('Tags: '), ', ', '<br />'); ?></span>
			</div>
			
			<div class="meta-row">
				<?php /* Comments */ comments_popup_link('<span>0&nbsp;'.__('Comments','redo_domain').'</span>', '<span>1&nbsp;'.__('Comment','redo_domain').'</span>', '<span>%&nbsp;'.__('Comments','redo_domain').'</span>', 'commentslink', '<span class="commentslink">'.__('Closed','redo_domain').'</span>'); ?>
			</div>
		
			<div class="meta-row">
				<?php /* Tags is_single() and  */ if (function_exists('UTW_ShowTagsForCurrentPost')) { ?>
				<span class="entry-tags"><?php _e('Tags:','redo_domain'); ?> <?php UTW_ShowTagsForCurrentPost("commalist") ?>.</span>
				<?php } ?>
			</div>
			
			<div class="meta-row">
				<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
			</div>

			<div class="meta-row">
				<?php if (function_exists('WordCount')) { ?>
					<span class="word-count"><?php echo WordCount(1, $post -> ID) . " words."; ?></span>
				<?php } ?>
			</div>

			<div class="meta-row">
				<?php if(function_exists('the_views')) { ?>
					<span class="page-views"><?php the_views(); ?></span>
				<?php } ?>
			</div>
			
			<div class="meta-row">
				<?php if(function_exists('akst_share_link')) { akst_share_link(); } ?>
			</div>
			
			<div class="meta-row">
				<?php /* Edit Link */ edit_post_link(__('Edit','redo_domain'), '<span class="entry-edit">','</span>'); ?>
			</div>			
			
		</div> <!-- .entry-meta -->
	
		<?php if(function_exists('related_posts')) { ?>
		<div class="relatedPosts">
			<h2>related posts</h2>
			<ul>
				<?php related_posts(); ?>
			</ul>
		</div>
		<?php } ?>
	</div>
	
	<div class="entry-content">
		<?php if(function_exists('show_digg_button') or function_exists('digg_button')) { echo '<div class="diggButton">'; } ?>
			<?php if(function_exists('show_digg_button')) { show_digg_button(); }
			else if(function_exists('digg_button')) { digg_button(); } ?>
		<?php if(function_exists('show_digg_button') or function_exists('digg_button')) { echo '</div>'; } ?>
					
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?><?php if (is_archive() or is_search() or (function_exists('is_tag') and is_tag())) {
			the_excerpt();
		} else {
			the_content(__('Continue reading','redo_domain') . " '" . the_title('', '', false) . "'");
		} ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?>

		<?php if( get_bloginfo('version') < 2.1 ) { ?>
			<?php link_pages('<p><strong>'.__('Pages:','redo_domain').'</strong> ', '</p>','number'); ?>
		<?php } else { ?>
			<?php wp_link_pages('before=<p><strong>'.__('Pages:','redo_domain').'</strong>&after=</p>&next_or_number=number')?>
		<?php } ?>
	</div> <!-- .entry-content -->
	

</div> <!-- #post-ID -->

<?php } /* End sidebar asides test */ ?>
