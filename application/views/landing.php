<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--meta name="format-detection" content="telephone=no"-->

  <title>Family Home - La Serena, Chile</title>

  <link href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <link href="<?= base_url(); ?>assets/css/agency.min.css" rel="stylesheet">

  <script>const host_url = "<?= base_url(); ?>";</script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Family Home</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menú
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#servicios">Servicios</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#promociones">Promociones</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#portfolio">Galería</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#ubicacion">Ubicación</a></li>
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <div class="intro-lead-in">Hostal Family Home - La Serena</div>
        <div class="intro-heading text-uppercase">Siéntase como en casa</div>
        <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#servicios">Conoce nuestro hostal</a>
      </div>
    </div>
  </header>

  <!-- Servicios -->
  <section id="servicios">
    <div class="container">

      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Servicios</h2>
          <h3 class="section-subheading text-muted">Conoce lo que podemos ofrecerte.</h3>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-bed fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Alojamiento</h4>
          <p class="text-muted">Tenemos habitaciones con capacidad de 1 a 4 personas, con baño compartido o privado.</p>
        </div>
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-coffee fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Alimentación</h4>
          <p class="text-muted">Si lo necesita, ofrecemos desayuno, almuerzo y cena con un coste adicional</p>
        </div>
        <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-building fa-stack-1x fa-inverse"></i>
          </span>
          <h4 class="service-heading">Convenios con empresas</h4>
          <p class="text-muted">Si tiene una actividad como empresa en la región y necesita alojamiento, podemos ofrecerles servicios especiales. Comuníquese con nosotros para más detalles.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- Promociones -->
  <section id="promociones" class="bg-light" >
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Promociones</h2>
          <h3 class="section-subheading text-muted">Revisa las ofertas que tenemos para tí.</h3>
        </div>
      </div>

      <?php if(count($promotionsData) !== 0): ?>
      <div class="row text-center">
        <?php for($d = 0; $d < count($promotionsData) && $d < 3; $d++): ?>
        <div class="col-md-4 mx-auto">
          <div class="card team-member">
            <div class="card-body">
              <h5 class="card-title"><?= $promotionsData[$d]->promotion_title; ?></h5>
              <h6 class="card-subtitle mb-2 text-muted">Duración: <?= $promotionsData[$d]->promotion_start_day.' a '.$promotionsData[$d]->promotion_end_day; ?></h6>
              <p class="card-text"><?= $promotionsData[$d]->promotion_content; ?></p>
            </div>
          </div>
        </div>
        <?php endfor;?>
      </div>

      <div class="row text-center">
        <div class="col-sm-12">
          <button type="button" class="btn btn-primary btn-lg text-uppercase" data-toggle="modal" data-target="#promotionsDialog">Ver más</button>
        </div>
      </div>
    <?php else: ?>
    <div class="row text-center">
      <div class="col-sm-8 mx-auto text-center">
        <p class="text-muted">Actualmente no hay promociones. Visita pronto para más detalles.</p>
      </div>
    </div>
    <?php endif;?>
    
    </div>
  </section>

  <!-- Portfolio Grid -->
  <section id="portfolio">
    <div class="container">

      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Galería de imágenes</h2>
          <h3 class="section-subheading text-muted">Observa como se ve nuestro hostal.</h3>
        </div>
      </div>
      
      <div class="row d-block">
        <div class="col-xs-12 text-center">

        
          <?php if(count($carouselData) !== 0): ?>
          <div id="gallery" class="carousel slide" data-ride="false" data-interval="false" style="background: gray">
            
            <div class="carousel-inner">

              <?php foreach ($carouselData as $key => $value): ?>
              <div class="carousel-item <?= ($key==0 ? "active" : "") ?>" >
                <img class="carousel-image" src="<?= base_url();?>assets/img/carousel/<?= $value->image_url; ?>" alt="...">
              </div>
              <?php endforeach; ?>

            </div>

            <a class="carousel-control-prev carousel-custom-control" href="#gallery" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next carousel-custom-control" href="#gallery" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Siguiente</span>
            </a>
          </div>
          <?php else: ?>
          <div class="row text-center">
            <div class="col-sm-8 mx-auto text-center">
              <p class="text-muted">No hay imágenes disponibles para ver.</p>
            </div>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </section>

  <!-- Ubicación -->
  <section id="ubicacion" class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Ubicación</h2>
          <h3 class="section-subheading text-muted">Descubre la forma para llegar a nuestro hostal.</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div class="embed-responsive embed-responsive-16by9 border border-dark">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6916.903084022568!2d-71.25133982487156!3d-29.908900184852143!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x2f7f25316d93c071!2sHostal+Family+Home!5e0!3m2!1ses-419!2scl!4v1549754407309" class="embed-responsive-item" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-lg-4 mx-auto text-justify">
          <p class="text-muted pt-2 pt-lg-0">
            Nos encontramos ubicados en Avenida El Santo #1056, La Serena, al frente del Tribunal Oral y a 
            pocos pasos del terminal de buses. 
          </p>
          <p class="text-muted">
            Cerca del hostal se encuentra el Mall Plaza La Serena y el centro de la ciudad.
            Además, hay locomoción a cada momento del día. A una mayor distancia se encuentra el parque japonés de La Serena,
            diversos museos históricos y la Avenida del Mar. Si necesita información, podemos orientarle sobre las atracciones de la región.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Contáctanos</h2>
          <h3 class="section-subheading text-white">
            Para mas información, puedes comunicarte con nosotros mediante los siguientes medios:
          </h3>
        </div>
      </div>

      <div class="row justify-content-md-center">

        <?php if (isset($contactData->phone_contact_1)):?>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                  <p class="card-text font-weight-bold text-center telephone-number">
                    <i class="fas fa-phone"></i> <?= $contactData->phone_contact_1 ?>
                  </p>
                </div>
            </div>
        </div>
        <?php endif;?>

        <?php if (isset($contactData->phone_contact_2)):?>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <p class="card-text font-weight-bold text-center telephone-number">
                      <i class="fas fa-phone"></i> <?= $contactData->phone_contact_2 ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endif;?>

        <?php if (isset($contactData->email_contact)):?>
        <div class="col-lg-6 col-md-12">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <p class="card-text font-weight-bold text-center"><i class="far fa-envelope"></i> <?= $contactData->email_contact ?></p>
                </div>
            </div>
        </div>
        <?php endif;?>

      </div>

      <?php if(isset($contactData->contact_form_enable) && $contactData->contact_form_enable): ?>
      <div class="row">
      <div class="col-lg-12 text-center">
          <h3 class="section-subheading text-white">
            Puedes contactarte con nosotros mediante este formulario. Te contestaremos lo más rápido posible.
          </h3>
        </div>
        <div class="col-lg-12">
          <form id="contactForm" name="sentMessage" novalidate="novalidate">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" id="name" type="text" placeholder="Nombre (*)" required="required" data-validation-required-message="Ingresa tu nombre.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="email" type="email" placeholder="Correo electrónico (*)" required="required" data-validation-required-message="Ingresa tu correo electrónico.">
                  <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                  <input class="form-control" id="phone" type="tel" placeholder="Teléfono (*)" required="required" data-validation-required-message="Ingresa tu teléfono de contacto.">
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <textarea class="form-control" id="message" placeholder="Mensaje (*)" required="required" data-validation-required-message="Ingresa lo que necesitas conocer de nosotros."></textarea>
                  <p class="help-block text-danger"></p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-6">
                <div class="g-recaptcha" data-sitekey="<?= $_SERVER['HTTP_GOOGLE_CAPTCHA_SITEKEY'] ?>"></div>
              </div>
              <div class="col-md-6 text-center pt-2 pt-md-0">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar mensaje</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php endif;?>

    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <span class="copyright">Copyright &copy; Family Home 2018</span>
        </div>
      </div>
    </div>
  </footer>

  <?php if(count($promotionsData) !== 0):?>
  <div class="modal fade" id="promotionsDialog" tabindex="-1" role="dialog"aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Promociones Actuales</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php foreach($promotionsData as $key => $data){ ?>
          <div class="card my-2">
            <div class="card-body">
              <h5 class="card-title"><?= $data->promotion_title;?></h5>
              <h6 class="card-subtitle mb-2 text-muted">Duración: <?= $data->promotion_start_day.' - '.$data->promotion_end_day; ?></h6>
              <p class="card-text"><?= $data->promotion_content; ?></p>
            </div>
          </div>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>  
  <?php endif; ?>

  <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/agency.js"></script>

</body>

</html>
