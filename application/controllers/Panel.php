<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

    public function index () {
        redirect(base_url() . 'panel', 'refresh');
    }

    public function getIndexPage () {
        $status = $this->accesscontrol->checkAuth(true);
        if ($status['correct']) {
            $this->load->view("admin_panel/index_page");
        } else {
            if ($status['err'] == 'AJAX_REQUEST')
                redirect(base_url() . 'panel', 'refresh');
            else 
                $this->response->sendJSONResponse(array('logged' => false, 'msg' => 'Primero debe iniciar sesión.'),403);                
        }
    }

    public function getProfilePage () {
        $status = $this->accesscontrol->checkAuth(true);
        if ($status['correct']) {
            $this->load->view("admin_panel/profile_page");
        } else {
            if ($status['err'] == 'AJAX_REQUEST')
                redirect(base_url() . 'panel', 'refresh');
            else 
                $this->response->sendJSONResponse(array('logged' => false, 'msg' => 'Primero debe iniciar sesión.'),403);                
        }
    }

    public function getPromotionsPage () {
        $status = $this->accesscontrol->checkAuth(true);
        if ($status['correct']) {
            $this->load->view("admin_panel/promotions_page");
        } else {
            if ($status['err'] == 'AJAX_REQUEST')
                redirect(base_url() . 'panel', 'refresh');
            else 
                $this->response->sendJSONResponse(array('logged' => false, 'msg' => 'Primero debe iniciar sesión.'),403);  
        }
    }

    public function getUserAdminPage () {
        $status = $this->accesscontrol->checkAuth(true);
        if ($status['correct']) {
            $this->load->view("admin_panel/user_admin_page");
        } else {
            if ($status['err'] == 'AJAX_REQUEST')
                redirect(base_url() . 'panel', 'refresh');
            else 
                $this->response->sendJSONResponse(array('logged' => false, 'msg' => 'Primero debe iniciar sesión.'),403);  
        }
    }

    public function getSettingsPage () {
        $status = $this->accesscontrol->checkAuth(true);
        if ($status['correct']) {
            $this->load->view("admin_panel/settings_page");
        } else {
            if ($status['err'] == 'AJAX_REQUEST')
                redirect(base_url() . 'panel', 'refresh');
            else 
                $this->response->sendJSONResponse(array('logged' => false, 'msg' => 'Primero debe iniciar sesión.'),403);  
        }
    }
}