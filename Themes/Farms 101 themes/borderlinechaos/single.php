<?php get_header(); ?>

<div id="sidebar"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-borderline-sidebar"); } ?>
	<div id="sidebox">

<div class="title"><?php bloginfo('description'); ?></div>

<?php /* If this is a category archive */ if (is_category()) { ?>				

			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives

			for the ');?>'<?php echo single_cat_title(); ?>' ')<?php _e('category.');?></p>

			

			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>

			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives.');?></p>

		

			

			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives.');?></p>



      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>

			<p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives.');?></p>

			

		 <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>

			<p><?php _e('You have searched the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives

			for');?> <strong>'<?php echo $s; ?>'</strong>. <?php _e("If you are unable to find anything in these search results, we're really sorry.");?></p>



			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

			<p><?php _e('You are currently browsing the')?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives.');?></p>



			<?php } ?>



</div>

<br />

	<div id="sidebox1">

			<div class="title"><?php _e('Pages');?></div>

<ul>

<?php wp_list_pages('title_li='); ?>

</ul>

</div>



<br />

	<div id="sidebox2">

<div class="title"><?php _e('Categories');?></div>

				<?php list_cats(0, '', 'name', 'asc', '', 0, 0, 1, 1, 1, 1, 0,'','','','','28') ?>
</div>

<br />

	<div id="sidebox3">

<div class="title"><?php _e('Archives'); ?></div>

<?php wp_get_archives('type=monthly&format=other&after=<br />'); ?></div>



<br />

	<div id="sidebox4">

<form style="padding: 0px; margin-top: 0px; margin-bottom: 0px;" id="searchform" method="get" action="<?php bloginfo('url'); ?>">



<div class="title"><?php _e('Search:');?></div>

<p style="padding: 0px; margin-top: 0px; margin-bottom: 0px;"><input type="text" class="input" name="s" id="search" size="15" />

<input name="submit" type="submit" tabindex="5" value="<?php _e('GO'); ?>" /></p>

</form></div>

</div>

<div id="contentwrapper">


<div id="content">
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280-borderline-top"); } ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		





	

		<div class="singlepost">



	 <a class="posttitle" href="<?php the_permalink() ?>" style="text-decoration:none;" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a>

	<div class="cite"><?php the_time("l F dS Y") ?>, <?php the_time() ?> <?php edit_post_link(); ?><?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?><br />

<?php _e("Filed under:"); ?> <?php the_category(',') ?></div><br/>	

			<div class="entrytext">
			
				<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?>

	

				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>

	

				</div>
	<br />
		</div>

	<br />

	<?php comments_template(); ?>

	

<div class="navigation">

			<div class="alignleft"><?php previous_post('&laquo; %','','yes') ?></div>

			<div class="alignright"><?php next_post(' % &raquo;','','yes') ?></div>

  				</div>

	<?php endwhile; else: ?>

	

		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

	

<?php endif; ?>


<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-borderline-bottom"); } ?>


</div>

<?php get_footer(); ?>