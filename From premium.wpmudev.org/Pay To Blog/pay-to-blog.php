<?php
/*
Plugin Name: Pay To Blog
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.5.2
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
add_action('admin_menu', 'pay_to_blog_plug_pages');
add_filter('wpabar_menuitems', 'pay_to_blog_admin_bar');
add_action('admin_head', 'pay_to_blog_blog_check');
add_action('admin_menu', 'pay_to_blog_modify_menu_items',99);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function pay_to_blog_modify_menu_items() {
	global $submenu, $menu, $wpdb;
	if ( $wpdb->blogid != 1 && !is_site_admin() ) {
	//if ( $wpdb->blogid != 1 ) {
		$blog_expire = get_option('blog_expire');
		if ( empty( $blog_expire ) || $blog_expire == '0' ) {
				$now = time();
				$now = $now - 30;
				$blog_expire = $demo_period_days = get_site_option( "demo_period_days" );
				$blog_expire = $blog_expire * 86400;
				$blog_expire = $now + $blog_expire;
				update_option('blog_expire', $blog_expire);
		}
		if ( time() > $blog_expire ) {
			for ( $counter = 0; $counter <= 101; $counter += 1) {
				unset($menu[$counter]);
			}
			$menu[5] = array(__('Blog Account'), 'read', 'blog.php');
		}
	}
}

function pay_to_blog_blog_check() {
	global $wpdb;
	if ( $wpdb->blogid != 1 && !is_site_admin() ) {
		if ( !strpos($_SERVER['REQUEST_URI'], 'blog') ) {
			$blog_expire = get_option('blog_expire');
			if ( empty( $blog_expire ) || $blog_expire == '0' ) {
				$now = time();
				$now = $now - 30;
				$blog_expire = $demo_period_days = get_site_option( "demo_period_days" );
				$blog_expire = $blog_expire * 86400;
				$blog_expire = $now + $blog_expire;
				update_option('blog_expire', $blog_expire);
			}
			if ( time() > $blog_expire ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='blog.php';
				</script>
				";
				//wp_redirect('blog.php');
			}
		}
	}
}

function pay_to_blog_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', 'Pay To Blog', 'Pay To Blog', 10, 'pay-to-blog', 'pay_to_blog_output');
	}
	if ( $wpdb->blogid != 1 ) {
		add_menu_page('Blog Account', 'Blog Account', 0, 'blog.php');
	}
}

function pay_to_blog_admin_bar( $menu ) {
	unset( $menu['blog.php'] );
	return $menu;
}

function pay_to_blog_extend($period, $blog_id) {
	switch_to_blog($blog_id);
	$now = time();
	if ( $period == '1' ) {
		$expires = $now + 2629744;
	} else if ( $period == '3' ) {
		$expires = $now + 7889231;
	} else if ( $period == '12' ) {
		$expires = $now + 31556926;
	}
	update_option( 'blog_expire', $expires );
	restore_current_blog();
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function pay_to_blog_paypal_button_output($period) {
	global $wpdb, $current_site, $current_user;
	// Live URL:	https://www.paypal.com/cgi-bin/webscr
	// Sandbox URL:	https://www.sandbox.paypal.com/cgi-bin/webscr
	if (get_site_option( "pay_to_blog_paypal_status" ) == 'live'){
		$action = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
		$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}

	$blog_url = get_blogaddress_by_id($wpdb->blogid);
	if ( $period == '1' ) {
		$amount = get_site_option( "pay_to_blog_1_cost" );
	} else if ( $period == '3' ) {
		$amount = get_site_option( "pay_to_blog_3_cost" );
	} else if ( $period == '12' ) {
		$amount = get_site_option( "pay_to_blog_12_cost" );
	}
	if ( get_site_option( "pay_to_blog_paypal_payment_type" ) == 'single' ) {
		$button = '
		<form action="' . $action . '" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="' . get_site_option( "pay_to_blog_paypal_email" ) . '">
			<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Blog Activation">
			<input type="hidden" name="item_number" value="' . $period . '">
			<input type="hidden" name="amount" value="' . $amount . '">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/blog.php?updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/blog.php?updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'pay-to-blog-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "pay_to_blog_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "pay_to_blog_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $period . '_' . get_site_option( "pay_to_blog_currency" ) . '_' . $wpdb->blogid . '">
			<input type="hidden" name="bn" value="PP-BuyNowBF">
			<p class="submit" style="border:none;padding-top:2px;">
			<input type="submit" name="Submit" value="PayPal">
			</p>
		</form>
		';
	} else {
		/*
		a3 - amount to billed each recurrence
		p3 - number of time periods between each recurrence
		t3 - time period (D=days, W=weeks, M=months, Y=years)
		*/
		$button = '
		<form action="' . $action . '" method="post">
			<input type="hidden" name="cmd" value="_xclick-subscriptions">
			<input type="hidden" name="business" value="' . get_site_option( "pay_to_blog_paypal_email" ) . '">
			<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Blog Activation">
			<input type="hidden" name="item_number" value="' . $period . '">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/blog.php?updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/blog.php?updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'pay-to-blog-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "pay_to_blog_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "pay_to_blog_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $period . '_' . get_site_option( "pay_to_blog_currency" ) . '_' . $wpdb->blogid . '">
			<input type="hidden" name="a3" value="' . $amount . '">
			<input type="hidden" name="p3" value="' . $period . '">
			<input type="hidden" name="t3" value="M">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">
			<p class="submit" style="border:none;padding-top:2px;">
			<input type="submit" name="Submit" value="PayPal">
			</p>
		</form>
		';
	}
	return $button;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function pay_to_blog_output() {
	global $wpdb, $wp_roles, $current_user;
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
			<h2><?php _e('Pay To Blog Settings') ?></h2>
            <form method="post" action="wpmu-admin.php?page=pay-to-blog&action=process">
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Currency') ?></th> 
                <td><select name="pay_to_blog_currency">
				<?php
					$pay_to_blog_currency = get_site_option( "pay_to_blog_currency" );
                    $sel_currency = empty($pay_to_blog_currency) ? 'USD' : $pay_to_blog_currency;
                    $currencies = array(
                        'AUD' => 'AUD - Australian Dollar',
                        'CAD' => 'CAD - Canadian Dollar',
                        'CHF' => 'CHF - Swiss Franc',
                        'CZK' => 'CZK - Czech Koruna',
                        'DKK' => 'DKK - Danish Krone',
                        'EUR' => 'EUR - Euro',
                        'GBP' => 'GBP - Pound Sterling',
                        'HKD' => 'HKD - Hong Kong Dollar',
                        'HUF' => 'HUF - Hungarian Forint',
                        'JPY' => 'JPY - Japanese Yen',
                        'NOK' => 'NOK - Norwegian Krone',
                        'NZD' => 'NZD - New Zealand Dollar',
                        'PLN' => 'PLN - Polish Zloty',
                        'SEK' => 'SEK - Swedish Krona',
                        'SGD' => 'SGD - Singapore Dollar',
                        'USD' => 'USD - U.S. Dollar'
                        );
                
                    foreach ($currencies as $k => $v) {
                        echo '		<option value="' . $k . '"' . ($k == $sel_currency ? ' selected' : '') . '>' . wp_specialchars($v, true) . '</option>' . "\n";
                    }
                ?>
                </select>
                <br /><?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Email') ?></th> 
                <td><input type="text" name="pay_to_blog_paypal_email" value="<?php echo get_site_option( "pay_to_blog_paypal_email" ); ?>" />
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Site') ?></th> 
                <td><select name="pay_to_blog_paypal_site">
                <?php
                    $pay_to_blog_paypal_site = get_site_option( "pay_to_blog_paypal_site" );
                    $sel_locale = empty($pay_to_blog_paypal_site) ? 'US' : $pay_to_blog_paypal_site;
                    $locales = array(
                        'AU'	=> 'Australia',
                        'AT'	=> 'Austria',
                        'BE'	=> 'Belgium',
                        'CA'	=> 'Canada',
                        'CN'	=> 'China',
                        'FR'	=> 'France',
                        'DE'	=> 'Germany',
                        'IT'	=> 'Italy',
                        'NL'	=> 'Netherlands',
                        'PL'	=> 'Poland',
                        'ES'	=> 'Spain',
                        'CH'	=> 'Switzerland',
                        'GB'	=> 'United Kingdom',
                        'US'	=> 'United States'
                        );
                
                    foreach ($locales as $k => $v) {
                        echo '		<option value="' . $k . '"' . ($k == $sel_locale ? ' selected' : '') . '>' . wp_specialchars($v, true) . '</option>' . "\n";
                    }
                ?>
                </select>
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Mode') ?></th> 
                <td><select name="pay_to_blog_paypal_status">
                <option value="live" <?php if (get_site_option( "pay_to_blog_paypal_status" ) == 'live') echo 'selected="selected"'; ?>><?php _e('Live Site') ?></option>
                <option value="test" <?php if (get_site_option( "pay_to_blog_paypal_status" ) == 'test') echo 'selected="selected"'; ?>><?php _e('Test Mode (Sandbox)') ?></option>
                </select>
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Payment Type') ?></th> 
                <td><select name="pay_to_blog_paypal_payment_type">
                <option value="single" <?php if (get_site_option( "pay_to_blog_paypal_payment_type" ) == 'single') echo 'selected="selected"'; ?>><?php _e('Single') ?></option>
                <option value="recurring" <?php if (get_site_option( "pay_to_blog_paypal_payment_type" ) == 'recurring') echo 'selected="selected"'; ?>><?php _e('Recurring') ?></option>
                </select>
                <br />
                <?php _e('Recurring = PayPal Subscription') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('1 Month') ?></th> 
                <td><select name="pay_to_blog_1_cost">
				<?php
					$pay_to_blog_1_cost = get_site_option( "pay_to_blog_1_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $pay_to_blog_1_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for one month in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('3 Months') ?></th> 
                <td><select name="pay_to_blog_3_cost">
				<?php
					$pay_to_blog_3_cost = get_site_option( "pay_to_blog_3_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $pay_to_blog_3_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for three months in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('12 Months') ?></th> 
                <td><select name="pay_to_blog_12_cost">
				<?php
					$pay_to_blog_12_cost = get_site_option( "pay_to_blog_12_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $pay_to_blog_12_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for one year in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Demo Period') ?></th> 
                <td><select name="demo_period_days">
				<?php
					$demo_period_days = get_site_option( "demo_period_days" );
					$counter = 0;
					for ( $counter = 0; $counter <= 101; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $demo_period_days ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Period (in days) before users have to pay to use their blog'); ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Message') ?></th>
                <td>
                <textarea name="pay_to_blog_message" type="text" rows="5" wrap="soft" id="pay_to_blog_message" style="width: 95%"/><?php echo stripslashes( get_site_option('pay_to_blog_message') ) ?></textarea>
                <br /><?php _e('This message is displayed at the top of the "Blog" page.') ?></td>
                </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
            </p>
            </form>
            <h3><?php _e('Extend Blog') ?></h3>
            <form method="post" action="wpmu-admin.php?page=pay-to-blog&action=extend">
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Blog ID') ?></th> 
                <td><input type="text" name="bid" value="" />
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Period') ?></th> 
                <td><select name="extend_period">
				<?php
					$counter = 0;
					for ( $counter = 1; $counter <= 365; $counter += 1) {
                        echo '<option value="' . $counter . '">' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Period (in days) you wish to extend the blog.'); ?></td> 
                </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
            </p>
            </form>
			<?php
		break;
		//---------------------------------------------------//
		case "process":
			update_site_option( "pay_to_blog_currency", $_POST[ 'pay_to_blog_currency' ] );
			update_site_option( "pay_to_blog_paypal_email", $_POST[ 'pay_to_blog_paypal_email' ] );
			update_site_option( "pay_to_blog_paypal_site", $_POST[ 'pay_to_blog_paypal_site' ] );
			update_site_option( "pay_to_blog_message", addslashes( $_POST[ 'pay_to_blog_message' ] ) );
			update_site_option( "pay_to_blog_paypal_status", $_POST[ 'pay_to_blog_paypal_status' ] );
			update_site_option( "pay_to_blog_paypal_payment_type", $_POST[ 'pay_to_blog_paypal_payment_type' ] );
			update_site_option( "pay_to_blog_1_cost", $_POST[ 'pay_to_blog_1_cost' ] );
			update_site_option( "pay_to_blog_3_cost", $_POST[ 'pay_to_blog_3_cost' ] );
			update_site_option( "pay_to_blog_12_cost", $_POST[ 'pay_to_blog_12_cost' ] );
			update_site_option( "demo_period_days", $_POST[ 'demo_period_days' ] );
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=pay-to-blog&updated=true&updatedmsg=" . urlencode(__('Changes saved.')) . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "extend":
			if ( isset($_POST['Cancel']) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=pay-to-blog';
				</script>
				";
			} else {
				$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $_POST[ 'bid' ] . "'");
				if ( $blog_count > 0 ) {
					switch_to_blog($_POST[ 'bid' ]);
					$blog_expire = get_option('blog_expire');
					$now = time();
					if ( $blog_expire > $now ) {
						$expires= $_POST[ 'extend_period' ];
						$expires = $expires * 86400;
						$expires = $blog_expire + $expires;
					} else {
						$expires = $_POST[ 'extend_period' ];
						$expires = $expires * 86400;
						$expires = $now + $expires;
					}
					update_option( 'blog_expire', $expires );
					restore_current_blog();
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='wpmu-admin.php?page=pay-to-blog&updated=true&updatedmsg=" . urlencode(__('Blog extended.')) . "';
					</script>
					";
				} else {
					?>
                    <h2><?php _e('Extend Blog') ?></h2>
                    <p><?php _e('Invalid blog ID. Please try again.') ?></p>
                    <form method="post" action="wpmu-admin.php?page=pay-to-blog&action=extend">
                    <table class="form-table">
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Blog ID') ?></th> 
                        <td><input type="text" name="bid" value="" />
                        <br />
                        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                        </tr>
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Period') ?></th> 
                        <td><select name="extend_period">
                        <?php
                            $counter = 0;
                            for ( $counter = 1; $counter <= 365; $counter += 1) {
                                echo '<option value="' . $counter . '">' . $counter . '</option>' . "\n";
                            }
                        ?>
                        </select>
                        <br /><?php _e('Period (in days) you wish to extend the blog.'); ?></td> 
                        </tr>
                    </table>
                    
                    <p class="submit">
                    <input type="submit" name="Cancel" value="<?php _e('Cancel') ?>" />
                    <input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
                    </p>
                    </form>
	    	        <?php
				}
			}
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function pay_to_blog_account_output() {
	global $wpdb, $wp_roles, $current_user;
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$blog_expire = get_option('blog_expire');
			if ( empty( $blog_expire ) || $blog_expire == '0' ) {
				$now = time();
				$now = $now - 30;
				$blog_expire = $demo_period_days = get_site_option( "demo_period_days" );
				$blog_expire = $blog_expire * 86400;
				$blog_expire = $now + $blog_expire;
				update_option('blog_expire', $blog_expire);
			}
			if ( time() > $blog_expire ) {
				$blog = 'inactive';
			} else {
				$blog = 'active';
			}
			?>
			<h2><?php _e('Blog') ?>: <?php _e( ucfirst( $blog ) ); ?></h2>
			<p><?php echo stripslashes( get_site_option('pay_to_blog_message') ) ?></p>
			<?php
			if ( $blog == 'active' ) {
				echo __('Expires') . ': ' . date(get_option('date_format'), get_option('blog_expire', 0));
			} else {
				echo '<p>' . __('Note: Depending on your payment method it may take just a few minutes (Credit Card or PayPal funds) or it may take several days (eCheck) for your account to be activated.') . '</p>';
				echo '<p class="submit" style="padding-top:2px;">';
				echo '' . __('Activate blog for one month') . ' (' . __('for') . ' ' . get_site_option( "pay_to_blog_1_cost" ) . ' ' . get_site_option( "pay_to_blog_currency" ) . '):<br />';
				echo pay_to_blog_paypal_button_output(1);
				echo '</p>';
				echo '<p class="submit" style="padding-top:2px;">';
				echo '' . __('Activate blog for three months') . ' (' . __('for') . ' ' . get_site_option( "pay_to_blog_3_cost" ) . ' ' . get_site_option( "pay_to_blog_currency" ) . '):<br />';
				echo pay_to_blog_paypal_button_output(3);
				echo '</p>';
				echo '<p class="submit" style="padding-top:2px;">';
				echo '' . __('Activate blog for one year') . ' (' . __('for') . ' ' . get_site_option( "pay_to_blog_12_cost" ) . ' ' . get_site_option( "pay_to_blog_currency" ) . '):<br />';
				echo pay_to_blog_paypal_button_output(12);
				echo '</p>';
			}
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>
