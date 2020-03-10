<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function getAllUsers () {
		if ($this->accesscontrol->checkAuth()['correct']){
			
			$this->load->model("UserModel");
			$result = $this->UserModel->getAllUsers();
			
			$retorno = array();
			foreach ($result as $row => $data) {
				$retorno[] = array(
						'id'=>$data->id_user,'name'=>$data->username,'email'=>$data->email_access,'level'=>$data->level_access_name
					);
			}
			$this->response->sendJSONResponse($retorno);
		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}
	}

	public function getUser($id=null){
		if ($this->accesscontrol->checkAuth()['correct']){
			
			$id = $id ? $id : $_SESSION['id_user'];

			$this->load->model("UserModel");
			$data = $this->UserModel->getUserById($id);
			
			if ($data){
				
				$retorno = array('id'=>$id,'name'=>$data->username,'email'=>$data->email_access,
												 'level'=>array('id'=>$data->id_level_access,'name'=>$data->level_access_name));
				$this->response->sendJSONResponse($retorno);
			} else {
				$this->response->sendJSONResponse(array('err' => 'El usuario no existe'),404);
			}
		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}

	}

	public function getAllLevelAccess () {
		if ($this->accesscontrol->checkAuth()['correct']){
			
			$this->load->model("UserModel");
			$result = $this->UserModel->getAllLevelAccess();
			
			$retorno = array();
			foreach ($result as $row => $data) {
				$retorno[] = array ( 'id' => $data->id_level_access,	'name' => $data->level_access_name );
			}
			$this->response->sendJSONResponse($retorno);
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'),400);
		}
	}

	/* --------------------------------------------------------------------------- */

	public function createUser () {
		if ($this->accesscontrol->checkAuth()['correct']){
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$level = $this->input->post('level');

			$ok = true; $err = array();

			if ($name == "")  { $ok = false; $err['name']  = "Ingrese un nombre para el usuario."; }
			if ($email == "") { $ok = false; $err['email'] = "Ingrese un correo electrónico."; }
			if ($level == "") { $ok = false; $err['level'] = "Seleccione un nivel de acceso."; }

			if ($ok){
				$new_pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
				
				$hash = password_hash($new_pass,PASSWORD_DEFAULT,['cost' => 13]);
				
				$this->load->model('UserModel');
				$res = $this->UserModel->createUser($name, $email, $level, $hash);

				if ($res){
					$data = array(
						"email_access" => $email,
						"password"     => $new_pass,
						"level_access" => $this->UserModel->getLevelAccessById($level)->level_access_name
					);

					$html = $this->load->view('mails/newUserMail',$data,true);
					$this->load->library("Emailsender");

					if ($this->emailsender->sendmail($email,"Registro en Sistema Family Home",$html)){
						$this->response->sendJSONResponse(array('msg' => "Usuario creado.",'email_sended' => true));
					} else {
						$this->response->sendJSONResponse(array('msg' => "Usuario creado.",'email_sended' => false, "psw" => $new_pass));
					}
				} else {
					$this->response->sendJSONResponse(array('msg' => "No se pudo crear el usuario. Probablemente el correo ya ha sido usado."),400);
				}
			} else {
				$this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario",'err' => $err),400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'),400);
		}
	}

	public function modifyUser ($id=null) {
		if ($this->accesscontrol->checkAuth()['correct']){

			$ok = true; $err = array();

			$name = $this->input->post('name');
			if ($name == "")  { $ok = false; $err['name'] = "Ingrese un nombre" . ($id ? " para el usuario." : "."); }
			
			if ($id) {
				$level = $this->input->post('level');
				if ($level == "") { $ok = false; $err['level'] = "Seleccione un nivel de acceso."; }
			} else {
				$email = $this->input->post('email');
				if ($email == "") { $ok = false; $err['email'] = "Ingrese un correo de acceso."; }
			}
			
			$id = $id ? $id : $_SESSION['id_user'];
			
			if ($ok){
				$this->load->model('UserModel');
				$x = $this->UserModel->getUserById($id);
				if (!$x){
					$this->response->sendJSONResponse(array('msg' => "No existe el usuario."),400); return;
				}

				if (!isset($level)){ $level = $x->id_level_access; }

				if ($this->UserModel->modifyUser($id, $name, $level, $email)){
					$this->response->sendJSONResponse(array('msg' => "Usuario modificado."));
				} else {
					$this->response->sendJSONResponse(array('msg' => "No se pudo modificar el usuario"),400);
				}
				
			} else {
				$this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario",'err' => $err),400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'),400);
		}
	}

	public function deleteUser ($id) {
		if ($this->accesscontrol->checkAuth()['correct']){
			$this->load->model('UserModel');
			if (!$this->UserModel->getUserById($id)){
				$this->response->sendJSONResponse(array('msg' => "El usuario a eliminar no existe."),400); return;
			}

			if ($this->UserModel->deleteUser($id)){
				$this->response->sendJSONResponse(array('msg' => "Usuario eliminado."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo eliminar el usuario"),400);
			}

		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'),400);
		}
	} 

	public function changePassword () {
		if ($this->accesscontrol->checkAuth()['correct']){

			$old = $this->input->post('oldPass');
			$new = $this->input->post('newPass');
			$new2 = $this->input->post('confirmNewPass');

			$ok = true; $err = array();
			if ($old == '')             { $ok = false; $err['oldPass'] = "Ingrese la clave actual."; }
			if ($new == '')             { $ok = false; $err['newPass'] = "Ingrese la nueva clave."; }
			if ($new2 == '')            { $ok = false; $err['confirmNewPass'] = "Confirme reingresando la nueva clave."; }
			else if ($new2 != $new)     { $ok = false; $err['confirmNewPass'] = "Las claves no coinciden."; }
			else if (strlen($new) < 8)  { $ok = false; $err['confirmNewPass'] = "La nueva clave debe tener 8 carácteres como mínimo."; }

			if ($ok){
				$this->load->model('UserModel'); $this->load->model('LoginModel');
				$id = $_SESSION['id_user'];
				$x = $this->UserModel->getUserById($id);

				$userData = $this->LoginModel->checkUser($x->email_access);
				if (!password_verify($old, $userData->pass_hash)){
					$this->response->sendJSONResponse(array('msg' => "La clave antigua no coincide.","err"=>$err),400); return;
				}

				$hash = password_hash($new,PASSWORD_DEFAULT,['cost' => 13]);

				if ($this->UserModel->changeUserPassword($id,$hash)){
					$this->response->sendJSONResponse(array('msg' => "Cambio de clave exitoso."));
				} else {
					$this->response->sendJSONResponse(array('msg' => "No se pudo cambiar la clave."),400);
				}
				
			} else {
				$this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario",'err' => $err),400);
			}

		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'),400);
		}
	}
}