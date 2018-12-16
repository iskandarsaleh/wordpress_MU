<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php $img_ro1 = "$oc_ow_image_one"; ?>
<?php if($img_ro1!=''): ?>
<img src="<?php echo stripslashes($oc_ow_image_one); ?>" alt="rotate" border="0" />
<?php else: ?>
<img src="<?php bloginfo('template_directory'); ?>/images/headers/random1.gif" alt="no rotate image set" />
<?php endif; ?>


<?php $img_ro2 = "$oc_ow_image_two"; ?>
<?php if($img_ro2!=''): ?>
<img src="<?php echo stripslashes($oc_ow_image_two); ?>" alt="rotate2" border="0" />
<?php else: ?>
<img src="<?php bloginfo('template_directory'); ?>/images/headers/random2.gif" alt="no rotate image set" />
<?php endif; ?>


<?php $img_ro3 = "$oc_ow_image_three"; ?>
<?php if($img_ro3!=''): ?>
<img src="<?php echo stripslashes($oc_ow_image_three); ?>" alt="rotate3" border="0" />
<?php else: ?>
<img src="<?php bloginfo('template_directory'); ?>/images/headers/random3.gif" alt="no rotate image set" />
<?php endif; ?>


<?php $img_ro4 = "$oc_ow_image_four"; ?>
<?php if($img_ro4!=''): ?>
<img src="<?php echo stripslashes($oc_ow_image_four); ?>" alt="rotate4" border="0" />
<?php else: ?>
<img src="<?php bloginfo('template_directory'); ?>/images/headers/random4.gif" alt="no rotate image set" />
<?php endif; ?>