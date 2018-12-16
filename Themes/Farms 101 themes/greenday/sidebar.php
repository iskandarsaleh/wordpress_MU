	<div id="ancillary">
		<div class="block first">
			<?php /* If this is a 404 page */ if (is_404()) { ?>

			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
				<h2><?php _e('About');?></h2><p>('<?php _e('You are currently browsing the archives for the');?> <?php single_cat_title(''); ?> <?php _e('category.');?></p>
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h2><?php _e('About');?></h2><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for the day');?> <?php the_time('l, F jS, Y'); ?>.</p>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h2><?php _e('About');?></h2><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				for <?php the_time('F, Y'); ?>.</p>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h2><?php _e('About');?></h2><p><?php _e('You are currently browsing the');?> <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for the year');?> <?php the_time('Y'); ?>.</p>
			<?php /* If this is a search Results */ } elseif (is_search()) { ?>
				<h2><?php _e('About');?></h2><p><?php _e('You have searched the');?> <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>
				<?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. <?php _e('If you are unable to find anything in these search results, you can try one of these links.');?></p>
			<?php /* If this is a individual archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2><?php _e('About');?></h2><p><?php _e('You are currently browsing the');?> <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> <?php _e('weblog archives');?>.</p>
			<?php } ?>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Left Column') ) : else : ?>
			<h2>Recently</h2>

			<ul class="dates">
				<?php
					query_posts('showposts=5');
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<li><a href="<?php the_permalink() ?>"><span class="date"><?php the_time('d.m.y') ?></span> <?php the_title() ?> </a></li>
				<?php endwhile; endif; ?>
			</ul>
<?php endif; ?>
		</div>
		<div class="block">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Middle Column') ) : else : ?>
			<h2><?php _e('Monthly Archives');?></h2>

			<ul class="counts">
				<?php wp_get_archives('type=monthly&limit=12&show_post_count=1'); ?>
			</ul>

			<h2><?php _e('Categories');?></h2>
			<ul class="counts">
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
			</ul>
<?php endif; ?>
		</div>

		<div class="block">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Right Column') ) : else : ?>		
			<h2><?php _e('Meta');?></h2>
			<ul class="dates">
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
				<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
				<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
				<?php wp_meta(); ?>
			</ul>
<?php endif; ?>
		</div>

		<div class="clear"></div>

	</div>
