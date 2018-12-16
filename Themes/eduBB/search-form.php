<div id="searchbar">
<!--<h2><?php _e('Search'); ?></h2> -->
<form action="<?php bb_option('uri'); ?>search.php" id="mysearch" method="get">

<p>
<?php if( empty($q) ) : ?>
<input type="text" class="sbar" name="q" value="" />
<?php else : ?>
<input type="text" class="sbar" name="q" value="<?php echo attribute_escape( $q ); ?>" />
<?php endif; ?>

<?php if( empty($q) ) : ?>
<input name="s" class="sinput" type="submit" value="<?php echo attribute_escape( __('Search The Forums &raquo;') ); ?>" />
<?php else : ?>
<input name="s" class="sinput" type="submit" value="<?php echo attribute_escape( __('Search Again &raquo;') ); ?>" />
<?php endif; ?>
</p>

</form>
</div>