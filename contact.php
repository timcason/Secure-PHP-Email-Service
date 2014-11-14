<?php
/* 
* Title: Custom PHP Email Service 
* Author : Tim Cason - contact@timcasonjr.com
* 
* data[name, email@address.com, subject, message]
*/

/*--Settings--*/
$toEmail = "contact@timcasonjr.com";  									// Who is the email going to
$toName = "Tim Cason";  												// Who is the email going to

require_once('../class.phpmailer.php');

// Does data exist, if(TRUE) -> return sanitized data
$data['name'] = (!empty($_POST['name'] )) ? htmlspecialchars($_POST['name']) : false;
$data['email'] = (!empty($_POST['mail'] )) ? filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL) : false;
$data['subject'] = (!empty($_POST['subject'] )) ? htmlspecialchars($_POST['subject']) : false;
$data['message'] = (!empty($_POST['message'] )) ? htmlspecialchars($_POST['message']): false;

$time = date("F j, Y, g:i a"); 

$mail = new PHPMailer();

$message = '<html><body>';
$message .= '<h1>Question or Comments/h1>';
$message .= '<h3> Topic : '.$subject.'</h3>';
$message .= '<p>From : '. $_POST['name'].'<br />';
$message .= 'Time : '. $time .'<br />';
$message .= 'Message :</p>';
$message .= '<p>'. $_POST['message'] .'<p>';
$message .= '</body></html>';

$mail->IsSMTP(); 															// telling the class to use SMTP
$mail->SMTPDebug  = 2;                     									// enables SMTP debug information (for testing)
                                           									// 1 = errors and messages
                                           									// 2 = messages only
$mail->SMTPAuth   = true;                  									// enable SMTP authentication
$mail->SMTPSecure = "tls";              									// sets the prefix to the servier
$mail->Host       = "email-smtp.host.com"; 									// sets the SMTP server
$mail->Port       = 25; //465,587                  				 	 		// set the SMTP port for the GMAIL server
$mail->Username   = "user@yourdomain"; 										// SMTP account username
$mail->Password   = "password";        										// SMTP account password

// Who is getting the mail?
$address = $toEmail
$mail->AddAddress($address, $toName);

// Email Structure
$mail->SetFrom( $data['email'],  $data['name']);
$mail->AddReplyTo( $data['email'], $data['name']);
$mail->Subject    = $data['subject'];
$mail->MsgHTML($message);


// Send email if it has a place to go
if($data['name']|| $data['email'] || $data['subject'] || $data['message']){
	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}

?>