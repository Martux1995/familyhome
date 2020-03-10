<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
	public function __construct(){
		parent::__construct();
    }
    
    public function checkUser ($email) {
        $query = "SELECT u.id_user, u.username, u.email_access, u.pass_hash, la.id_level_access 
                  FROM user u INNER JOIN level_access la ON la.id_level_access = u.id_level_access
                  WHERE u.email_access = ?";
        
        return $this->db->query($query, array($email))->row();
    }

    public function recoverPassword ($email, $hash) {
        $query = "UPDATE user SET recover_hash = ?, recover_day = NOW() WHERE email_access = ?";

        return $this->db->query($query, array($hash, $email))->row();
    }
}