<script>$(function(){$("#PageTitle").html("Configuraciones");$("#ResponsiveTitle").html("Configuraciones");});</script>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Información de contacto</div>
            <div class="card-body">
                <p>Aquí puede modificar los datos de contacto que aparecen en la sección "CONTACTO" de la página principal.
                También es posible seleccionar si se desean mostrar o no cada uno de los datos en la página web<p>
                <form id="contactInfoModifier" action="#">
					<div class="form-group">
						<label for="nombre">Teléfono de contacto 1:</label>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <input type="checkbox" id="enablePhone1">
                                </div>
                            </div>
                            <input type="text" class="form-control" id="txtPhone1" name="txtPhone1" disabled>
						    <div class="invalid-feedback"></div>
                        </div>
					</div>
                    <div class="form-group">
						<label for="nombre">Teléfono de contacto 2:</label>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <input type="checkbox" id="enablePhone2">
                                </div>
                            </div>
                            <input type="text" class="form-control" id="txtPhone2" name="txtPhone2" disabled>
						    <div class="invalid-feedback"></div>
                        </div>
					</div>
					<div class="form-group">
						<label for="correo">Correo electrónico:</label>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                <input type="checkbox" id="enableEmail">
                                </div>
                            </div>
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" disabled>
						    <div class="invalid-feedback"></div>
                        </div>
					</div>
                    <button type="submit" class="btn btn-primary btn-block">GUARDAR CAMBIOS</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Formulario de contacto</div>
            <div class="card-body">
                <p>Aquí puede habilitar o deshabilitar el formulario de contacto que aparece en la sección "CONTACTO", como también
                puede cambiar el correo electrónico que recibirá los correos que envíen los visitantes.</p>
                <form id="contactFormModifier" action="#">
					<div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="txtEnableForm">
                            <label class="form-check-label" for="txtEnableForm">
                                Habilitar formulario de contacto
                            </label>
                        </div>
					</div>
					<div class="form-group">
						<label for="correo">Correo electrónico receptor:</label>
						<input name="txtEmail" type="email" class="form-control" id="txtEmailReceiver">
						<div class="invalid-feedback"></div>
					</div>
                    <button type="submit" class="btn btn-primary btn-block">GUARDAR CAMBIOS</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){

    $("#enablePhone1").on("change",function(){
        $("#txtPhone1").prop("disabled",!$(this).prop("checked"));
    });

    $("#enablePhone2").on("change",function(){
        $("#txtPhone2").prop("disabled",!$(this).prop("checked"));
    });

    $("#enableEmail").on("change",function(){
        $("#txtEmail").prop("disabled",!$(this).prop("checked"));
    });

    // CARGA DE LOS DATOS
    $.getJSON(host_url+'api/getContactInformation',null,function(res){
        if (res.phoneContact1) {
            $("#enablePhone1").prop("checked",true);
            $("#txtPhone1").val(res.phoneContact1).prop("disabled",false);
        }
        if (res.phoneContact2) {
            $("#enablePhone2").prop("checked",true);
            $("#txtPhone2").val(res.phoneContact2).prop("disabled",false);
        }
        if (res.emailContact) {
            $("#enableEmail").prop("checked",true);
            $("#txtEmail").val(res.emailContact).prop("disabled",false);
        }
        $("#txtEnableForm").prop("checked",res.enableContactForm == 1);
        $("#txtEmailReceiver").val(res.emailContactForm);
    });

    $("#contactInfoModifier").submit(function(e) {
        e.preventDefault();

        // if ( window.confirm("asdasd") ) { }

        $("#txtPhone1").removeClass("is-invalid");
        $("#txtPhone2").removeClass("is-invalid");
        $("#txtEmail").removeClass("is-invalid");

        $.ajax({
            url: host_url + "api/updateContactInfo",
            method: "POST",
            data: {
                phoneContact1: $("#enablePhone1").prop("checked") ? $("#txtPhone1").val() : null,
                phoneContact2: $("#enablePhone2").prop("checked") ? $("#txtPhone2").val() : null,
                emailContact: $("#enableEmail").prop("checked") ? $("#txtEmail").val() : null
            },
            success: function () {
                showScreenMessage("Se ha modificado la información de contacto.");
            },
            error: function (err) {

                //showScreenMessage()
            }
        });
    });

    $("#contactFormModifier").submit(function(e) {
        e.preventDefault();

        $("#txtEmail").removeClass("is-invalid");
        
        $.ajax({
            url: host_url + "api/updateContactForm",
            method: "POST",
            data: {
                enableContactForm: $("#txtEnableForm").prop("checked"),
                emailContactForm:  $("#txtEmailReceiver").val()
            },
            success: function () {
                showScreenMessage("Se ha modificado el formulario de contacto.");
            },
            error: function (err) {
                let x = err.responseJSON;
                showScreenMessage(x.msg,'danger');
                
            }
        });
    });


    // ACCIÓN AL MOMENTO DE ENVIAR EL FORMULARIO DE CREAR Y MODIFICAR USUARIO
    $("#UserDataForm").submit(function(e){
        e.preventDefault();

        $("[name=txtName]").removeClass("is-invalid");
        $("[name=txtEmail]").removeClass("is-invalid");
        $("[name=txtLevel]").removeClass("is-invalid");

        const urlQuery = $("#UserDataModal").data("action") == "create" 
                            ? "createUser"
                            : ("modifyUser/" + $("#UserDataModal").data("id"));

        $.ajax({
            url: host_url + "api/" + urlQuery,
            method: "POST",
            data: {
                name: $("[name=txtName]").val(),
                email: $("[name=txtEmail]").val(),
                level: $("[name=txtLevel]").val()
            },
            success: function (res) {
                $('#UserDataModal').modal('hide');
                $('#UserDataForm')[0].reset();
                if ($("#UserDataModal").data("action") == "create"){
                    showScreenMessage('El usuario ha sido creado exitosamente. Recibirá un correo en los próximos minutos','success');
                } else {
                    showScreenMessage('Los datos del usuario han sido modificados exitosamente.','success');
                }
                $("#userTable").DataTable().ajax.reload();
            },
            error: function (data) {
                x = data.responseJSON;
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


});
</script>