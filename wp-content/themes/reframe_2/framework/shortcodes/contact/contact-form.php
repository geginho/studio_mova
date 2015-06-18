<?php
/**
 * Scripts
 */
 
function shortcode_contact_form( $atts ) {
	
	global $add_the_contactform;
	$add_the_contactform = true;
	
	extract( shortcode_atts( array(
	  'myemail' => '',
	  'title' => __( 'Contact Form', 'northeme' ),
	  'success' => __( "Thank you for your message.", 'northeme' ),
	  'failure' => __( 'Please try again.', 'northeme' ) 
	), $atts ) );
	
	// Unique ID
	$id = uniqid();
	
	// Start output
	ob_start();
	
	$token = wp_create_nonce("wp_token");
	?>
    	<form id="mform-<?php echo $id?>" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" class="contactform_ajax">
        	<input type="hidden" name="token" value="<?php echo $token ?>" />
        	  <h2><?php echo $title; ?></h2>
        	  <div id="resmsg-<?php echo $id?>" class="msg alert" style="display:none;"></div>
              <div class="forms">
              <label for="regularInput"><?php _e('EMAIL','northeme');?></label>
              <input type="text" name="email" class="email required" id="regularInput" />
            
              <label for="regularInput2"><?php _e('NAME','northeme');?></label>
              <input type="text" name="name" id="regularInput2" />
              
              <label for="regularTextarea"><?php _e('MESSAGE','northeme');?></label>
              <textarea id="regularTextarea" name="msg"></textarea>
              
              <br class="clear" />
               
              <button type="submit" id="msubmit-<?php echo $id?>"><?php _e('SEND MESSAGE','northeme');?></button>
        
              <input type="hidden" name="bname" value="<?php echo get_bloginfo('name');?>" />
              <input type="hidden" name="sendemail" value="<?php echo $myemail;?>" />
              <input type="hidden" name="action" value="sendform" />
          	  </div>
          </form>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/jquery.validate.js"></script>      
    <script type="text/javascript">
	$(function($){ 
		/// FORM FUNCTIONS ///
		
		// GET FORM BACK
		$('#mform-<?php echo $id?> a.closealert').live('click',function(e) { 
			$(this).parent().hide();
			$(this).parent().next().slideDown();
			e.preventDefault();
		});
		
		// FORM POST
		$('#mform-<?php echo $id?>').validate({
			rules: {
				email: {
					required: true,
					email: true
					},
				name: {
					required: true
					},
				msg: {
					required: true
					}
			},
			messages: {
				name: "<?php _e('Please enter your name','northeme');?>",
				msg: "<?php _e('Please enter your message','northeme');?>",
				email: "<?php _e('Please enter a valid email address','northeme');?>"
			},
			submitHandler: function(form) {
						$('#msubmit-<?php echo $id?>').html('Sending...');
						$.post('<?php echo get_template_directory_uri()?>/framework/shortcodes/contact/_actions.php',$(form).serialize(),function(data2) { 
							if(data2==1) { 
								$(form).find('div.forms').slideUp();
								$(form).find('div#resmsg-<?php echo $id?>').removeClass('alert-failed').addClass('alert-success').html('<?php echo esc_attr($success)?> &nbsp; <a href="#" class="closealert"><i class="icon-remove"></i></a>').show();
								$('#mform-<?php echo $id?> input[type=text], #mform-<?php echo $id?> textarea').val('');
							}else{
								$(form).find('div#resmsg-<?php echo $id?>').removeClass('alert-success').addClass('alert-failed').html('<?php echo esc_attr($success)?>').show();
							}
						})
			$('html,body').animate({scrollTop: $('#mform-<?php echo $id?>').offset().top},'slow');	
			$('#msubmit-<?php echo $id?>').html('<?php _e('Send Message','northeme');?>');	
			}
		});
	});	
	
	///////////////////
	
	
	</script>	
	<?php
	return ob_get_clean();
}
add_shortcode( 'md_contact_form', 'shortcode_contact_form' );