<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {

  public function getAllPromotions () {
    if ($this->accesscontrol->checkAuth()['correct']){
      $this->load->model("PromotionModel");
      $result = $this->PromotionModel->getAllPromotions();

      $retorno = array();
			foreach ($result as $row => $data) {
				$retorno[] = array(
          'id'=>$data->id_promotion,
          'title'=>$data->promotion_title,
          'description'=>$data->promotion_content,
          'regDate'=>$data->promotion_reg_day,
          'startDate'=>$data->promotion_start_day,
          'endDate'=>$data->promotion_end_day
        );
			}
      $this->response->sendJSONResponse($retorno);
		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}
  }

  public function getPromotionById ($id) {
    if ($this->accesscontrol->checkAuth()['correct']){
      $this->load->model("PromotionModel");
      $result = $this->PromotionModel->getPromotionById($id);

      $retorno = array(
        'id'=>$result->id_promotion,
        'title'=>$result->promotion_title,
        'description'=>$result->promotion_content,
        'regDate'=>$result->promotion_reg_day,
        'startDate'=>$result->promotion_start_day,
        'endDate'=>$result->promotion_end_day
      );
      $this->response->sendJSONResponse($retorno);
		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}
  }

  public function createPromotion () {
    if ($this->accesscontrol->checkAuth()['correct']){
      $title = $this->input->post('title');
      $description = $this->input->post('description');
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      $userPromotion = $_SESSION['id_user'];

			$ok = true; $err = array();

			if ($title == "")       { $ok = false; $err['title']  = "Ingrese un título."; }
			if ($description == "") { $ok = false; $err['description'] = "Ingrese la descripción."; }
      if ($start_date == "")  { $ok = false; $err['start_date'] = "Seleccione una fecha de inicio."; }
			if ($end_date == "")    { $ok = false; $err['end_date'] = "Seleccione una fecha de fin."; }

      $start_d = DateTime::createFromFormat("d/m/Y", $start_date);
      if ($start_d && $start_d->format("d/m/Y") !== $start_date){
        $this->respone->sendJSONResponse(array('msg' => "Ingrese las fechas en el formato correcto (DD-MM-YYYY)"),400);
        return;
      }

      $end_d = DateTime::createFromFormat("d/m/Y", $end_date);
      if ($end_d && $end_d->format("d/m/Y") !== $end_date){
        $this->respone->sendJSONResponse(array('msg' => "Ingrese las fechas en el formato correcto (DD-MM-YYYY)"),400);
        return;
      }

			if ($ok){
        $this->load->model("PromotionModel");
        $res = $this->PromotionModel->createPromotion($title,$description,$start_d,$end_d,$userPromotion);

        if ($res) {
          $this->response->sendJSONResponse(array('msg' => "Promoción creada exitosamente."));
        } else {
          $this->response->sendJSONResponse(array('msg' => "No se pudo crear la promoción. Error interno del servidor."),500);
        }
      } else {
        $this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario.",'err' => $err),400);
      }

		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}
  }

  public function modifyPromotion ($id) {
    if ($this->accesscontrol->checkAuth()['correct']){
      $title = $this->input->post('title');
      $description = $this->input->post('description');
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      $userPromotion = $_SESSION['id_user'];

			$ok = true; $err = array();

			if ($title == "")       $title = null;
			if ($description == "") $description = null;
      if ($start_date == "")  $start_date = null;
			if ($end_date == "")    $end_date = null;

      if ($start_date) {
        $start_d = DateTime::createFromFormat("d/m/Y", $start_date);
        if ($start_d && $start_d->format("d/m/Y") !== $start_date){
          $this->respone->sendJSONResponse(array('msg' => "Ingrese las fechas en el formato correcto (DD-MM-YYYY)"),400);
          return;
        }
      }      

      if ($end_date) {
        $end_d = DateTime::createFromFormat("d/m/Y", $end_date);
        if ($end_d && $end_d->format("d/m/Y") !== $end_date){
          $this->response->sendJSONResponse(array('msg' => "Ingrese las fechas en el formato correcto (DD-MM-YYYY)"),400);
          return;
        }
      }        

			if ($ok){
        $this->load->model("PromotionModel");
        $res = $this->PromotionModel->modifyPromotion(
          $id,$title,$description,($start_date ? $start_d->format("Y-m-d") : null),($end_date ? $end_d->format("Y-m-d") : null),$userPromotion);

        if ($res) {
          $this->response->sendJSONResponse(array('msg' => "Promoción creada exitosamente."));
        } else {
          $this->response->sendJSONResponse(array('msg' => "No se pudo crear la promoción. Error interno del servidor."),500);
        }
      } else {
        $this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario.",'err' => $err),400);
      }

		} else {
			$this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
		}
  }

  public function deletePromotion ($id){
    if ($this->accesscontrol->checkAuth()['correct']){
      $this->load->model('PromotionModel');
			if (!$this->PromotionModel->getPromotionById($id)){
				$this->response->sendJSONResponse(array('msg' => "La promoción a eliminar no existe."),400); return;
			}

			if ($this->PromotionModel->deletePromotion($id)){
				$this->response->sendJSONResponse(array('msg' => "Promoción eliminada."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo eliminar la promoción."),400);
			}
    } else {
      $this->response->sendJSONResponse(array('err' => 'Permisos insuficientes'),400);
    }
  }

}
?>