<?php
require_once FILE_ACCESS_CORE_CODE.'/Objects/Mailer/PHPMailer/PHPMailer_v5.1/class.phpmailer.php';
require_once 'Project/Code/System/Settings/settings.php';

class email
{	
//-------------------------------------------------------------------------------------------------	
	
	public static function send_email($to_email = NULL, $to_name = NULL, $from_email = NULL, $from_name = NULL, $subject, $body)
	{
		/* PACH notes: indicate first parameter(to_email) and/or third parameter(from_email) to null if used for Contact_us and other
		 * mailing functions addressed to client/admin...
		 * 
		 * indicate to_email with new email if used for other addressees like newsletter, forgot password,
		 * successful transaction, etc. ('my.email@email.me')
		*/
		
		$mail    = new PHPMailer();
		
		$settings = new settings();
		$settings->select();
		
      	$mail->IsSMTP();
      	$mail->Host 			= $settings->getHost();   				
	  	$mail->SMTPAuth 		= $settings->getSmtpAuth();
	  	$mail->Port  			= $settings->getPort();
        $mail->Username 		= $settings->getUsername();
       	$mail->Password 		= $settings->getPassword();
       	
       	$mail->SetFrom($from_email,$from_name);
       	$mail->AddReplyTo($from_email,$from_name);
       	   	
		$mail->Subject = $subject;
		
		$mail->WordWrap = 80;
       	$mail->IsHTML(FALSE);
       	
       	$mail->Body		= $body;
		$mail->AltBody	= $body;
		
		//$mail->MsgHTML($body);
		
		//To field
		if($to_email !== NULL)
			$mail->AddAddress($to_email, $to_name);
		else
			$mail->AddAddress($settings->getToEmail(), $settings->getToName());
		
		if(!$mail->Send())
			return FALSE;
		
		else
			return TRUE;
	}
}
?>