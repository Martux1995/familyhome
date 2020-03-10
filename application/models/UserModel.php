<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    
    public function getAllUsers () {
        $query = "SELECT user.id_user, user.username, user.email_access, level_access.level_access_name
                  FROM user INNER JOIN level_access ON user.id_level_access = level_access.id_level_access";
        return $this->db->query($query)->result();
    }

    public function getUserById ($id) {
        $query = "SELECT user.id_user, user.username, user.email_access, user.id_level_access, level_access.level_access_name
                  FROM user INNER JOIN level_access ON user.id_level_access = level_access.id_level_access
                  WHERE user.id_user = ?";
        return $this->db->query($query,$id)->row();
    }

    public function getUserByEmail ($email) {
        $query = "SELECT user.id_user, user.username, user.email_access, user.id_level_access, level_access.level_access_name
                  FROM user INNER JOIN level_access ON user.id_level_access = level_access.id_level_access
                  WHERE user.email_access = ?";
        return $this->db->query($query,$email)->row();
    }

    public function getAllLevelAccess () {
        $query = "SELECT id_level_access, level_access_name FROM level_access";
        return $this->db->query($query)->result();
    }

    public function getLevelAccessById ($id) {
        $query = "SELECT id_level_access, level_access_name FROM level_access WHERE id_level_access = ?";
        return $this->db->query($query,$id)->row();
    }

    public function createUser ($name, $email, $level, $hash) {
        $check1 = $this->db->query("SELECT * FROM level_access WHERE id_level_access = ?", $level)->num_rows();

        if ($check1 >= 1){
            $query = "INSERT INTO user (username, email_access, pass_hash, id_level_access) VALUES (?, ?, ?, ?)";
            return $this->db->query($query, array($name, $email, $hash, $level));
        } else {
            return false;
        }
    }

    public function modifyUser ($id, $name, $level, $email = null) {
        $check1 = $this->db->query("SELECT * FROM level_access WHERE id_level_access = ?", $level)->num_rows();

        if ($check1 >= 1){
            if ($email){
                $query = "UPDATE user SET username = ?, id_level_access = ?, email_access = ? WHERE id_user = ?";
                return $this->db->query($query, array($name, $level, $email, $id));
            } else {
                $query = "UPDATE user SET username = ?, id_level_access = ? WHERE id_user = ?";
                return $this->db->query($query, array($name, $level, $id));
            }
        } else {
            return false;
        }
    }

    public function deleteUser ($id) {
        $query = "DELETE FROM user WHERE id_user = ?";
        return $this->db->query($query, array($id));
    }

    public function changeUserPassword ($id, $hash) {
        $query = "UPDATE user SET pass_hash = ? WHERE id_user = ?";
        return $this->db->query($query, array($hash, $id));
    }

}