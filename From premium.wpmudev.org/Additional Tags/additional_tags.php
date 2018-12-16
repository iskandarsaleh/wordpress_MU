<?php
/*
Plugin Name: Additional Tags
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.0.0
Author URI:
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_filter('edit_allowedposttags', 'additional_tags');
add_filter('edit_allowedtags', 'additional_tags');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function additional_tags($tags) {
	$add_tags = array(
		'iframe' => array(
			'width' => array(), 'height' => array(),
			'frameborder' => array(), 'src' => array(),
			'scrolling' => array(), 'style' => array()
			),
		'object' => array(
			'width' => array(), 'height' => array()
			),
		'param' => array(
			'name' => array(), 'value' => array()
			),
		'embed' => array(
			'src' => array(), 'type' => array(),
			'wmode' => array(), 'width' => array(),
			'height' => array(), 'name' => array(),
			'bgcolor' => array(), 'flashVars' => array(),
			'allowFullScreen' => array(), 'allowScriptAccess' => array(),
			'seamlesstabbing' => array(), 'swLiveConnect' => array(),
			'pluginspage' => array()
			),
		'script' => array(
			'type' => array(), 'src' => array(),
			'charset' => array()
			),
		'div' => array(
			'class' => array(), 'id' => array(),
			'style' => array()
			),
		'style' => array(
			'type' => array()
			)
	);
	
	$tags_merged = array_merge($tags, $add_tags);
	return $tags_merged;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>