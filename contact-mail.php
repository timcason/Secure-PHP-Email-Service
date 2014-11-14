<?php 
/* 
* Title: Custom PHP Email Service 
* Author : Tim Cason - contact@timcasonjr.com
* 
* data[name, email@address.com, subject, message]
*/

/*--Settings--*/
$to = "contact@timcasonjr.com";  									// Who is the email going to

// Does data exist, if(TRUE) -> return sanitized data
$data['name'] = (!empty($_POST['name'] )) ? htmlspecialchars($_POST['name']) : false;
$data['email'] = (!empty($_POST['mail'] )) ? filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL) : false;
$data['subject'] = (!empty($_POST['subject'] )) ? htmlspecialchars($_POST['subject']) : false;
$data['message'] = (!empty($_POST['message'] )) ? htmlspecialchars($_POST['message']): false;

$time = date("F j, Y, g:i a"); 

	// Setup Email Structure
$headers  = "From: ". $data['email'] ."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "X-Priority: 1\r\n"; 

$subject = $data['subject'];

$message = '<html><body>';
$message .= '<h1>Question or Comments from Compendium</h1>';
$message .= '<h3> Topic : '.$subject.'</h3>';
$message .= '<p>From : '. $_POST['name'].'<br />';
$message .= 'Time : '. $time .'<br />';
$message .= 'Message :</p>';
$message .= '<p>'. $_POST['message'] .'<p>';
$message .= '</body></html>';

// Send email if it has a place to go
if($data['name']|| $data['email'] || $data['subject'] || $data['message']){
	$success = mail($to, $subject, $message, $headers);
	if($success){
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
}

?>