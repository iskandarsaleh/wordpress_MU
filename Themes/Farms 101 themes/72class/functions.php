<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '<!-- open block --><div class="block">',
'after_widget' => '<!-- close block --></div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
?>