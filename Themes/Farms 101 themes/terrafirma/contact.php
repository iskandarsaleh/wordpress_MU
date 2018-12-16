<?php
/*
Template Name: Contact
*/
?>
<?php get_header();?>

		<div id="content">
		
			<!-- primary content start -->
			<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
		<div class="post">
		<?php
		//validate email adress
		function is_valid_email($email)
		{
  			return (eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email));
		}

		//clean up text
		function clean($text)
		{
			return stripslashes($text);
		}

		//encode special chars (in name and subject)
		function encodeMailHeader ($string, $charset = 'UTF-8')
		{
    		return sprintf ('=?%s?B?%s?=', strtoupper ($charset),base64_encode ($string));
		}

		$tf_name    = (!empty($_POST['tf_name']))    ? $_POST['tf_name']    : "";
		$tf_email   = (!empty($_POST['tf_email']))   ? $_POST['tf_email']   : "";
		$tf_url     = (!empty($_POST['tf_url']))     ? $_POST['tf_url']     : "";
		$tf_subject = (!empty($_POST['tf_subject'])) ? $_POST['tf_subject'] : "";
		$tf_message = (!empty($_POST['tf_message'])) ? $_POST['tf_message'] : "";

		$tf_subject = clean($tf_subject);
		$tf_message = clean($tf_message);
		$error_msg = "";
		$send = 0;

		if (!empty($_POST['submit'])) {			
			$send = 1;
			if (empty($tf_name) || empty($tf_email) || empty($tf_message)) {
				$error_msg.= "<p><strong>Please fill in all required fields.</strong></p>\n";
				$send = 0;
			}
			if (!is_valid_email($tf_email)) {
				$error_msg.= "<p><strong>Your email adress failed to validate.</strong></p>\n";
				$send = 0;
			}
		}
		if (!$send) { ?>

			<div class="header">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
			<div class="entry">
			<?php
				the_content();
				echo $error_msg;
			?>
			<table width="100%" cellspacing="5px" cellpadding="5px" class="editform">

			<form method="post" action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" id="contactform">
				<fieldset>
				<?php
				tf_heading( "Name" );
				tf_input( "tf_name", "text", "", $tf_name );	
				echo "<br/>";
				tf_heading( "Email" );
				tf_input( "tf_email", "text", "", $tf_email );					
				echo "<br/>";
				tf_heading( "Subject" );
				tf_input( "tf_subject", "text", "", $tf_subject );	
				echo "<br/>";
				tf_heading( "Website" );
				tf_input( "tf_url", "text", "", $tf_url );	
				echo "<br/>";
				tf_heading( "Message" );
				tf_input( "tf_message", "textarea", "", $tf_message );	
				echo "<br/>";
				tf_heading( "Ready ?" );
				tf_input( "submit", "submit", "", " Send Message " );
				echo "<br/>";
				?>					
				</fieldset>
			</form>
			</table>
			</div>
		<?php
		} else {

			$displayName_array	= explode(" ",$tf_name);
			$displayName = htmlentities(utf8_decode($displayName_array[0]));

			$header  = "MIME-Version: 1.0\n";
			$header .= "Content-Type: text/plain; charset=\"utf-8\"\n";
			$header .= "From:" . encodeMailHeader($tf_name) . "<" . $tf_email . ">\n";
			$email_subject	= "[" . get_settings('blogname') . "] " . encodeMailHeader($tf_subject);
			$email_text		= "From......: " . $tf_name . "\n" .
							  "Email.....: " . $tf_email . "\n" .
							  "Url.......: " . $tf_url . "\n\n" .
							  $tf_message;

			if (@mail(get_settings('admin_email'), $email_subject, $email_text, $header)) {
				echo "<h2>Hey " . $displayName . ",</h2><p>thanks for your message! I'll get back to you as soon as possible.</p>";
			}
		}
		?>

	<?php endwhile; ?>

<?php endif; ?>
</div>
			<!-- primary content end -->	
		</div>		
	<?php get_sidebar();?>	
<?php get_footer();?>