<script>$(function(){$("#PageTitle").html("Mi Perfil");$("#ResponsiveTitle").html("Mi Perfil");});</script>
<p>Aquí encontrará toda la información relacionada a su perfil.</p>

<div class="row">
	<div class="col-md pb-3">
		<div class="card bg-light">
			<div class="card-body align-items-center">
				<h5><strong>Datos de usuario</strong></h5>
				<hr>
				<form id="ChangeProfileForm" action="#">
					<div class="form-group">
						<label for="nombre">Nombre:</label>
						<input name="txtName" type="text" class="form-control" id="nombre" disabled>
						<div class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="correo">Correo electrónico:</label>
						<input name="txtEmail" type="email" class="form-control" id="correo" disabled>
						<div class="invalid-feedback"></div>
					</div>
					<div id="ProfileBottomBar">
						<button type="button" id="EditProfile" class="btn btn-info btn-block">CAMBIAR DATOS</button>
					</div>
					<div id="ProfileEditBottomBar" class="d-none">
						<div class="row">
							<div class="col pb-1">
								<button type="button" id="CancelEditProfile" class="btn btn-danger btn-block">CANCELAR</button>
							</div>
							<div class="col">
								<button type="submit" class="btn btn-primary btn-block">GUARDAR CAMBIOS</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md">
		<div class="card bg-light">
			<div class="card-body">
				<h5><strong>Cambio de clave</strong></h5>
				<hr>
				<form id="ChangePasswordForm" action="#">
					<div class="form-group">
						<label for="oldPassword">Contraseña actual:</label>
						<input type="password" class="form-control" id="oldPassword" name="txtOldPass" placeholder="********">
						<div class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="newPassword">Nueva contraseña:</label>
						<input type="password" class="form-control" id="newPassword" name="txtNewPass" placeholder="********">
						<div class="invalid-feedback"></div>
					</div>
					<div class="form-group">
						<label for="confirmNewPassword">Confirmar nueva contraseña:</label>
						<input type="password" class="form-control" id="confirmNewPassword" name="txtConfirmNewPass" placeholder="********">
						<div class="invalid-feedback"></div>
					</div>
					<button type="submit" class="btn btn-primary btn-block">CAMBIAR CLAVE</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
$(function(){
	/* -------------- OBTENCION DE LOS DATOS DEL USUARIO -------------- */
	$.ajax({
		url: host_url+'api/getUser',
		type: 'GET',
		success: function(r){
			$("[name=txtName]").val(r.name);
			$("[name=txtEmail]").val(r.email);
		},
		error: function(r){
			showScreenMessage("No se pudo obtener la información del usuario.","danger");
			console.log(r.responseJSON);
		}
	});

	/* -------------- ACCION AL PRESIONAR EL BOTÓN PARA EDITAR LOS DATOS DEL PERFIL-------------- */
	$("#EditProfile").click(function(){
		$("#ChangeProfileForm").data("txtName",  $("[name=txtName]").val()  ); $("[name=txtName]").prop("disabled",false);
		$("#ChangeProfileForm").data("txtEmail", $("[name=txtEmail]").val() ); $("[name=txtEmail]").prop("disabled",false);
		$("#ProfileEditBottomBar").toggleClass("d-none"); $("#ProfileBottomBar").toggleClass("d-none");
	});

	/* -------------- ACCION AL PRESIONAR EL BOTÓN PARA CANCELAR LA EDICION DEL PERFIL-------------- */
	$("#CancelEditProfile").click(function(){
		$("[name=txtName]").val(  $("#ChangeProfileForm").data("txtName")  ); $("[name=txtName]").prop("disabled",true);
		$("[name=txtEmail]").val( $("#ChangeProfileForm").data("txtEmail") ); $("[name=txtEmail]").prop("disabled",true);
		$("[name=txtName]").removeClass("is-invalid"); $("[name=txtEmail]").removeClass("is-invalid");
		$("#ProfileEditBottomBar").toggleClass("d-none"); $("#ProfileBottomBar").toggleClass("d-none");
	});

	/* -------------- ACCIÓN AL ENVIAR LOS DATOS MODIFICADOS DEL PERFIL -------------- */
	$("#ChangeProfileForm").submit(function(e){
		e.preventDefault();
		$("[name=txtName]").removeClass("is-invalid"); $("[name=txtEmail]").removeClass("is-invalid");

		$.ajax({
			url: host_url+'api/changeProfileData',
			data: {	name: $("[name=txtName]").val(), email: $("[name=txtEmail]").val() },
			type: 'POST',
			success: function(r){
				$("[name=txtName]").prop("disabled",true); $("[name=txtEmail]").prop("disabled",true);
				$("#ProfileEditBottomBar").toggleClass("d-none"); $("#ProfileBottomBar").toggleClass("d-none");
				showScreenMessage("La información del perfil ha sido cambiada exitosamente",'success');
			},
			error: function(r){
				x = r.responseJSON;
				showScreenMessage(x.msg,'danger',"ERROR");
				if (x.err.name){
					$(`[name=txtName]`).addClass("is-invalid"); $(`[name=txtName] + .invalid-feedback`).html(x.err.name);
				}
				if (x.err.email){
					$(`[name=txtEmail]`).addClass("is-invalid"); $(`[name=txtEmail] + .invalid-feedback`).html(x.err.email);
				}
			}
		});
	});

	/* -------------- ACCIÓN AL ENVIAR LOS DATOS MODIFICADOS DE LA CONTRASEÑA -------------- */
	$("#ChangePasswordForm").submit(function(e){
		e.preventDefault();
		$("[name=txtOldPass]").removeClass("is-invalid");
		$("[name=txtNewPass]").removeClass("is-invalid");
		$("[name=txtConfirmNewPass]").removeClass("is-invalid");

		$.ajax({
			url: host_url+'api/changePassword',
			data: {	
				oldPass: $("[name=txtOldPass]").val(),
				newPass: $("[name=txtNewPass]").val(),
				confirmNewPass: $("[name=txtConfirmNewPass]").val()},
			type: 'POST',
			success: function(r){
				showScreenMessage("La clave de acceso ha sido cambiada exitosamente",'success');
			},
			error: function(r){
				x = r.responseJSON;
					showScreenMessage(x.msg,'danger',"ERROR");
					if (typeof x.err.oldPass !== undefined){
							$(`[name=txtOldPass]`).addClass("is-invalid"); $(`[name=txtOldPass] + .invalid-feedback`).html(x.err.oldPass);
					}
					if (typeof x.err.newPass !== undefined){
							$(`[name=txtNewPass]`).addClass("is-invalid"); $(`[name=txtNewPass] + .invalid-feedback`).html(x.err.newPass);
					}
					if (typeof x.err.confirmNewPass !== undefined){
							$(`[name=txtConfirmNewPass]`).addClass("is-invalid"); $(`[name=txtConfirmNewPass] + .invalid-feedback`).html(x.err.confirmNewPass);
					}
			}
		});
	});
});
</script>