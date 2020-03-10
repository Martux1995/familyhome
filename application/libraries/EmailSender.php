<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class EmailSender {

    private $CI;

    private $emailFrom = 'no-reply@familyhome.cl';
    private $emailName = 'Hostal Family Home';

    private $email_config = array(
        'protocol'  => 'smtp',
        'smtp_host' => $_SERVER['HTTP_SMTP_SERVER'],
        'smtp_user' => $_SERVER['HTTP_SMTP_USER'],
        'smtp_pass' => $_SERVER['HTTP_SMTP_PASSWORD'],
        'smtp_port' => '26',
        'mailtype'  => 'html'
    );

	public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->library('email');
        $this->CI->email->initialize($this->email_config);
	}
    
    public function sendmail ($email_to, $title, $body) {
        $this->CI->email->from($this->emailFrom, $this->emailName);
        $this->CI->email->to($email_to);

        $this->CI->email->subject($title);
        $this->CI->email->message($body);

        return $this->CI->email->send();
    }

}
?>