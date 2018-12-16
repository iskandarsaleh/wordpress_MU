<?php
/*
Plugin Name: Select All Blogs
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
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
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action("admin_footer", "select_all_blogs");
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function select_all_blogs(){
	if (strpos($_SERVER['REQUEST_URI'], 'wpmu-blogs')){
		?>
		<script type="text/javascript">
		function SelectAllBlogs() {
			input = '<th scope="col"><a href="wpmu-blogs.php?s=&amp;ip_address=&amp;sortby=id';
			output= '<th scope="col"><input type="checkbox" /> <a href="wpmu-blogs.php?s=&amp;ip_address=&amp;sortby=id';
			document.body.innerHTML = document.body.innerHTML.replace(input,output);
		}
		window.onload = SelectAllBlogs();
		</script>
		<?php
	}
}
?>