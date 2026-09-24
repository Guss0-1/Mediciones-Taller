<?php 
class EmailManager
{
	protected $mail = null;
	
	public function set_message($p_message){
		$this->mail->Body = '<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>' . $p_message . '</html>';
	}
	
	public function set_subject($p_subject){
		$this->mail->Subject = $p_subject;
	}
	
	public function add_address($p_email){
		$this->mail->AddAddress($p_email);
	}
	
	public function clear_addresses(){
		$this->mail->ClearAddresses();
	}
	
	public function __construct(){
		$this->mail = new PHPMailer();
		$this->mail->IsSMTP();
		$this->mail->Host = CONF_SMTP_HOST;
		$this->mail->SMTPAuth = CONF_SMTP_AUTH;
		$this->mail->Port = CONF_SMTP_PORT;
		if(CONF_SMTP_AUTH == true):
			$this->mail->Username = CONF_SMTP_USER;
			$this->mail->Password = CONF_SMTP_PASS;
		endif;
		$this->mail->From = CONF_SMTP_SENDER;
		$this->mail->FromName = CONF_SMTP_SENDER_NAME;
		$this->mail->Sender = CONF_SMTP_SENDER;
		$this->mail->IsHTML(true);
		$this->mail->Mailer = 'smtp';
		$this->mail->Timeout = 60;
		$this->mail->Charset = 'UTF-8';
		$this->mail->SMTPSecure = CONF_SMTP_SECURE; // tls
		$this->mail->IsHTML(true);
	}
	
	public function sendMail()
	{
		$this->mail->Send();
		if ($this->mail->error != "") {
			return false;
		} else {
			return true;
		}
	}
	/*
	if (is_uploaded_file($_FILES['curriculum']['tmp_name'])) {
		if (!preg_match('/(application\/msword|application\/pdf)/', $_FILES['curriculum']['type'])) {
			die('No se pudo enviar el mensaje.<br />Su curriculum debe estar en formato pdf o word.');
		}
		$mail->AddAttachment($_FILES['curriculum']['tmp_name'], $_FILES['curriculum']['name']);
	}
	*/
			
}
?>