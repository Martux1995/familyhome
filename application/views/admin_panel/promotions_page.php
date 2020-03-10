<script>$(function(){$("#PageTitle").html("Registro de promociones");$("#ResponsiveTitle").html("Registro de promociones");});</script>

<!-- TABLA CON LOS USUARIOS -->
<div class="row">
	<div class="col">
		<h4>Listado de promociones</h4>
	</div>
	<div class="col text-right">
		<button id="openNewPromotionModal" class="btn btn-primary"><i class="fas fa-user-plus"></i> CREAR PROMOCIóN</button>
	</div>
</div>

<div class="row pt-2">
	<div class="col">
		<table id="promotionsTable" class="table table-striped table-bordered" style="width:100%">
			<thead> <tr> <th>Nombre</th><th>Registro</th><th>Inicio</th><th>Fin</th><th>Acciones</th> </tr> </thead>
			<tbody id="tableData"></tbody>
		</table>
	</div>
</div>

<!-- MODAL -->
<div id="PromotionModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"><h5 id="PromotionModalTitle" class="modal-title"></h5></div>

			<form id="PromotionForm" action="">
				<div class="modal-body">
					<div class="row"><div class="col-sm"><p id="PromotionModalInfo"></p></div></div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-4 control-label">
								Nombre: 
								<input type="text" class="form-control" name="txtTitle" placeholder="Promoción de ..." />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-4 control-label">
								Fecha de inicio: 
								<input type="date" class="form-control" name="txtStartDate" placeholder="01/02/2019" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-4 control-label">
								Fecha de fin: 
								<input type="date" class="form-control" name="txtEndDate" placeholder="01/02/2019" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-12 control-label">
								Descripción de la promoción: 
								<textarea class="form-control" name="txtDescription" placeholder="Ingrese texto..." />
								<div class="invalid-feedback"></div>
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

<div id="PromotionDeleteModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"><h5 class="modal-title">Eliminar promocion</h5></div>
			<form id="PromotionDeleteForm" action="">
				<div class="modal-body">
					<div class="row"><div class="col-sm">¿Está seguro de eliminar la promoción seleccionada?</div></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Aceptar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="PromotionViewModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"><h5 class="modal-title">Datos de la promoción</h5></div>
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 col-lg-4 control-label">
								Nombre: 
								<input type="text" class="form-control" name="txtTitleView" readonly placeholder="Promoción de ..." />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-4 control-label">
								Fecha de inicio: 
								<input type="date" class="form-control" name="txtStartDateView" readonly placeholder="01/02/2019" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-4 control-label">
								Fecha de fin: 
								<input type="date" class="form-control" name="txtEndDateView" readonly placeholder="01/02/2019" />
								<div class="invalid-feedback"></div>
							</div>
							<div class="col-md-12 col-lg-12 control-label">
								Descripción de la promoción: 
								<textarea class="form-control" name="txtDescriptionView" readonly placeholder="Ingrese texto..." />
								<div class="invalid-feedback"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
		</div>
	</div>
</div>

