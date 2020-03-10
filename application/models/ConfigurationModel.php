<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigurationModel extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	public function getConfData () {
		$query = "
            SELECT phone_contact_1, phone_contact_2, email_contact, contact_form_enable, email_form_destination 
            FROM site_configuration
        ";

		return $this->db->query($query)->row();
    }
    
    public function updateContactInfo ($data) {
        $query = "UPDATE site_configuration SET phone_contact_1 = ?, phone_contact_2 = ?, email_contact = ?";

        return $this->db->query($query,array($data['phoneContact1'],$data['phoneContact2'],$data['emailContact']));
    }

    public function updateContactForm ($data) {
        $query = "UPDATE site_configuration SET contact_form_enable = ?, email_form_destination = ?";

        return $this->db->query($query,array($data['contactFormEnable'],$data['emailFormDestination']));
    }   

}