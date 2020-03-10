<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Family Home - Iniciar Sesión</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/vendor/bootstrap-notify/css/bootstrap-notify.css" rel="stylesheet" type="text/css"/>  

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<style type="text/css">
		body { 
			background: url("<?php echo base_url(); ?>assets/img/bg.jpg") no-repeat center center fixed;
			-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;
			background-size:cover;font-family:'Open Sans','Helvetica Neue',Arial,sans-serif
		}
		.chargePage {
			display:none;position:fixed;z-index:10000;top:0;left:0;height:100%;width:100%;
			background: rgba(255,255,255,.8) url('<?php echo base_url();?>assets/img/loading.svg') 50% 50% no-repeat
		}
		body.loading .chargePage {overflow:hidden;display:block}
		.box {margin-top:50px;padding:15px}
	</style>

</head>
<body>
	<div class="chargePage"></div>

	<div id="forgotPasswordModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h5 class="modal-title">¿Olvidaste tu contraseña?</h5>
				</div>

				<form id="forgotPasswordForm" action="" method="POST" class="form horizontal">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm">
								<p>Para recuperar el acceso a su cuenta, ingrese el correo electrónico asociado a esta y 
								   recibirá un mensaje con la nueva contraseña.</p>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12 control-label">
									Correo Electrónico: 
									<input type="email" class="form-control" name="txtEmailRecover" placeholder="nombre@example.com">
									<div class="invalid-feedback"></div>
								</div>
								<div class="col-sm-12 pt-4">
									<div class="g-recaptcha" data-sitekey="<?= $_SERVER['HTTP_GOOGLE_CAPTCHA_SITEKEY']?>"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Aceptar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 offset-sm-1 offset-md-2">
				<div class="card box">
					<h3 class="card-title text-center">Iniciar Sesión</h5>
					<form id="loginForm" action="#">
						<div class="form-group">
							<label for="txtEmail">Correo Electrónico</label>
							<input type="email" class="form-control" name="txtEmail" placeholder="nombre@example.com">
							<div class="invalid-feedback"></div>
						</div>
						<div class="form-group">
							<label for="txtPassword">Contraseña</label>
							<input type="password" class="form-control" name="txtPassword" placeholder="**********">
							<div class="invalid-feedback"></div>
						</div>
						<button type="submit" class="btn btn-primary btn-block">INGRESAR</button>
						<button id="forgotPassword" type="button" class="btn btn-link btn-block">¿Olvidaste tu contraseña?</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-notify/js/bootstrap-notify.js"></script>
	<script type="text/javascript">
		$(function(){
			/* -------------- SPINNER -------------- */
			$(document).on({
				ajaxStart: function() { $("body").addClass("loading"); },
				ajaxStop: function() { $("body").removeClass("loading"); }    
			});

			

			/* -------------- SCREEN MESSAGE CONFIG -------------- */
			$.notifyDefaults({
				placement: { from: 'bottom', align: 'right' },
				animate:{
					enter: "animated fadeInUp",
					exit:  "animated fadeOutDown"
				},
				delay: 3000,
				z_index: 10000
			});

			/* -------------- SEND LOGIN FORM -------------- */
			$("#loginForm").submit(function(e){
				e.preventDefault();

				$("[name=txtEmail]").removeClass("is-invalid");
				$("[name=txtPassword]").removeClass("is-invalid");

				$.ajax({
					url: "<?php echo base_url();?>api/login",
					method: "POST",
					data: $(this).serialize(),
					success: function(r){
						$.notify({message:"Inicio de sesión exitoso."},{type:'success'});
						document.location.reload();
					},
					error: function(r){
						var x = r.responseJSON;
						if (x.err && x.err.email){
							$("[name=txtEmail]").addClass("is-invalid"); $(`[name=txtEmail] + .invalid-feedback`).html(x.err.email);
						}
						if (x.err && x.err.pass){
							$("[name=txtPassword]").addClass("is-invalid"); $(`[name=txtPassword] + .invalid-feedback`).html(x.err.pass);
						}
						$.notify({title:`<strong>Error: </strong>`,message:x.msg},{type:'danger'});
					}
				});
			});

			/* -------------- OPEN FORGOT PASSWORD FORM -------------- */
			$("#forgotPassword").click(function(){
				$("#forgotPasswordModal").modal("show");
			});

			/* -------------- SEND FORGOT PASSWORD FORM -------------- */
			$("#forgotPasswordForm").submit(function(e){
				e.preventDefault();

				$("[name=txtEmailRecover]").removeClass("is-invalid");

				$.ajax({
					url: "<?php echo base_url();?>api/forgotPassword",
					method: "POST",
					data: {
						email: $("[name=txtEmailRecover]").val(),
						token: grecaptcha.getResponse()
					},
					success: function(r){
						$.notify({message:"Solicitud enviada. Recibirá un correo en los próximos minutos con las instrucciones respectivas."},{type:'success'});
						$("#forgotPasswordModal").modal("hide");
						grecaptcha.reset();
					},
					error: function(r) {
						var x = r.responseJSON;
						grecaptcha.reset();
						if (x.err){
							$("[name=txtEmailRecover]").addClass("is-invalid"); $(`[name=txtEmailRecover] + .invalid-feedback`).html(x.err.email);
						}
						$.notify({title:`<strong>Error: </strong>`,message:x.msg},{type:'danger'});
					}
				});
			});
		});</script>
</body>
</html>