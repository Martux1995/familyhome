<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PromotionModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    
  public function getAllPromotions () {
    $query = "
      SELECT 
        id_promotion, 
        promotion_title, 
        promotion_content, 
        DATE_FORMAT(promotion_reg_day,'%d/%m/%Y') AS promotion_reg_day, 
        DATE_FORMAT(promotion_start_day,'%d/%m/%Y') AS promotion_start_day, 
        DATE_FORMAT(promotion_end_day,'%d/%m/%Y') AS promotion_end_day, 
        promotion_created_by 
      FROM promotion";

    return $this->db->query($query)->result();
  }

  public function getActualPromotions () {
    $query = "
      SELECT 
        id_promotion, 
        promotion_title, 
        promotion_content, 
        DATE_FORMAT(promotion_reg_day,'%d/%m/%Y') AS promotion_reg_day, 
        DATE_FORMAT(promotion_start_day,'%d/%m/%Y') AS promotion_start_day, 
        DATE_FORMAT(promotion_end_day,'%d/%m/%Y') AS promotion_end_day, 
        promotion_created_by 
      FROM promotion
      WHERE promotion_start_day <= NOW() AND promotion_end_day >= NOW()
      ORDER BY promotion_start_day, promotion_end_day";

    return $this->db->query($query)->result();
  }

  public function getPromotionById ($id) {
    $query = "
      SELECT id_promotion, promotion_title, promotion_content, promotion_reg_day, promotion_start_day, promotion_end_day, promotion_created_by 
      FROM promotion WHERE id_promotion = ?";

      return $this->db->query($query,array($id))->row();
  }

  public function createPromotion ($title,$description,$start_date,$end_date,$userPromotion) {
    $query = "INSERT INTO promotion (promotion_title,promotion_content,promotion_reg_day,
                promotion_start_day,promotion_end_day,promotion_created_by) 
              VALUES (?,?,NOW(),?,?,?)";
    return $this->db->query($query,array($title,$description,$start_date->format("Y-m-d"),$end_date->format("Y-m-d"),$userPromotion));
  }

  public function modifyPromotion ($id,$title,$description,$start_date,$end_date) {
    $modifyData = array(); $modifyColumn = array();
    if ($title != null) { array_push($modifyColumn,"promotion_title"); array_push($modifyData,$title);}
    if ($description != null) { array_push($modifyColumn,"promotion_content"); array_push($modifyData,$description); }
    if ($start_date != null) { array_push($modifyColumn,"promotion_start_day"); array_push($modifyData,$start_date); }
    if ($end_date != null) { array_push($modifyColumn,"promotion_end_day"); array_push($modifyData,$end_date); }
    
    if (count($modifyData) == 0) return false;

    $qdata = ''; $d = 0;
    while ($d < count($modifyData)){
      if ($d == 0) $qdata .= "promotion_reg_day = NOW(), $modifyColumn[$d] = ?"; 
      else $qdata .= ", $modifyColumn[$d] = ?"; 
      $d += 1;
    }

    $query = "UPDATE promotion SET $qdata WHERE id_promotion = ?";
    array_push($modifyData,$id);
    return $this->db->query($query,$modifyData);
  }

  public function deletePromotion ($id) {
    $query = "DELETE FROM promotion WHERE id_promotion = ?";
    return $this->db->query($query,array($id));
  }

}
?>