<?php
/*
Template Name: Contact page phpmailer
*/
?>

<?php

// set variables
$field ="";
$security ="";
$error_occured ="";

// if submit button is pressed
if(isset($_POST['send_contact_form']))
{
    // check if security question is correct
	if(isset($_POST['security']) && $_POST['security'] == 14)
	{
        // check if all fields are filled out
		if(isset($_POST['contact_name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['message']))
        {
        	// Data Variables
			$contact_name = htmlentities($_POST['contact_name']);
			$phone = htmlentities($_POST['phone']);
			$email = htmlentities($_POST['email']);
			$message = htmlentities($_POST['message']);
        
        	// check if variables not empty
            if(!empty($contact_name) && !empty($phone) && !empty($email) && !empty($message))
            {
        
				include_once($_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-phpmailer.php' );

				$mail = new PHPMailer();

				$mail->IsSMTP();

				$mail->IsHTML(true);

				$mail->AddAddress("joezacek@gmail.com");

				$mail->From = $_POST["email"];

				$mail->FromName = $_POST["contact_name"];

				$mail->Subject = "Breakaway contact form";

				$mail->Body ="<b>Name:</b> " . $_POST["contact_name"]."<br/>"
							."<b>Email:</b> " . $_POST["email"]."<br/>"
							."<b>Phone:</b> " . $_POST["phone"]."<br/>"
							."<b>Message:</b> " . $_POST["message"]; 


				if ($mail->Send()) {
					$emailSent = true;
				} else {
					$error_occured = "Sorry an error occurred";
				}
				
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



<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>


<div id="blue-banner">
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/teaser-text' ) ); ?>
</div> <!-- blue-banner end -->


<div id="content-wrapper">

  <article id="no-sidebar" class="contact-page">
    
    <?php if(isset($emailSent) && $emailSent == true) { ?>

	<div style="text-align:center; margin: 10px 0;">
		<img src="<?php bloginfo('template_url')?>/images/disney-minnie-mouse.png" alt="Minnie mouse" style="max-width: 917px; background-color: rgba(0, 0, 0, 0);
	-moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none;">
		<h1>Thank You <span id="thank-you-name"><?= $contact_name;?></span>,</h1>
		<p>You will be shortly contacted by our reservation staff with answers to your comment.</p>
		<p>Return to <a href="<?php echo home_url(); ?>">Home page</a></p>
	</div>

<?php } else { ?>

    <h1>Contact Breakaway</h1>

    <div id="map-canvas">
        <!-- google map here -->
    </div>

	
	<?php if (have_posts()) : ?>
	
	<?php while (have_posts()) : the_post(); ?>
		
		<section id="contact-page-content">
		    <?php the_content(); ?>
        </section>
 
<section id="contact-form-holder">
    <h2>Send us a message</h2>
    <p>We would love to hear from you. If you have any queries or comments please fill in the form below and one of our staff will get back to you.</p>
    
        
<form action="<?php the_permalink(); ?>" method="post">
 
<div id="name-phone-email">   
  <span class="error"><?php echo $error_occured;?></span>
    <div>
        <label for="contact_name">Name:<sup>*</sup><span class="error"><?php echo $field;?></span></label>
          <div>
            <input id="contact_name" name="contact_name" type="text" placeholder="Name" required />
          </div>
        </div> <!-- /name -->

   <div>
          <label for="phone">Phone:<sup class="required">*</sup><span class="error"><?php echo $field;?></span></label>
          <div>
            <input id="phone" name="phone" type="tel" placeholder="Phone" required />
          </div>
        </div> <!-- /phone -->
        
        <div>
          <label for="email">Email:<sup class="required">*</sup><span class="error"><?php echo $field;?></span></label>
          <div>
            <input id="email" name="email" type="email" placeholder="Email" required />
          </div>
        </div> <!-- /email -->
   
   </div><!--/name-phone-email-->
   

         
 <div id="comment-security-submit">
             
   <div>
          <label for="message">Message:<sup class="required">*</sup><span class="error"><?php echo $field;?></span></label>
          <div>
            <textarea id="message" name="message" placeholder="Message" required></textarea>
          </div>
        </div> <!-- /message -->
        
		<div>
          <label for="security">What is 7+7:<sup class="required">*</sup>
          <span class="error"><?php echo $field;?> <?php echo $security; ?></span></label>
          <div>
            <input id="security" name="security" type="tel" required />
          </div>
        </div> <!-- /security -->
          
          <input name="send_contact_form" type="submit" value="Submit">
  </div>
<!--        /comment-security-submit        -->
        
        
</form>
    

     

</section> 
<!--  /contact-form-holder -->


		
				<?php endwhile; ?>
	<?php endif; ?>
<?php } ?>
    
    
</article>


  <div class="clear-both"></div>
  



</div> <!-- content-wrapper end -->



<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