<script>
$(function(){
		// RELLENO DE LA TABLA
	$("#promotionsTable").DataTable({
		ajax: {
			url: host_url+"api/getPromotions",
			type: "GET",
			dataSrc: function (res) {
				return res.map(function(data){
					return {
						title: data.title,
						regDate: data.regDate,
						startDate: data.startDate,
						endDate: data.endDate,
						actions: (
							`<button class="viewPromotion btn btn-sm btn-block btn-primary" data-id="${data.id}"><i class="fas fa-eye"/> VER </button>
							<button class="modifyPromotion btn btn-sm btn-block btn-warning" data-id="${data.id}"><i class="fas fa-edit"/> MODIFICAR</button>
							<button class="deletePromotion btn btn-sm btn-block btn-danger" data-id="${data.id}"><i class="fas fa-ban"/> ELIMINAR</button>`
						)
					};
				});
			}
		},
		columns: [
			{className: "align-middle", data: "title"},
			{className: "align-middle", data: "regDate"},
			{className: "align-middle", data: "startDate"},
			{className: "align-middle", data: "endDate"},
			{className: "align-middle", data: "actions"}
		]
	});

	function transformDate(date) {
		console.log(date);
		var p = date.match(/(\d+)/g); // receive yyyy-mm-dd
		return `${p[2]}/${p[1]}/${p[0]}`;
	}

	$("#openNewPromotionModal").click(function(){
		$("#PromotionModalTitle").html("Ingresar nueva promoción");
		$("#PromotionModalInfo").html(`Complete los siguientes datos para crear una nueva promoción. 
			Esta se mostrará en la página principal cuando la fecha se encuentre dentro del rango.`);

		$("#PromotionModal").data("action","create");
		$("#PromotionModal").data("id", "0" );
		$("#PromotionModal").modal('show');
	});

	$("#promotionsTable").on("click",".viewPromotion", function(){
		$("#PromotionViewModal").data("id", $(this).data("id") );
		$.getJSON(host_url+'api/getPromotion/'+$(this).data("id"),null,function(r){

			$("[name=txtTitleView]").val(r.title);
			$("[name=txtDescriptionView]").val(r.description);
			$("[name=txtStartDateView]").val(r.startDate);
			$("[name=txtEndDateView]").val(r.endDate);

			$("#PromotionViewModal").modal('show');
		});
	});

    // ACCIÓN AL PRESIONAR EL BOTÓN DE MODIFICAR PROMOCION
	$("#promotionsTable").on("click",".modifyPromotion", function(){
		$("#PromotionModal").data("id", $(this).data("id") );
		$.getJSON(host_url+'api/getPromotion/'+$(this).data("id"),null,function(r){
			$("#PromotionModalTitle").html("Modificar promoción");
			$("#PromotionModalInfo").html(`Puede modificar los datos de la promoción seleccionada.`);

			$("[name=txtTitle]").val(r.title);
			$("[name=txtDescription]").val(r.description);
			$("[name=txtStartDate]").val(r.startDate);
			$("[name=txtEndDate]").val(r.endDate);

			$("#PromotionModal").data("action","modify");
			$("#PromotionModal").modal('show');
		});
	});

    // ACCIÓN AL PRESIONAR EL BOTÓN DE ELIMINAR PROMOCION
	$("#promotionsTable").on("click",".deletePromotion", function(){
		$("#PromotionDeleteModal").data("id", $(this).data("id") );
		$("#PromotionDeleteModal").modal('show');        
	});

	// ACCIÓN AL MOMENTO DE CERRAR LA VENTANA MODAL DE PROMOCIONS
	$('#PromotionModal').on('hidden.bs.modal', function (e) {
		$("[name=txtTitle]").removeClass("is-invalid");
		$("[name=txtDescription]").removeClass("is-invalid");
		$("[name=txtStartDate]").removeClass("is-invalid");
		$("[name=txtEndDate]").removeClass("is-invalid");
		
		$('#PromotionForm')[0].reset();
	});

    // ACCIÓN AL MOMENTO DE ENVIAR EL FORMULARIO DE CREAR Y MODIFICAR USUARIO
	$("#PromotionForm").submit(function(e){
		e.preventDefault();

		$("[name=txtTitle]").removeClass("is-invalid");
		$("[name=txtDescription]").removeClass("is-invalid");
		$("[name=txtStartDate]").removeClass("is-invalid");
		$("[name=txtEndDate]").removeClass("is-invalid");

		const urlQuery = $("#PromotionModal").data("action") == "create" 
									? "createPromotion"
									: ("modifyPromotion/" + $("#PromotionModal").data("id"));

		$.ajax({
			url: host_url + "api/" + urlQuery,
			method: "POST",
			data: {
				title: $("[name=txtTitle]").val(),
				description: $("[name=txtDescription]").val(),
				start_date: transformDate($("[name=txtStartDate]").val()),
				end_date: transformDate($("[name=txtEndDate]").val())
			},
			success: function (res) {
				$('#PromotionModal').modal('hide');
				$('#PromotionForm')[0].reset();
				if ($("#PromotionModal").data("action") == "create"){
					showScreenMessage('La promoción ha sido creada exitosamente.','success');
				} else {
					showScreenMessage('Los datos de la promoción han sido modificados exitosamente.','success');
				}
				$("#promotionsTable").DataTable().ajax.reload();
			},
			error: function (data) {
				x = data.responseJSON;
				showScreenMessage(x.msg,'danger',"ERROR");
				if (x.err.title){
					$(`[name=txtTitle]`).addClass("is-invalid"); $(`[name=txtTitle] + .invalid-feedback`).html(x.err.title);
				}
				if (x.err.description){
					$(`[name=txtDescription]`).addClass("is-invalid"); $(`[name=txtDescription] + .invalid-feedback`).html(x.err.description);
				}
				if (x.err.start_date){
					$(`[name=txtStartDate]`).addClass("is-invalid"); $(`[name=txtStartDate] + .invalid-feedback`).html(x.err.start_date);
				}
				if (x.err.end_date){
					$(`[name=txtEndDate]`).addClass("is-invalid"); $(`[name=txtEndDate] + .invalid-feedback`).html(x.err.end_date);
				}
			}
		});
	});

	// ACCIÓN AL MOMENTO DE ENVIAR EL FORMULARIO PARA ELIMINAR USUARIO
	$("#PromotionDeleteForm").submit(function(e){
		e.preventDefault();
		$.ajax({
			url: host_url + "api/deletePromotion/" + $("#PromotionDeleteModal").data("id"),
			method: "POST",
			success: function (res) {
				$('#PromotionDeleteModal').modal('hide');
				showScreenMessage('La promoción ha sido eliminada exitosamente.','success');
				$("#promotionsTable").DataTable().ajax.reload();
			},
			error: function (data) {
				x = data.responseJSON;
				showScreenMessage(x.msg,'danger',"ERROR");
			}
		});
	});

});
</script>