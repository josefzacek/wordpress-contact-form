<?php
/*
 Template name: Contact page
 */
?>


<?php

$field ="";
$security ="";
$error_occured ="";

// if submit button is pressed
if(isset($_POST['contact-form-submit']))
{
    // check if security question is correct
	if(isset($_POST['contact-form-security']) && $_POST['contact-form-security'] == 11)
	{
        // check if all fields are filled out
		    if(isset($_POST['contact-form-name']) && isset($_POST['contact-form-email']) && isset($_POST['contact-form-phone']) && isset($_POST['contact-form-message']))
        {
            // Data Variables
			$contact_name = htmlentities($_POST['contact-form-name']);
			$contact_email = htmlentities($_POST['contact-form-email']);
			$contact_phone = htmlentities($_POST['contact-form-phone']);
			$contact_message = htmlentities($_POST['contact-form-message']);
		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 	
		    $headers .= 'From: ' . $contact_email . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
            
                // check if variables not empty
                if(!empty($contact_name) && !empty($contact_email) && !empty($contact_phone) && !empty($contact_message))
                { 
                   $to = get_option("admin_email");
                   $subject = "Neenan cycling contact form";
                   $body = "<b>Name:</b>"
                           ."<br/>"
                           .$contact_name
                           ."<br/>"
                           ."<b>Email:</b>"
                           ."<br/>"
                           .$contact_email
                           ."<br/>"
                           ."<b>Phone:</b>"
                           ."<br/>"
                           .$contact_phone 
                           ."<br/>"
                           ."<b>Message:</b>"
                           ."<br/>"
                           .$contact_message;
                                
                                // send data 
                                if (mail($to, $subject, $body, $headers))
				                {
					               $emailSent = true;
			                    }// end of (if) send data
                                else
                                {
                                    $error_occured = "Sorry an error occurred";
                                }// end of (else) send data

                }// end of (if) check if variables not empty
                else
                { 
                    $field = "Please fill out this field!";
                }// end of (else) check if variables not empty
    
        }// end of (if) all fields filled out
        else 
        { 
            $field = "Required!";
		}// end of (else) all fields filled out
	
	}// end of (if) check if security question is correct
	else 
    {
	    $field = "All Field are required!";
	    $security = "/ Wrong answer";	    	
    }// end of (else) check id security question is correct
	
}// end of (if) submit button is pressed

?>

<?php 
	$emailSent = true;
	$contact_name = "Jim More";
?> 




<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>


    	<article id="contact-tmp" class="clearfix">
    	
    	<?php if(isset($emailSent) && $emailSent == true) { ?>

	<div style="text-align:center; margin: 50px 0;">
		<a href="<?php echo home_url(); ?>">
			<img src="<?php echo bloginfo('template_url')?>/images/thank-you.png" alt="Thank you" style="max-width: 197px;">
		</a>
		<h1>Thank You <span id="thank-you-name"><?php echo $contact_name;?></span>,</h1>
		<p>You will be shortly contacted by our staff with answers to your comment.</p>
		<p>Return to <a href="<?php echo home_url(); ?>">Home page</a></p>
	</div>

<?php } else { ?>
    	
			<h1 class="contact-title">Contact Neenan Group</h1>
			<hr class="hr-middle">

			<div id="map-canvas"></div>

			<section id="contact-info">

				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>

					<?php the_content(); ?>

				
			</section><!-- /contact-info-->
			
			<section id="contact-form">
				<h2>Contact form:</h2>
				<span class="error"><?php echo $error_occured;?></span>

				<form action="<?php the_permalink(); ?>" method="post">

					<p>
						<label for="contact-form-name">Name: <sup>*</sup><span class="error"><?php echo $field;?></span></label><br>
						<input type="text" name="contact-form-name" id="contact-form-name">
					</p>

					<p>
						<label for="contact-form-email">Email: <sup>*</sup><span class="error"><?php echo $field;?></span></label><br>
						<input type="email" name="contact-form-email" id="contact-form-email">
					</p>

					<p>
						<label for="contact-form-phone">Phone: <sup>*</sup><span class="error"><?php echo $field;?></span></label><br>
						<input type="text" name="contact-form-phone" id="contact-form-phone">
					</p>

					<p>
						<label for="contact-form-message">Message <sup>*</sup><span class="error"><?php echo $field;?></span></label><br>
						<textarea name="contact-form-message" id="contact-form-message"></textarea>
					</p>
					
					<p>
						<label for="contact-form-security">What is 10 + 1 <sup>*</sup><span class="error"><?php echo $field;?> <?php echo $security; ?></span></label><br>
						<input type="tel" name="contact-form-security" id="contact-form-security">
					</p>
					
					<p>
						<input type="submit" name="contact-form-submit" value="Submit">
					</p>
				</form>
       </section><!-- /contact-form -->
       		<?php endwhile; ?>
       	<?php endif; ?>
<?php } ?>



		</article>
		
<?php
	// scroll to form if error
	   if ($field || $error_occured) {
		echo "<script> document.getElementById('contact-form').scrollIntoView(); </script>"; // if error scroll to #contact-form anchor
	   }
?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

