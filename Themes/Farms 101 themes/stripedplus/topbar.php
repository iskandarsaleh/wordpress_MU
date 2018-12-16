<div class="barmenuleft">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Top Left') ) : ?>
            <h3><?php _e('Pages');?></h3>
			<ul>
			<li><a href="<?php bloginfo('home'); ?>"><?php _e('Home');?></a></li>
			<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
			</ul>
			<?php endif; ?>
		</div>
        <div class="barmenuright">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Top Right') ) : ?>
            <h3><?php _e('Categories');?></h3>
            <ul>
            <?php list_cats(); ?>
            </ul>
			<?php endif; ?>
        </div>
