<form method="get" action="<?php bloginfo('home'); ?>/">


<input type="text" value="<?php if (!($noresults)) { echo wp_specialchars($s, 1); } ?>" name="s" id="s" />


<input type="submit" id="searchsubmit" value="<?php _e('Search');?>" />


</form>