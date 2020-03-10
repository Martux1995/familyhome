<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function getContactInformation () {
        if ($this->accesscontrol->checkAuth()['correct']){

            $this->load->model("ConfigurationModel");
            $result = $this->ConfigurationModel->getConfData();

            $retorno = array(
                'phoneContact1'     => $result->phone_contact_1,
                'phoneContact2'     => $result->phone_contact_2,
                'emailContact'      => $result->email_contact,
                'enableContactForm' => $result->contact_form_enable,
                'emailContactForm'  => $result->email_form_destination
            );
            
            $this->response->sendJSONResponse($retorno);
        } else {
            $this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
        }
    }

    public function updateContactInfo () {
        if ($this->accesscontrol->checkAuth()['correct']){

            $tel1 = $this->input->post("phoneContact1");
            $tel2 = $this->input->post("phoneContact2");
            $email = $this->input->post("emailContact");

            $err = array();

            if (isset($tel1)) {
                if ( strlen($tel1) > 20 )    $err['phoneContact1'] = "El número de teléfono no puede tener más de 20 caracteres";
                else if (strlen($tel1) == 0) $tel1 = NULL;
            }
            if (isset($tel2)) {
                if ( strlen($tel2) > 20 )    $err['phoneContact2'] = "El número de teléfono no puede tener más de 20 caracteres";
                else if (strlen($tel2) == 0) $tel2 = NULL;
            }
            if (isset($email)) {
                if ( strlen($email) > 60 )    $err['emailContact'] = "El correo electrónico no puede tener más de 60 caracteres";
                else if (strlen($email) == 0) $email = NULL;
            } 

            if (count($err) > 0) {
                $this->response->sendJSONResponse(array('msg' => "Corrija los campos.", 'err' => $err),400); return;
            }

            $data = array (
                "phoneContact1"  => $tel1,
                "phoneContact2"  => $tel2,
                "emailContact"   => $email
            );

            $this->load->model("ConfigurationModel");
            $result = $this->ConfigurationModel->updateContactInfo($data);
            
            if ($result) {
                $this->response->sendJSONResponse(array('msg' => "La información de contacto ha sido actualizada exitosamente"));
            } else {
                $this->response->sendJSONResponse(array('msg' => "Error interno del servidor"),500);
            }
        } else {
            $this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
        }
    }

    public function updateContactForm () {
        if ($this->accesscontrol->checkAuth()['correct']){

            $enabled = $this->input->post('enableContactForm');
            $email = $this->input->post('emailContactForm');

            $err = array();
            
            if (!isset($enabled)) $err['enableContactForm'] = 'Debe indicar si se habilita o no el formulario';
            if (isset($email)) {
                if ( strlen($email) > 60 )    $err['emailContactForm'] = "El correo electrónico no puede tener más de 60 caracteres";
                else if (strlen($email) == 0) $err['emailContactForm'] = "Debe ingresar un correo electrónico para recibir los mensajes";
            } else {
                $err['emailContactForm'] = "Debe indicar un correo electrónico para recibir los mensajes";
            }

            if (count($err) > 0) {
                $this->response->sendJSONResponse(array('msg' => "Corrija los campos.", 'err' => $err),400); return;
            }
            
            $value = 0;
            if ($enabled == "true") $value = 1;

            $data = array (
                "contactFormEnable"  => $value,
                "emailFormDestination"  => $email
            );

            $this->load->model("ConfigurationModel");
            $result = $this->ConfigurationModel->updateContactForm($data);
            
            if ($result) {
                $this->response->sendJSONResponse(array('msg' => "El formulario de contacto ha sido actualizado exitosamente"));
            } else {
                $this->response->sendJSONResponse(array('msg' => "Error interno del servidor"),500);
            }
        } else {
            $this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
        }
    }

}
?>