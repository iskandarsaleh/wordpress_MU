<?php
/*
Plugin Name: Lock Posts
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.0
Author URI: http://incsub.com
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

require_once('admin.php');
$title = __('Post Locked');
$parent_file = 'locked.php';
require_once('admin-header.php');

lock_posts_locked();

include('admin-footer.php');
?>