<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php if (have_posts()) : ?>

	<h2>Search Results for <em>&#8216;<?php echo wp_specialchars($s, 1); ?>&#8217;</em></h2>
	<br />
	<br />

<?php while (have_posts()) : the_post(); ?>

	<?php $custom_fields = get_post_custom(); //custom fields ?>

		<?php if (isset($custom_fields["BX_post_type"]) && $custom_fields["BX_post_type"][0] == "mini") { ?>

	<div class="minientry">

		<p>
		<?php echo BX_remove_p($post->post_content); ?>
		<?php comments_popup_link('(0)', '(1)', '(%)', 'commentlink', ''); ?>
		<a href="<?php the_permalink(); ?>" class="permalink"><?php the_time(get_option('date_format')) ?><!--, <?php the_time()  ?>--></a>
		<!--<em class="author"><?php the_author() ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
   		</p>

	</div>

	<?php } else { ?>

	<div class="entry">

		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<?php ($post->post_excerpt != "")? the_excerpt() : BX_shift_down_headlines($post->post_content); ?>

		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink() ?>" class="more">Continue Reading</a><?php } ?>
   		<?php comments_popup_link('Add comment', '1 comment', '% comments', 'commentlink', ''); ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<!--<em class="author"><?php the_author(); ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
		<br />
		<?php the_tags('Tags: ', ', ', '<br />'); ?>
   		</p>

		<div style="padding:20px 0px 0px 0px;"></div>
		
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/divider.gif" alt="" />
		
		<div style="padding:20px 0px 0px 0px;"></div>


	</div>

	<?php } ?>

<?php endwhile; ?>	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>	
			<td width="120" align="left"><?php next_posts_link('Previous Posts') ?></td>
			<td width="60"></td>
			<td width="120" align="right"><?php previous_posts_link('Next Posts') ?></td>
</tr>
	</table>

<?php else : ?>

	<h2>No Results for <em>&#8216;<?php echo wp_specialchars($s, 1); ?>&#8217;</em></h2>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
