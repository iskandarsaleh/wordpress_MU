<div id="left-box" class="mbar">


<?php
if((bp_is_page( BP_MEMBERS_SLUG )) || (bp_is_page( BP_GROUPS_SLUG )) || (bp_is_page( BP_BLOGS_SLUG ))) { ?>

<?php load_template( TEMPLATEPATH . '/directories/group-sidebar.php' ) ?>

<?php } else { ?>


<?php
global $bp, $is_single_group;
if($bp->current_component == $bp->groups->slug && $bp->is_single_item) { ?>

<?php if ( bp_has_groups() ) : bp_the_group(); ?>
<?php load_template( TEMPLATEPATH . '/groups/group-menu.php' ) ?>
<?php endif; ?>


<?php } else { ?>


<?php load_template( TEMPLATEPATH . '/profile/profile-menu.php' ) ?>

<?php if ( function_exists('bp_friends_random_friends') ) : ?>
<?php bp_friends_random_friends() ?>
<?php endif; ?>

<?php } ?>

<?php } ?>

</div>

