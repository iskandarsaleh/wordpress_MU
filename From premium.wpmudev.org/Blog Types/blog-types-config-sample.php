<?php
/*
Plugin Name: Blog Types
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Author URI: http://incsub.com
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

// Blog types
// name and nicename are required

$blog_types[0]['name'] = 'News';
$blog_types[0]['nicename'] = 'news';
$blog_types[0]['description'] = '';
$blog_types[0]['signup_only'] = 'no';

$blog_types[1]['name'] = 'Sports';
$blog_types[1]['nicename'] = 'sports';
$blog_types[1]['description'] = '';
$blog_types[1]['signup_only'] = 'no';

$blog_types[2]['name'] = 'Other';
$blog_types[2]['nicename'] = 'other';
$blog_types[2]['description'] = '';
$blog_types[2]['signup_only'] = 'no';

// Blog subtypes
// name, nicename and type nicename are required
// Note: If you are using subtypes you **MUST** have at least one subtype for each type

$blog_subtypes[0]['name'] = 'Politcs';
$blog_subtypes[0]['nicename'] = 'politics';
$blog_subtypes[0]['type_nicename'] = 'news';
$blog_subtypes[0]['description'] = '';

$blog_subtypes[1]['name'] = 'Technology';
$blog_subtypes[1]['nicename'] = 'technology';
$blog_subtypes[1]['type_nicename'] = 'news';
$blog_subtypes[1]['description'] = '';

$blog_subtypes[2]['name'] = 'Baseball';
$blog_subtypes[2]['nicename'] = 'baseball';
$blog_subtypes[2]['type_nicename'] = 'sports';
$blog_subtypes[2]['description'] = '';

$blog_subtypes[3]['name'] = 'Football';
$blog_subtypes[3]['nicename'] = 'football';
$blog_subtypes[3]['type_nicename'] = 'sports';
$blog_subtypes[3]['description'] = '';

$blog_subtypes[4]['name'] = 'Other';
$blog_subtypes[4]['nicename'] = 'other';
$blog_subtypes[4]['type_nicename'] = 'sports';
$blog_subtypes[4]['description'] = '';

$blog_subtypes[5]['name'] = 'Other';
$blog_subtypes[5]['nicename'] = 'other';
$blog_subtypes[5]['type_nicename'] = 'other';
$blog_subtypes[5]['description'] = '';


// Allow users to select one or multiple blog types
// Note: If you allow users to select multiple blog types, they cannot select a subtype
$blog_types_selection = 'single'; //Options: 'single' or 'multiple'

// Allow users to select one or multiple blog subtypes
$blog_subtypes_selection = 'single'; //Options: 'single' or 'multiple'

// Branding singular
$blog_types_branding_singular = __('Blog Type');
$blog_subtypes_branding_singular = __('Blog Subtype');

// Branding plural
$blog_types_branding_plural = __('Blog Types');
$blog_subtypes_branding_plural = __('Blog Subtypes');

// Display admin panel blog types page
$blog_types_display_admin_page = 'yes'; //Options: 'yes' or 'no'

// Display signup form blog types selection
$blog_types_display_signup_form = 'yes'; //Options: 'yes' or 'no'

// Enable subtypes
$blog_types_enable_subtypes = 'yes'; //Options: 'yes' or 'no'

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>