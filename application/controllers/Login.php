<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function loginUser() {
		if ($this->input->is_ajax_request()){
			$email = $this->input->post('txtEmail');
			$pass = $this->input->post('txtPassword');

			$err = array();
			if ($email == "")   $err['email'] = "Ingrese un correo electrónico.";
			if ($pass == "")    $err['pass'] = "Ingrese la contraseña.";

			if (count($err) != 0) {
				$this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario.",'err' => $err),400); 
				return;
			}

			$this->load->model('LoginModel');
			if ( $userData = $this->LoginModel->checkUser($email) ) {
				
				$res = password_verify($pass, $userData->pass_hash);

				if ($res){
					$_SESSION['id_user'] = $userData->id_user;
					$_SESSION['username'] = $userData->username;
					$_SESSION['email'] = $userData->email_access;
					$_SESSION['id_level_access'] = $userData->id_level_access;
					
					$this->response->sendJSONResponse(array('msg' => "Acceso correcto."));
				} else {
					$this->response->sendJSONResponse(array('msg' => "El correo o la clave es inválida. Reintente."),400);
				}
			} else {
				$this->response->sendJSONResponse(array('msg' => "El correo o la clave es inválida. Reintente."),400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => "No se pudo encontrar el recurso."),404);
		}
	}

	public function forgotPassword () {
		if ($this->input->is_ajax_request()){
			$email = $this->input->post('email');
			$token = $this->input->post('token');

			$err = array(); $ok = true;
			if ($email == "")  {$ok = false; $err['email'] = "Ingrese su correo electrónico."; }
			

			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array('secret' => $_SERVER["HTTP_GOOGLE_CAPTCHA_CODE"],'response' => $token);
			$options = array( 'http' => array ( 'method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n",'content' => http_build_query($data) ) );
			$context  = stream_context_create($options);
			$verify = file_get_contents($url, false, $context);
			$captcha_success = json_decode($verify);
			if (!$captcha_success->success && base_url() !== $_SERVER['HTTP_BASE_URL_LOCAL']) {
					$this->response->sendJSONResponse(array('msg'=>'Debes verificar tu identidad con el captcha.'),400);  return;
			} else if (!$ok) {
					$this->response->sendJSONResponse(array('msg'=>'Arregle los campos.','err' => $err),400);  return;
			}

			$this->load->model('UserModel');
			$res = $this->UserModel->getUserByEmail($email);

			if ($res){
				$new_pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
				$hash = password_hash($new_pass,PASSWORD_DEFAULT,['cost' => 13]);
				$this->UserModel->changeUserPassword($res->id_user,$hash);

				$data = array('nombre' => $res->username,'clave'=>$new_pass);
				$html = $this->load->view('mails/recoverPasswordMail',$data,true);
				$this->load->library("Emailsender");
	
				if ($this->emailsender->sendmail($email,"Recuperación de contraseña",$html)){
						$this->response->sendJSONResponse(array('msg' => "Correo enviado exitosamente."));
				} else {
						$this->response->sendJSONResponse(array('msg' => "Hubo un error al enviar el correo, reintente más tarde."),400);
				}

			} else {
				$this->response->sendJSONResponse(array('msg'=>'El usuario no se encuentra registrado en el sistema.'),400);  return;
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => "No se pudo encontrar el recurso."),404);
		}
	}

	public function logoutUser () {
		session_destroy();
		$this->response->sendJSONResponse(array('msg' => "Se ha cerrado la sesión."));
	}
}
?>