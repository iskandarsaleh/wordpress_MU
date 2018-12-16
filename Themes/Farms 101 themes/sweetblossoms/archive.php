<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php is_tag(); ?>
<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2>Posts filed under '<?php echo single_cat_title(); ?>'</h2>

	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
        <h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2>Archive for <?php the_time('F jS, Y'); ?></h2>

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2>Archive for <?php the_time('F, Y'); ?></h2>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2>Archive for <?php the_time('Y'); ?></h2>

	<?php /* If this is a search */ } elseif (is_search()) { ?>
	<h2>Search Results</h2>

	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2>Author Archive</h2>

	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2>Blog Archives</h2>

<?php } ?>

<br /><br /><br />

<?php while (have_posts()) : the_post(); ?>

	<?php $custom_fields = get_post_custom(); ?>

	<?php if (isset($custom_fields["BX_post_type"]) && $custom_fields["BX_post_type"][0] == "mini") { ?>

	<div class="minientry">

		<p>
		<?php echo BX_remove_p($post->post_content); ?>
		<?php comments_popup_link('(0)', '(1)', '(%)', 'commentlink', ''); ?>
		<a href="<?php the_permalink(); ?>" class="permalink"><?php the_time(get_option('date_format')) ?><!--, <?php the_time()  ?>--></a>
		<!--<em class="author"><?php the_author() ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
		<br />
		<?php the_tags('Tags: ', ', ', '<br />'); ?>
   		</p>

	</div>

	<?php } else { ?>

	<div class="main">

		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<?php ($post->post_excerpt != "")? the_excerpt() : BX_shift_down_headlines($post->post_content); ?>

		<p class="info"><?php if ($post->post_excerpt != "") { ?><a href="<?php the_permalink() ?>" class="more">Continue Reading</a><?php } ?>
   		<?php comments_popup_link('Add comment', '1 comment', '% comments', 'commentlink', ''); ?>
   		<em class="date"><?php the_time(get_option('date_format')) ?><!-- at <?php the_time()  ?>--></em>
   		<!--<em class="author"><?php the_author(); ?></em>-->
   		<?php edit_post_link('Edit','<span class="editlink">','</span>'); ?>
   		</p>
		
		<div style="padding:20px 0px 0px 0px;"></div>
		
		<img src="<?php bloginfo('stylesheet_directory'); ?>/images/divider.gif" alt="" />
		
		<div style="padding:20px 0px 0px 0px;"></div>


	</div>

	<?php } ?>

<?php endwhile; ?>

	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>			
			<td width="120" align="left"><?php next_posts_link('Previous Posts') ?></td>
			<td width="60"></td>
			<td width="120" align="right"><?php previous_posts_link('Next Posts') ?></td>
</tr>
	</table>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
