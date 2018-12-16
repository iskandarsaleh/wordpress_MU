<li><a <?php if (is_home()) echo('class="current" '); ?>href="<?php bloginfo('url'); ?>"><?php _e('Home');?></a></li>
<?php wp_list_pages('title_li=&depth=1'); ?>