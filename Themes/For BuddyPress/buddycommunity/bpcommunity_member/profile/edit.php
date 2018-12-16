<?php get_header() ?>

<div class="content-header">
	
	<ul class="content-header-nav">
		<?php bp_profile_group_tabs(); ?>
	</ul>
	
</div>

<div class="vcard">
	
	<h2 id="post-header"><?php printf( __( "Editing '%s'", "buddypress" ), bp_profile_group_name(false) ); ?></h2>
	
	<?php bp_edit_profile_form() ?>

</div>

<?php get_sidebar() ?>

<?php get_footer() ?>