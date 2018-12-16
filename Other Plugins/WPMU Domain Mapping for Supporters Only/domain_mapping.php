<?php
/*
Plugin Name: WordPress MU Domain Mapping
Plugin URI: http://ocaoimh.ie/wordpress-mu-domain-mapping/
Description: Map any blog on a WordPress MU website to another domain.
Version: 0.4.3
Author: Donncha O Caoimh
Author URI: http://ocaoimh.ie/
*/
/*  Copyright Donncha O Caoimh (http://ocaoimh.ie/)
    With contributions by Ron Rennick and others.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function dm_add_pages() {
	add_management_page( 'Domain Mapping', 'Domain Mapping', 'manage_options', 'domainmapping', 'dm_manage_page' );
}
add_action( 'admin_menu', 'dm_add_pages' );

function dm_manage_page() {
	global $wpdb;
	$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';

	if ( VHOST == 'no' ) {
		die( 'Sorry, domain mapping only works on virtual host installs.' );
	}
	if ( is_site_admin() ) {
		if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->dmtable}'") != $wpdb->dmtable) {
			$wpdb->query( "CREATE TABLE IF NOT EXISTS `{$wpdb->dmtable}` (
				`id` bigint(20) NOT NULL auto_increment,
				`blog_id` bigint(20) NOT NULL,
				`domain` varchar(255) NOT NULL,
				`active` tinyint(4) default '1',
				PRIMARY KEY  (`id`),
				KEY `blog_id` (`blog_id`,`domain`,`active`)
			);" );
			?> <div id="message" class="updated fade"><p><strong><?php _e('Domain mapping database table created.') ?></strong></p></div> <?php
		}
	}


	if ( !empty( $_POST[ 'action' ] ) ) {
		$domain = $wpdb->escape( preg_replace( "/^www\./", "", $_POST[ 'domain' ] ) );
		check_admin_referer( 'domain_mapping' );
		switch( $_POST[ 'action' ] ) {
			case "add":
			  if (function_exists(is_supporter) && !is_site_admin()) {
          if (!is_supporter())
         		break;
      	}
				if( null == $wpdb->get_row( "SELECT blog_id FROM {$wpdb->blogs} WHERE domain = '$domain'" ) && null == $wpdb->get_row( "SELECT blog_id FROM {$wpdb->dmtable} WHERE domain = '$domain'" ) )
					$wpdb->query( "INSERT INTO {$wpdb->dmtable} ( `id` , `blog_id` , `domain` , `active` ) VALUES ( NULL, '" . intval( $wpdb->blogid ) . "', '$domain', '1')" );
			break;
			case "delete":
				$wpdb->query( "DELETE FROM {$wpdb->dmtable} WHERE domain = '$domain'" );
			break;
			case "ipaddress":
				if( is_site_admin() )
					add_site_option( 'dm_ipaddress', $_POST[ 'ipaddress' ] );
			break;
		}
	}
	echo "<div class='wrap'><h2>Domain Mapping</h2>";
	if ( !file_exists( ABSPATH . '/wp-content/sunrise.php' ) ) {
		echo "Please copy sunrise.php to " . ABSPATH . "/wp-content/sunrise.php and uncomment the SUNRISE definition in " . ABSPATH . "wp-config.php";
		echo "</div>";
		die();
	}

	if ( !defined( 'SUNRISE' ) ) {
		echo "Please uncomment the line <em>//define( 'SUNRISE', 'on' );</em> in your " . ABSPATH . "wp-config.php";
		echo "</div>";
		die();
	}
  
  if (function_exists(is_supporter) && !is_site_admin()) {
    if (!is_supporter())
      echo '<p class="error fade" style="font-weight:bold;padding:10px;">Custom domain names are only available to '.get_site_option('site_name').' Supporters. <a title="Become a Supporter" href="./supporter.php">Why not become a Supporter today?</a></p>';
	}
	

	if ( is_site_admin() ) {
		echo '<h3>' . __( 'Site Admin Configuration' ) . '</h3>';
		echo "<p>" . __( "As a site admin on this site you can set the IP address users need to point their DNS A records at. If you don't know what it is, ping this blog to get the IP address." ) . "</p>";
		echo "<p>" . __( "If you use round robin DNS or another load balancing technique with more than one IP, enter each address, separating them by commas." ) . "</p>";
		echo '<form method="POST">';
		echo '<input type="hidden" name="action" value="ipaddress" />';
		_e( "Server IP Address: " );
		echo "<input type='text' name='ipaddress' value='" . get_site_option( 'dm_ipaddress' ) . "' />";
		wp_nonce_field( 'domain_mapping' );
		echo "<input type='submit' value='Save' />";
		echo "</form><br />";
	}
	$domains = $wpdb->get_results( "SELECT * FROM {$wpdb->dmtable} WHERE blog_id = '{$wpdb->blogid}'" );
	if ( is_array( $domains ) && !empty( $domains ) ) {
		?><h3><?php _e( 'Active domains on this blog' ); ?></h3><?php
		foreach( $domains as $details ) {
			echo '<form method="POST">';
			echo $details->domain . " ";
			echo '<input type="hidden" name="action" value="delete" />';
			echo "<input type='hidden' name='domain' value='{$details->domain}' />";
			echo "<input type='submit' value='Delete' />";
			wp_nonce_field( 'domain_mapping' );
			echo "</form><br />";
		}
		?><br /><?php
	}
	  echo '<h3>What is This?</h3><p>This is where your website is hosted here but it looks like it is somewhere else - on your own domain. Domain mapping allows you to have your own custom .com, .org, or .net web address for your blog. So instead of people visiting your website with the address "<strong>'.get_option('home').'</strong>", they can enter something like "<strong>http://mysite.com</strong>". Having a custom domain name is important if you want a professional look for your website. It allows you to have your own brand and a memorable address for your visitors. Follow these three steps to setup your custom domain:</p>';
		echo '<h3>1. Get Your Domain</h3><p>If you have a domain already, you can skip this step. If you do not have a domain name yet, you will need to purchase one through a registrar. We recommend GoDaddy as they are the cheapest and easiest. You can use this search box to find your domain through GoDaddy:<br />
  <FORM name="LookupForm" action="http://www.jdoqocy.com/interactive" method="get">
  <table width="468" style="margin-left:50px;border: 1px solid black; background-color:#bfdd2f;" border="0" cellpadding="0" cellspacing="0" bgcolor="#BFDD2F">
  	<tr>
  		<td width="411" style="padding-left:10px; padding-top:3px;" valign="top"><a href="http://www.anrdoezrs.net/click-3518128-10390987?url=http%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Fregistrar%2Fsearch.asp%3Fisc%3D0000000000"><img src="http://imagesak.godaddy.com/promos/banners/txt_finddom_green.gif" border="0" alt="Find a domain name now!"></a></td>
  		<td rowspan="2" width="58" height="58"><img src="http://imagesak.godaddy.com/promos/banners/30287_cjbanner_update_gd_notag.gif" border="0" width="125" height="58"></td>
  	</tr>
  	<tr>
  		<td style="padding-left:4px" valign="top">
  			<table border="0" cellpadding="0" cellspacing="0">
  				<tr>
  
  					<td width="280"><font size="1" style="font-size:11px" face="arial,helvetica"><input type="text" name="domainToCheck" size="30" maxlength="67" tabindex="1" style="font-size:11px;font-family:arial,helvetica;"></font>&nbsp;<font size="1" style="font-size:11px;font-family:arial,helvetica;" face="arial,helvetica"><select name="tld" id="tld" tabindex="2" style="font-size:11px;font-family:arial,helvetica;">
              <option value=".COM">.com</option>
  						<option value=".US">.us</option>
  						<option value=".BIZ">.biz</option>
              <option value=".INFO">.info</option>
              <option value=".NET">.net</option>
  						<option value=".ORG">.org</option>
  					  <option value=".WS">.ws</option>
  						<option value=".MOBI">.mobi</option>
              <option value=".ME">.me</option>
              <option value=".CO.UK">.CO.UK</option>
              <option value=".IN">.IN</option>
  						<option value=".AT">.at</option>
  						<option value=".ASIA">.asia</option>
  						</select></font></td>
  					<td width="55"><input type="hidden" name="checkAvail" value="1"><input type="image" name="submit" value="submit" tabindex="3" src="http://imagesak.godaddy.com/promos/banners/but_domsrch_ad_org.gif" border="0" alt="Click Here to Search for Your Domain."></td>
  				</tr>
  				<tr>
  					<td colspan="2"><a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.anrdoezrs.net/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Fregistrar%2Fsearch.asp%3Ftld%3D%252Ecom%26isc%3D0000000000">.com</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.dpbolvw.net/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fus.asp%3Ftld%3D%252Eus%26isc%3D0000000000">.us</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.tkqlhce.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fbiz.asp%3Ftld%3D%252Ebiz%26isc%3D0000000000">.biz</a> 
  			<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.kqzyfj.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Finfo.asp%3Ftld%3D%252Einfo%26isc%3D0000000000">.info</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.anrdoezrs.net/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Fregistrar%2Fsearch.asp%3Ftld%3D%252Enet%26isc%3D0000000000">.net</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.jdoqocy.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Fregistrar%2Fsearch.asp%3Ftld%3D%252Eorg%26isc%3D0000000000">.org</a> 
  			<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.kqzyfj.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fws.asp%3Ftld%3D%252Ews%26isc%3D0000000000">.ws</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.kqzyfj.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fmobi.asp%3Ftld%3D%252Ename%26isc%3D0000000000">.mobi</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.tkqlhce.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Fregistrar%2Fsearch.asp%3Ftld%3D%252Eme%26isc%3D0000000000">.me</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.jdoqocy.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fcctlds.asp%3Ftld%3D%252Eco.uk%26isc%3D0000000000">.co.uk</a> 
  			<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.jdoqocy.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fcctlds.asp%3Ftld%3D%252Ein%26isc%3D0000000000">.in</a>&nbsp;<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.anrdoezrs.net/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fcctlds.asp%3Ftld%3D%252Eat%26isc%3D0000000000">.at</a> 
  			<a style="font-family:arial, sans serif; color:#0033cc; font-size:11px" href="http://www.tkqlhce.com/click-3518128-10390987?url=https%3A%2F%2Fwww.godaddy.com%2Fgdshop%2Ftlds%2Fcctlds.asp%3Ftld%3D%252Easia%26isc%3D0000000000">.asia</a>&nbsp</td>
  
  				</tr>
  			</table>
  		</td>
  	</tr>
  </table>
  
  <input type="hidden" name="aid" value="10390987"/>
  <input type="hidden" name="pid" value="3518128"/>
  <input type="hidden" name="url" value="http://www.godaddy.com/gdshop/registrar/search.asp?isc=0000000000"/>
  </form>
  <img src="http://www.tqlkg.com/image-3518128-10390987" width="1" height="1" border="0"/>
  </p>';
	$dm_ipaddress = get_site_option( 'dm_ipaddress', 'IP not set by admin yet.' );
	if( strpos( $dm_ipaddress, ',' ) ) {
		echo "<h3>2. Configure Your DNS</h3><p>" . __( 'To map a domain you will need to add DNS "A" records in your registrar\'s DNS settings pointing to the IP addresses of this server: ' ) . "<strong>" . $dm_ipaddress . "</strong></p>";
	} else {
		echo "<h3>2. Configure Your DNS</h3><p>" . __( 'To map a domain you will need to add a DNS "A" record in your registrar\'s DNS settings pointing to the IP address of this server: ' ) . "<strong>" . $dm_ipaddress . "</strong></p>";
	    }
	echo '<p>The instructions for creating an "A" record will vary depending on your domain registrar. Login to your registrar and look for a link to something similar to "Total DNS", "Advanced DNS" or "DNS Management". On that page you will usually find a simple form to edit or add your "A" record.</p>';
  echo '<p>Here is an example walkthrough if GoDaddy is your registrar:
  <ol style="list-style:decimal;margin:5px 50px 5px 50px;padding:10px 10px 10px 50px;border:1px gray solid;">
    <li>Visit godaddy.com, and go to the "Domains->My Domains" tab. You will be asked to login.</li>
    <li>Click on the domain from the list that you want to map to open it\'s admin page.</li>
    <li>Click on the "Total DNS" link.<br /><a target="_blank" href="http://missionsplace.com/files/2009/06/godaddy-domains.jpg"><img src="http://missionsplace.com/files/2009/06/godaddy-domains.jpg" class="attachment-medium" alt="" width="300" height="115"></a></li>
    <li>Click the edit button next to the default "A" record. If you have no default "A" record, click the "Add New A Record" button.<br /><a target="_blank" href="http://missionsplace.com/files/2009/06/godaddy-a-record.jpg"><img src="http://missionsplace.com/files/2009/06/godaddy-a-record.jpg" class="attachment-medium" alt="" width="300" height="103"></a></li>
    <li>Enter the IP address <strong>' . $dm_ipaddress . '</strong> and click ok to save it.</li>
    <li>You will have to wait a while until entering your domain name in a web browser forwards you to our website. This can take as long as 24 hours, but is usually much faster. Be patient!</li>
    <li>You can now add your domain name here on this page and you are done!</li>
  </ol>
  </p>';
  echo "<p>".'If you want to keep your main website somewhere else and only point a subdomain (like "blog.mysite.org") or some other prefix before the actual domain name you will need to add a CNAME record for that subdomain in your DNS pointing to this blog URL. "www" does not count because it will be removed from the domain name.'."</p>";
	
	echo "<h3>" . __( '3. Map Your Domain' ) . "</h3>";
	echo '<p>After completing steps 1 and 2 you just need to add your domain here.</p>';
	echo '<cite>Note: Adding your domain name here before you have created the "A" record and waited for it to forward properly could lock you out of your website until those steps are completed.</cite>';
	echo '<form method="POST">';
	echo '<input type="hidden" name="action" value="add" />';

	wp_nonce_field( 'domain_mapping' );
  if (function_exists(is_supporter) && !is_site_admin()) {
    if (!is_supporter()) {
      echo '<p class="error fade" style="font-weight:bold;padding:10px;"><a title="Become a Supporter" href="./supporter.php">Become a Supporter now</a> to enable domain mapping.</p>';
   		echo "http://www.<input type='text' name='domain' value='' disabled='disabled' />/";
	    echo "<input type='submit' value='Add' disabled='disabled' />";
   	} else {
      echo "http://www.<input type='text' name='domain' value='' />/";
	    echo "<input type='submit' value='Add' />";
    }
	} else {
    echo "http://www.<input type='text' name='domain' value='' />/";
  	echo "<input type='submit' value='Add' />";
  }
	
	echo "</form><br />";
  echo '<h3>Confused?</h3><p style="font-size:14px;background-color:#D8F3C0;border:1px solid #55F356;padding:5px;">We understand that changing your DNS records with your registrar may be a bit technical for you, so <strong>if you\'re having trouble please <a href="./support.php?page=tickets" title="Request Help">submit a support request</a> and we will walk you through it!</strong></p>';
  echo "</div>";
}

function domain_mapping_siteurl( $setting ) {
	global $wpdb, $current_blog;

	// To reduce the number of database queries, save the results the first time we encounter each blog ID.
	static $return_url = array();

	if ( !isset( $return_url[ $wpdb->blogid ] ) ) {
		$s = $wpdb->suppress_errors();

		// Try matching on the current URL domain and blog first. This will take priorty.
		$domain = $wpdb->get_var( $wpdb->prepare( "SELECT domain FROM {$wpdb->dmtable} WHERE domain = %s AND blog_id = %d LIMIT 1", preg_replace( "/^www\./", "", $_SERVER[ 'HTTP_HOST' ] ), $wpdb->blogid ) );

		// If no match, then try against the blog ID alone (which we get, without a 'preferred domain' setting,
		// will be a matter of luck.
		if ( empty( $domain ) ) {
			$domain = $wpdb->get_var( $wpdb->prepare( "SELECT domain FROM {$wpdb->dmtable} WHERE blog_id = %d", $wpdb->blogid ) );
		}

		$wpdb->suppress_errors( $s );
		$protocol = ( 'on' == strtolower( $_SERVER['HTTPS' ] ) ) ? 'https://' : 'http://';
		if ( $domain ) {
			$return_url[ $wpdb->blogid ] = untrailingslashit( $protocol . $domain . $current_blog->path );
			$setting = $return_url[ $wpdb->blogid ];
		} else {
			$return_url[ $wpdb->blogid ] = false;
		}
	} elseif ( $return_url[ $wpdb->blogid ] !== FALSE) {
		$setting = $return_url[ $wpdb->blogid ];
	}

	return $setting;
}

function domain_mapping_post_content( $post_content ) {
	global $wpdb;

	static $orig_urls = array();
	if ( ! isset( $orig_urls[ $wpdb->blog_id ] ) ) {
		remove_filter( 'pre_option_siteurl', 'domain_mapping_siteurl' );
		$orig_url = get_option( 'siteurl' );
		$orig_urls[ $wpdb->blog_id ] = $orig_url;
		add_filter( 'pre_option_siteurl', 'domain_mapping_siteurl' );
	} else {
		$orig_url = $orig_urls[ $wpdb->blog_id ];
	}
	$url = domain_mapping_siteurl( 'NA' );
	if ( $url == 'NA' )
		return $post_content;
	return str_replace( $orig_url, $url, $post_content );
}

if ( defined( 'DOMAIN_MAPPING' ) ) {
	add_filter( 'pre_option_siteurl', 'domain_mapping_siteurl' );
	add_filter( 'pre_option_home', 'domain_mapping_siteurl' );
	add_filter( 'the_content', 'domain_mapping_post_content' );
}

function redirect_to_mapped_domain() {
	global $current_blog;
	$protocol = ( 'on' == strtolower($_SERVER['HTTPS']) ) ? 'https://' : 'http://';
	$url = domain_mapping_siteurl( false );
	if ( $url && $url != untrailingslashit( $protocol . $current_blog->domain . $current_blog->path ) ) {
		wp_redirect( $url . $_SERVER[ 'REQUEST_URI' ] );
		exit;
	}
}
add_action( 'template_redirect', 'redirect_to_mapped_domain' );

// delete mapping if blog is deleted
function delete_blog_domain_mapping( $blog_id, $drop ) {
	global $wpdb;
	$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
	if ( $blog_id && $drop ) {
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->dmtable} WHERE blog_id  = %d", $blog_id ) );
	}
}
add_action( 'delete_blog', 'delete_blog_domain_mapping', 1, 2 );

// show mapping on site admin blogs screen
function ra_domain_mapping_columns( $columns ) {
	$columns[ 'map' ] = __( 'Mapping' );
	return $columns;
}
add_filter( 'wpmu_blogs_columns', 'ra_domain_mapping_columns' );

function ra_domain_mapping_field( $column, $blog_id ) {
	global $wpdb;
	static $maps = false;
	
	if ( $column == 'map' ) {
		if ( $maps === false ) {
			$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
			$work = $wpdb->get_results( "SELECT blog_id, domain FROM {$wpdb->dmtable} ORDER BY blog_id" );
			$maps = array();
			if($work) {
				foreach( $work as $blog ) {
					$maps[ $blog->blog_id ] = $blog->domain;
				}
			}
		}
		echo $maps[ $blog_id ];
	}
}
add_action( 'manage_blogs_custom_column', 'ra_domain_mapping_field', 1, 3 );
?>
