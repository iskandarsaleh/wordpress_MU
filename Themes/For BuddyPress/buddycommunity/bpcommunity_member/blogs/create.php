<?php get_header() ?>

<div class="content-header">

</div>

<div class="vcard">
	<h2 id="post-header"><?php _e( 'Create a Blog', 'buddypress' ) ?></h2>
	<?php do_action( 'template_notices' ) // (error/success feedback) ?>

	<?php if ( bp_blog_signup_enabled() ) : ?>
		
		<?php bp_show_blog_signup_form() ?>
	
	<?php else: ?>

		<div id="message" class="info">
			<p><?php _e( 'Blog registration is currently disabled', 'buddypress' ); ?></p>
		</div>

	<?php endif; ?>

</div>

<?php get_sidebar() ?>

<?php get_footer() ?>

