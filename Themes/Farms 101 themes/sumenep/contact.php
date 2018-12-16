<?php
/*
Template Name: Contact
*/
$cont_question = "7+5 = ?";
$cont_answer = "12";
?>
<?php get_header(); ?>

<div id="content">
 <div id="headr">
    <h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?>
      </a></h1>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>
   <div id="navr">
  <ul class="menu">
    <li <?php if(is_home()){echo 'class="current_page_item"';}?>><a href="<?php bloginfo('siteurl'); ?>/" title="Home">Home</a></li>
    <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
	<?php wp_register('<li class="admintab">','</li>'); ?>
   </ul>
</div>

  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post">
    <?php
					//validate email adress
					function is_valid_email($email)
					{
  						return (eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email));
					}
					function is_valid_user($answer)
					{
						global $cont_answer;
						if ($answer == $cont_answer) { return true; } else { return false;}
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

					$cont_name    = (!empty($_POST['cont_name']))    ? $_POST['cont_name']    : "";
					$cont_email   = (!empty($_POST['cont_email']))   ? $_POST['cont_email']   : "";
					$cont_url     = (!empty($_POST['cont_url']))     ? $_POST['cont_url']     : "";
					$cont_ans     = (!empty($_POST['cont_ans']))     ? $_POST['cont_ans']     : "";
					$cont_message = (!empty($_POST['cont_message'])) ? $_POST['cont_message'] : "";
					$cont_message = clean($cont_message);
					$error_msg = "";
					$send = 0;
					if (!empty($_POST['submit'])) {			
						$send = 1;
						if (empty($cont_name) || empty($cont_email) || empty($cont_message) || empty($cont_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>Please fill in all required fields.</strong></p>\n";
							$send = 0;							
						}						
						if (!is_valid_email($cont_email)) {
							$error_msg.= "<p style='color:#a00'><strong>Your email adress failed to validate.</strong></p>\n";
							$send = 0;
						}	
						if (!is_valid_user($cont_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>Incorrect Answer to the AntiSpam Question.</strong></p>\n";
							$send = 0;
						}									
					}
					if (!$send) { ?>
    <h2 class="post-title">
      <?php the_title(); ?>
    </h2>
    <?php edit_post_link(); ?>
    <div class="post-content">
      <?php the_content(__("Continue Reading &#187;"));
							?>
      <?php echo $error_msg;?>
      <form method="post" action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" id="contactform">
        <fieldset>
        <strong>Name</strong>*<br/>
        <input type="text" class="textbox" id="cont_name" name="cont_name" value="<?php echo $cont_name ;?>" />
        <br/>
        <br/>
        <strong>Email</strong>*<br/>
        <input type="text" class="textbox" id="cont_email" name="cont_email" value="<?php echo $cont_email ;?>" />
        <br/>
        <br/>
        <strong><?php _e('Website');?></strong><br/>
        <input type="text" class="textbox" id="cont_url" name="cont_url" value="<?php echo $cont_url ;?>" />
        <br/>
        <br/>
        <strong>AntiSpam Verification: <?php echo $cont_question; ?> </strong>*<br/>
        <input type="text" class="textbox" id="cont_ans" name="cont_ans" value="<?php echo $cont_ans ;?>" />
        <br/>
        <strong>Message</strong>*<br/>
        <textarea id="cont_message" name="cont_message" cols="100%" rows="10"><?php echo $cont_message ;?></textarea>
        <br/>
        <input type="submit" id="submit" name="submit" value="<?php _e('Send Message');?>" />
        </fieldset>
      </form>
        <p class="post-info">*: Required Fields</p>
    </div>
    <?php
					} else {
						$displayName_array	= explode(" ",$cont_name);
						$displayName = htmlentities(utf8_decode($displayName_array[0]));
			
						$header  = "MIME-Version: 1.0\n";
						$header .= "Content-Type: text/plain; charset=\"utf-8\"\n";
						$header .= "From:" . encodeMailHeader($cont_name) . "<" . $cont_email . ">\n";
						$email_subject	= "[" . get_settings('blogname') . "] " . encodeMailHeader($cont_name);
						$email_text		= "From......: " . $cont_name . "\n" .
							  "Email.....: " . $cont_email . "\n" .
							  "Url.......: " . $cont_url . "\n\n" .
							  $cont_message;

						if (@mail(get_settings('admin_email'), $email_subject, $email_text, $header)) {
							echo "<h2>Hello " . $displayName . ",</h2><p>thanks for your message! I'll get back to you as soon as possible.</p>";
						}
					}
					?>
    <?php endwhile; ?>
  </div>
  <?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
