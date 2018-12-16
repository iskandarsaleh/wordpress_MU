						<ul class="sidebar" id="widgetSidebar2">
						<?php // if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('widgets2') ) : ?>
						<li class="section">
							<h3 class="sansRed"><?php _e('Archives');?></h3> 
							<ul> 
							 <?php wp_get_archives(); ?>
							</ul>
						</li>
						<li class="section">
							<h3 class="sansRed"><?php _e('Categories');?></h3> 
							<ul> 
							 <?php wp_list_categories('title_li='); ?>
							</ul>
						</li>
						<?php // endif; ?>
						</ul>