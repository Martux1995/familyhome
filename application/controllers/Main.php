<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    /**
     * Muestra la pantalla de presentación 
     */
	public function index() {
        //$this->load->view('main_view');
        $this->load->model("PromotionModel");
        $this->load->model("CarouselModel");
        $this->load->model("ConfigurationModel");

        $this->load->view(
            'landing',
            array(
                "promotionsData" => $this->PromotionModel->getActualPromotions(),
                "carouselData" => $this->CarouselModel->getImageData(),
                "contactData" => $this->ConfigurationModel->getConfData()
            )
        );
    }

    /**
     * Si el usuario ya ha iniciado sesión (existe para el una variable de sesión),
     * entonces es redirigido al panel. En el caso contrario, se muestra el formulario
     * para iniciar sesión.
     */
    public function panel() {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('admin_panel/main_panel');
        } else {
            $this->load->view('admin_panel/login_page');
        }
    }

    /**
     * En el caso que una página solicitada del panel no exista, se  pregunta si es que
     * fue mediante una solicitud ajax, en ese caso se retorna un error 404. 
     * Sino, se retorna a la página de inicio de sesión.
     */
    public function panelPageNotFound () {
        if ($this->input->is_ajax_request())
            $this->response->sendJSONResponse(
                array('msg' => 'La solicitud no puede ser procesada por el servidor.'),
                404
            );
        else
            redirect(base_url() . 'panel', 'refresh');
    }

    /**
     * Se envía un error 404 con una descripción dentro de un JSON.
     */
    public function apiRequestNotFound () {
        $this->response->sendJSONResponse(
            array('msg' => 'La solicitud no puede ser procesada por el servidor.'),
            404
        );
    }
    
    /**
     * Si se recibió cualquier solicitud que no existe en el sitio, se redirecciona a la página
     * principal del sitio.
     */
    public function pageNotFound() {
        $this->response->sendJSONResponse(
            array('msg' => 'La solicitud no puede ser procesada por el servidor.'),
            404
        );
    }

    /**
     * Envia un mensaje por medio del formulario de la página inicial
     */
    public function sendMessage(){
        if ($this->input->is_ajax_request()){
            $name = $this->input->post('name');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $message = $this->input->post('message');

			$ok = true; $err = array();

			if ($name == "")  { $ok = false; $err['name']  = "Ingrese su nombre."; }
			if ($phone == "") { $ok = false; $err['phone'] = "Ingrese su teléfono de contacto."; }
			if ($email == "") { $ok = false; $err['email'] = "Ingrese su correo electrónico."; }
			if ($message == "") { $ok = false; $err['message'] = "Ingrese el mensaje a enviar."; }
 
            $token = $this->input->post('captchaToken');

            // CAPTCHA VERIFIER
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array('secret' => $_SERVER['HTTP_GOOGLE_CAPTCHA_CODE'],'response' => $token);
            $options = array( 'http' => array ( 'method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n",'content' => http_build_query($data) ) );
            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);
            if (!$captcha_success->success && base_url() !== $_SERVER['HTTP_BASE_URL_LOCAL']) {
                $this->response->sendJSONResponse(array('msg'=>'Debes verificar tu identidad con el captcha.'),400);  return;
            } else if (!$ok) {
                $this->response->sendJSONResponse(array('msg'=>'Arregle los campos.','err' => $err),400);  return;
            }

            $this->load->model("ConfigurationModel");
            
            $email_to = $this->ConfigurationModel->getConfData()->email_form_destination;

            $data = array('name' => $name,'phone' => $phone,'email' => $email,'message' => $message);
            $html = $this->load->view('mails/informationRequestMail',$data,true);

            $this->load->library("Emailsender");

            if ($this->emailsender->sendmail($email_to,"Contacto vía página web",$html)){
                $this->response->sendJSONResponse(array('msg' => "Correo enviado exitosamente."));
            } else {
                $this->response->sendJSONResponse(array('msg' => "Hubo un error al enviar el correo, reintente más tarde."),400);
            }
        } else {
            $this->response->sendJSONResponse(
                array('msg' => 'La solicitud no puede ser procesada por el servidor.'),
                404
            );
        }
    }

}
