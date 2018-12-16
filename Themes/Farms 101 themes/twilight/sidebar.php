	<div id="sidebar">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("16090linkunitnocolor"); } ?>

		<ul>

        
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>




<?php /* If this is a 404 page */ if (is_404()) { ?>

	<?php /* If this is a category archive */ } elseif (is_category()) { ?>

	<li><p><?php _e('You are currently browsing the archives for the');?> <em><?php single_cat_title(''); ?></em> <?php _e('category.');?></p>

<p><?php next_post_link(__('&laquo; previous')) ?> <?php previous_post_link(__('next &raquo;')) ?></p></li>

		

	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>

	<li><p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

	<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p></li>

			

	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

	<li><p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

	for <?php the_time('F, Y'); ?>.</p></li>





      	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>

	<li><p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

	<?php _e('for the year');?> <?php the_time('Y'); ?>.</p></li>

			

	<?php /* If this is the search page */ } elseif (is_search()) { ?>

	<li><p><?php _e('You have searched the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

	<?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.');?></p></li>



<?php /* If this is a single archive */ } elseif (is_single()) { ?>

	<li>

<p><?php _e('You can follow any responses to this entry through the');?>  <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed');?>. 

						

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {

							// Both Comments and Pings are open ?>

							<?php _e('You can');?> <a href="#respond"><?php _e('leave a response');?></a>, <?php _e('or');?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.

						

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {

							// Only Pings are Open ?>

							<?php _e('Responses are currently closed, but you can');?> <a href="<?php trackback_url(true); ?> " rel="trackback"><?php _e('trackback')?></a> <?php _e('from your own site');?>.

						

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {

							// Comments are open, Pings are not ?>

							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.');?>

			

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {

							// Neither Comments, nor Pings are open ?>

							<?php _e('Both comments and pings are currently closed.');?>			

<?php } ?>		

</p></li>



	<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

	<li><p><?php _e('You are currently browsing the');?> <a href="<?php echo get_settings('siteurl'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p></li>



	<?php } ?>



<li id="pages"><h2><?php _e('Pages');?></h2>

<ul>

<?php wp_list_pages('sort_column=menu_order&title_li='); ?>

</ul>

</li>



<li id="archives"><h2><?php _e('Archives');?></h2> 

<ul>

<?php get_archives(); ?>

</ul></li>



<li id="categories"><h2><?php _e('Categories');?></h2>

<ul>

<?php wp_list_cats(); ?>

</ul></li>



<?php /* If this is the home page */ if (is_home()) { ?>



<?php get_links_list(); ?>



<?php } ?>



<li><h2><?php _e('Meta');?></h2>

<ul>

<?php wp_register(); ?>

					<li><?php wp_loginout(); ?></li>

					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>

					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>

					<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>

					<?php wp_meta(); ?>

</ul></li>



<li>

				<?php include (TEMPLATEPATH . '/searchform.php'); ?>

			</li>

			<?php endif; ?>

		</ul>

	</div>