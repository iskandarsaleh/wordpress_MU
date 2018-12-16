<?php if (!is_search()) {
		$search_text = __('search blog archives','redo_domain');
	} else {
		$search_text = "$s";
	}
?>
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="<?php echo (preg_match('/Safari/', $_SERVER['HTTP_USER_AGENT'])) ? 'search" results="5 autosave="com.domain.search' : 'text'; ?>" name="s" id="s" value="<?php echo wp_specialchars($search_text, 1); ?>" size="15" />
	<input type="submit" id="searchsubmit" value="<?php _e('GO','redo_domain'); ?>" />
</form>