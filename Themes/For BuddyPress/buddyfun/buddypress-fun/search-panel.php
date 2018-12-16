<form id="search-form" method="get" action="<?php bloginfo ('home'); ?>">
<input name="s" id="search-terms" type="text" value="Search here" onfocus="if (this.value == 'Search here') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search here';}" size="10" tabindex="1" />
<input type="submit" name="search-submit" id="search-submit" value="<?php echo attribute_escape(__('Search')); ?>" />
</form>


