<div id="l_sidebar">
	<ul class="sidebar_list">
		
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-default-sidebars"); } ?>
		
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1)) : ?>
		
	<li class="widget">
			<h2><?php _e('Getting started');?></h2>
			<ul>
				<li><?php _e('This sidebar explains how you can quickly get going');?></li>
				<li><?php _e('Read and then replace with Widgets (see below)');?></li>			
			</ul>
		</li>

			
			<li class="widget">
			<h2><?php _e('Uploading your avatars');?></h2>
			<ul>
				<li><?php _e('As an edublogs user you have a blog avatar and a user avatar');?></li>
				<li><?php _e('Upload a');?> <a href="wp-admin/options-general.php?page=edit_blog_avatar" target="_blank"><?php _e('blog avatar here');?></a> <?php _e('and a');?> <a href="wp-admin/users.php?page=edit_user_avatar" target="_blank"><?php _e('user avatar here');?></a></li>
				
			</ul>
		</li>

			<li class="widget">
			<h2><?php _e('Changing your header');?></h2>
			<ul>
				<li><?php _e('Go to');?> <a href="wp-admin/themes.php?page=custom-header" target="_blank"><?php _e('Presentation');?> > <?php _e('Custom Image Header');?></a> <?php _e('to upload and crop a new header image');?></li>				
			</ul>
		</li>

		<!-- <li class="widget">
			<h2>Help and support</h2>
			<ul>
				<li>Check out our <a href="http://edublogs.org/videos/" target="_blank">introductory videos</a> or read our <a href="http://edublogs.org/frequently-asked-questions-faq">Frequently Asked Questions</a> for more information</li>
				<li>Ask questions and chat to other edubloggers at <a href="http://edublogs.org/forums" target="_blank">The Edublogs Forums</a></li>
				<li>Browse through and subscribe to <a href="http://theedublogger.edublogs.org" target="_blank">The Edublogger</a> for hints, tips, ideas and how-tos</li>	
			</ul>
		</li> -->
		
			<li class="widget">
			<h2><?php _e('Changing your sidebars');?></h2>
			<ul>
				<li><?php _e('Now... configure your sidebars by visiting');?> <a href="wp-admin/widgets.php" target="_blank"><?php _e('Presentation');?> <?php _e('Widgets');?></a></li>
				<li><?php _e('Simply drag and drop the widgets you want to the sidebars you want them in');?></li>
							
			</ul>
		</li>
		
		
		<?php endif; ?>
	</ul>
</div>