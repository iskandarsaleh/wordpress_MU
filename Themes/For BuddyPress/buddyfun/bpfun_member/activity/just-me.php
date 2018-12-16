<?php
/*
 * /activity/just-me.php
 * Displays the activity stream for the currently displayed user. 
 *
 * Loads: '/activity/activity-list.php' (via the bp_activity_get_list() template tag)
 * 
 * Loaded on URL:
 * 'http://example.org/members/[username]/activity/
 * 'http://example.org/members/[username]/activity/just-me/
 */
?>

<?php get_header() ?>

<?php do_action( 'template_notices' ) // (error/success feedback) ?>
	

<?php bp_get_profile_header() ?>

<?php if ( function_exists( 'bp_activity_get_list' ) ) : ?>
			
<?php
bp_activity_get_list(
bp_current_user_id(), // The ID of the user to get activity for.
bp_word_or_name( __( "My Activity", 'buddypress' ), __( "%s's Activity", 'buddypress' ), true, false ), // The title of the activity list.
bp_word_or_name( __( "You haven't done anything yet.", 'buddypress' ), __( "%s hasn't done anything yet.", 'buddypress' ), true, false ) // What to show when there is no activity.
);
?>
		
<?php endif; ?>


<?php get_footer() ?>