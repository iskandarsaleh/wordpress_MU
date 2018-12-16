<?php get_header(); ?>





<div id="recent">


<div class="container">


<div class="recent-post">


	


	<h2 class="center"><?php _e('Error 404 - Not Found') ?></h2>





</div><div class="clear"></div>


</div>


</div>





<div id="posts">


	<div class="container">


	<div class="recent-post">








<!-- END post -->





<div class="content-navigate clearfix">


<span class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></span>


<span class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></span>


</div>





</div>


<div id="sidebar">


		<ul  class="widgets">


				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('MostRecent sidebar') ) : ?>


				<?php endif; ?>	


				<?php if ( !function_exists('dynamic_sidebar')


        || !dynamic_sidebar('Recents sidebar') ) : ?>


				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>


				<?php wp_list_bookmarks(); ?>


				<?php } ?>


				<?php endif; ?>	


		</ul>


	</div>


</div>


<div class="clear"></div>


</div>





<?php get_footer(); ?>