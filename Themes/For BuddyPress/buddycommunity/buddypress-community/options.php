<?php

global $options, $options2;

foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options2 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

if( function_exists('bp_exists') ) {
$bp_existed = 'true';
} else {
$bp_existed = 'false';
}

?>