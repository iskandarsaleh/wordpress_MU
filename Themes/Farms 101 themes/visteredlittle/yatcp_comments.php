<?php
 		/*
		Copyright 2007  Joachim Praetorius (yatcp@organisiert.net)

    YATCP is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation using version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
		*/
?>

<?php // Do not delete these lines
	if ('yatcp_comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
							echo ('<p class="nocomments">'.__('This post is password protected. To view it please enter your password below:', 'vistered-little').'<p>');
							return;
            }
        }
/* You can start editing here.  */ ?>
	<span id="comments"></span> 
	<?php yatcp_show_comments();?>
	<?php require( TEMPLATEPATH .'/comments-form.php'  );	