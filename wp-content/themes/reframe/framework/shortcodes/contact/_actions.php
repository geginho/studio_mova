<?php 

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );


if($_POST['action']=='sendform') {
	
	if ( !wp_verify_nonce( @$_POST['token'], "wp_token" ) ) {
		echo 0;
		exit;
	}  
			
	$bname=$_POST['bname'];
	$sendemail=$_POST['sendemail'];
	$email=$_POST['email'];
	$name=$_POST['name'];
	$msg=$_POST['msg'];


	$headers = "From: $name <$email>";
	$headers .= "\nReply-To: ".$email;
	$headers .= "\nMIME-Version: 1.0";
	$headers .= "\nContent-Type: text/plain; charset=UTF-8";
	$headers .= "\nX-Priority: 3";
	$headers .= "\nX-MSMail-Priority: Normal";

	$subject = "New message has been sent via contact form";
	
	$body = "Message details : \r\n
	Email : ".($email)." \r\n
	Name : ".($name)." \r\n
	Message : ".$msg;
	
	
	if(wp_mail($sendemail,$subject,$body,$headers)) 
	echo 1;
}
?>