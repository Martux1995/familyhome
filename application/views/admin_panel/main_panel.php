<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Family Home - Panel de administración</title>

  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-notify/css/bootstrap-notify.css" rel="stylesheet" type="text/css"/>  
  <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css"/>
  <link href="<?php echo base_url(); ?>assets/css/panel.css" rel="stylesheet">
  <style>
    .chargePage {
      display:none;position:fixed;z-index:10000;top:0;left:0;height:100%;width:100%;
      background: rgba(255,255,255,.8) url('<?php echo base_url();?>assets/img/loading.svg') 50% 50% no-repeat
    }
    body.loading .chargePage {overflow:hidden;display:block}
    .hideBar {display:none}
  </style>
  <script>const host_url = "<?php echo base_url(); ?>";</script>
</head>
<body class="loading">
  <!-- CHARGE SPINNER -->
  <div class="chargePage"></div>

  <!-- LOGOUT MODAL -->
  <div id="logoutModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cerrar sesión</h5>
        </div>
        <div class="modal-body">
          ¿Está seguro que desea cerrar la sesión?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="logoutButton">Si</button>
        </div>
      </div>
    </div>
  </div>

  <!-- RELOGIN MODAL -->
  <div id="reloginModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Sesión expirada</h5></div>
        <div class="modal-body">
          Debido al largo periodo de inactividad, la sesión se ha cerrado automáticamente.
          En breves segundos será redirigido al panel de inicio de sesión para volver a ingresar.
        </div>
      </div>
    </div>
  </div>

  <!-- SIDEBAR -->
  <div id="wrapper" class="open">
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-title">FAMILY HOME</li>
        <li class="sidebar-username">Bienvenido(a) <strong><?php echo $_SESSION['username'];?></strong></li>
        <hr>
        <li><a href="#" class="menuItem" id="inicio">Inicio</a></li>
        <li><a href="#" class="menuItem" id="miPerfil">Mi Perfil</a></li>
        <li><a href="#" class="menuItem" id="promociones">Promociones</a></li>
<?php if($_SESSION['id_level_access'] == 1): ?>
        <li><a href="#" class="menuItem" id="usuarios">Usuarios</a></li>
        <li><a href="#" class="menuItem" id="configuraciones">Configuraciones</a></li>
<?php endif;?>
        <hr>
        <li><a href="#" data-toggle="modal" data-target="#logoutModal">Cerrar sesión</a></li>
      </ul>
    </div>

    <!-- PAGE CONTENT -->
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div id="topBar" class="hideBar row d-block mb-4">
          <div class="card w-100 rounded-0 shadow-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i class="fas fa-bars"></i></a>
                </div>
                <div class="col" style="font-size: 24px;" id="ResponsiveTitle"></div>
              </div>
            </div>
          </div>
        </div>

        <div id="NormalTitle"><h2 id="PageTitle"></h2><hr></div>
        <div class="panel-principal"></div>

      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-notify/js/bootstrap-notify.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/panel.js"></script>

</body>
</html>