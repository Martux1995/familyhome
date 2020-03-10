<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

public function printPortfolio ($imgUrl) {
    $data = `<div class="col-md-4 col-sm-6 portfolio-item">
                <a class="portfolio-link" data-toggle="modal" href="#portfolioModal1">
                <div class="portfolio-hover">
                    <div class="portfolio-hover-content">
                        <i class="fas fa-plus fa-3x"></i>
                    </div>
                </div>
                <img class="img-fluid" src="<?php echo base_url();?>assets/img/portfolio/01-thumbnail.jpg" alt="">
                </a>
                <div class="portfolio-caption">
                <h4>Threads</h4>
                <p class="text-muted">Illustration</p>
                </div>
            </div>`;
}

?>