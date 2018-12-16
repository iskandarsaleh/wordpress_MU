<?php get_header();?>	

	<div id="main">

	<div id="content">

		<?php if ($posts) { ?>	

		<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>

		<?php if (is_day()) { ?>

			<h3><?php the_time('l, F jS, Y'); ?></h3>			

			<div class="post-info"><?php _e('Daily Archive') ?></div>

		<?php } elseif (is_month()) { ?>

			<h3><?php the_time('F Y'); ?></h3>

			<div class="post-info"><?php _e('Monthly Archive') ?></div>

		

		<?php } elseif (is_year()) { ?>

			<h3><?php the_time('Y'); ?></h3>

			<div class="post-info"><?php _e('Yearly Archive') ?></div>

		

		<?php } ?>				

		<br/>				

		<?php foreach ($posts as $post) : start_wp(); ?>				

			<?php require('post.php'); ?>

		<?php endforeach; ?>

		<p align="center"><?php posts_nav_link() ?></p>		

		<?php } else { ?>

			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>			

		<?php } ?>			

	</div>

	<div id="sidebar">

		<?php /* If this is a daily archive */ if (isset($_GET['day']) && !empty($_GET['day'])) { ?>

			<h2><? _e('Currently Browsing') ?></h2><ul><li><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

			<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p></li></ul>

			

			<?php /* If this is a monthly archive */ } elseif ((isset($_GET['m']) && !empty($_GET['m'])) or (isset($_GET['monthnum']) && ! empty($_GET['monthnum']))) { ?>

			<h2><?php _e('Currently Browsing') ?></h2><ul><li><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

			for <?php the_time('F, Y'); ?>.</p></li></ul>



			<?php /* If this is a yearly archive */ } elseif (isset($_GET['year']) && !empty($_GET['year'])) { ?>

			<h2><?php _e('Currently Browsing') ?></h2><ul><li><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>

			<?php _e('for the year');?> <?php the_time('Y'); ?>.</p></li></ul>

			<?php } ?>			

	

	<?php get_sidebar(); ?>

	</div>



<?php get_footer();?>

</div>

</div>

</body>

</html>