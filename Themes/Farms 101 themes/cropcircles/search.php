<?php get_header(); ?>
<body id="blog">

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results');?></h2>
		
		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','','« Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries »','') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
								<small><?php the_time(__('F jS, Y')) ?> <!-- by <?php the_author() ?> --></br /><?php _e('Posted in ');?> <?php the_category(', ') ?><br /><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></small>				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
						
				<!--
				<?php trackback_rdf(); ?>
				-->
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','','« Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries »','') ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?>!</h2>



	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>