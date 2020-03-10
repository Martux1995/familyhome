<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CarouselModel extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	public function getImageData () {
		$query = "
			SELECT id_image, image_url, image_title, image_subtitle, image_show
			FROM carrousel_images
			ORDER BY image_show ASC";

		return $this->db->query($query)->result();
	}
}