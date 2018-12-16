<?php bb_get_header(); ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Register'); ?></h3>

<h2 id="main-forum-title"><?php _e('Registration'); ?><br />
<small><?php _e("Your password will be emailed to the address you provide."); ?></small>
</h2>

<?php if ( !bb_is_user_logged_in() ) : ?>

<form method="post" action="<?php bb_option('uri'); ?>register.php">

<div id="profile-edit-form">

<table id="userinfo">

<?php if ( $user_safe === false ) : ?>

<tr class="form-field">
<th class="title">
<?php _e('Username'); ?><br />
<small style="color: red;"><?php _e('Your username was not valid, please try again'); ?></small>
</th>
<td><input name="user_login" type="text" id="user_login" size="30" maxlength="30" /><br /></td>
</tr>

<?php else : ?>

<tr class="form-field">
<th class="title" scope="row"><?php _e('Username'); ?> (<small style="color: red;">Required</small>)</th>
<td><input name="user_login" type="text" id="user_login" size="30" maxlength="30" value="<?php if (!is_bool($user_login)) echo $user_login; ?>" /></td>
</tr>

<?php endif; ?>


<?php if ( is_array($profile_info_keys) ) : foreach ( $profile_info_keys as $key => $label ) : ?>
<tr class="form-field">
<th class="title" scope="row"><?php echo $label[1]; ?> <?php if ( $label[0] ) { echo '(<small style="color: red;">Required</small>)'; $label[1] = '' . $label[1]; } ?></th>
<td><input name="<?php echo $key; ?>" type="text" id="<?php echo $key; ?>" size="30" maxlength="140" value="<?php echo $$key; ?>" /><?php
if ( $$key === false ) :
if ( $key == 'user_email' )
_e('<br />There was a problem with your email; please check it.');
else
_e('<br />The above field is required.');
endif;
?></td>
</tr>
<?php endforeach; endif; ?>
</table>


<?php do_action('extra_profile_info', $user); ?>

<p>
<input type="submit" class="sinput" name="Submit" value="<?php echo attribute_escape( __('Register &raquo;') ); ?>" />
</p>


</div>

</form>

<?php else : ?>
<p><?php _e('You&#8217;re already logged in, why do you need to register?'); ?></p>
<?php endif; ?>


<?php bb_get_footer(); ?>