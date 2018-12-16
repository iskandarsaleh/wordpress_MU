<?php if ( bp_has_site_blogs( 'type=random&max=20' ) ) : ?>


<div class="widget"><h2 class="widgettitle"><?php _e( 'Random Blogs', 'buddypress' ) ?></h2>

<div class="avatar-block">

<?php bp_directory_blogs_search_form() ?>

<?php while ( bp_site_blogs() ) : bp_the_site_blog(); ?>

<div class="item-avatar"><a href="<?php bp_the_site_blog_link() ?>"><?php bp_the_site_blog_avatar_thumb() ?></a></div>

<?php endwhile; ?>

</div>

</div>

<?php endif; ?>