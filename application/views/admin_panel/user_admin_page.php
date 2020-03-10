<script>$(function(){$("#PageTitle").html("Administración de usuarios");$("#ResponsiveTitle").html("Administración de usuarios");});</script>

<!-- TABLA CON LOS USUARIOS -->
<div class="row">
    <div class="col">
        <h4>Listado de usuarios</h4>
    </div>
    <div class="col text-right">
        <button id="openNewUserModal" class="btn btn-primary"><i class="fas fa-user-plus"></i> CREAR USUARIO</button>
    </div>

</div>

<div class="row pt-2">
    <div class="col">
        <table id="userTable" class="table table-striped table-bordered" style="width:100%">
            <thead> <tr> <th>Nombre</th><th>Correo</th><th>Permiso</th><th>Acciones</th> </tr> </thead>
            <tbody id="tableData"></tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div id="UserDataModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 id="UserModalTitle" class="modal-title"></h5></div>

            <form id="UserDataForm" action="">
                <div class="modal-body">
                    <div class="row"><div class="col-sm"><p id="UserModalInfo"></p></div></div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 col-lg-4 control-label">
                                Nombre: 
                                <input type="text" class="form-control" name="txtName" placeholder="Juan Pérez">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-12 col-lg-4 control-label">
                                Correo Electrónico: 
                                <input type="text" class="form-control" name="txtEmail" placeholder="nombre@example.com">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-12 col-lg-4 control-label">
                                Nivel de acceso: 
                                <select class="form-control" name="txtLevel"></select>
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

<div id="UserDataDeleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Eliminar usuario</h5></div>
            <form id="UserDataDeleteForm" action="">
                <div class="modal-body">
                    <div class="row"><div class="col-sm">¿Está seguro de eliminar al usuario seleccionado?</div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function(){
    // RELLENO DE LA TABLA
    $("#userTable").DataTable({
        ajax: {
            url: host_url+"api/getUsers",
            type: "GET",
            //data: function(d){}, /* Parámetros que se le envian a la solicitud */
            dataSrc: function (res) {
                var idu = <?php echo $_SESSION['id_user']; ?>;
                return res.map(function(data){
                    return {
                        name: data.name,
                        email: data.email,
                        level: data.level,
                        actions: (data.id != idu
                            ? `<button class="modifyUser btn btn-sm btn-block btn-warning" data-id="${data.id}"><i class="fas fa-user-edit"/> MODIFICAR</button>
                              <button class="deleteUser btn btn-sm btn-block btn-danger" data-id="${data.id}"><i class="fas fa-user-times"/> ELIMINAR</button>`
                            : '' )
                    }
                });
            }
        },
        columns: [
            {className: "align-middle", data: "name"},
            {className: "align-middle", data: "email"},
            {className: "align-middle", data: "level"},
            {className: "align-middle", data: "actions"}
        ]
    });

    // OBTENCIÓN DE LOS TIPOS DE ACCESO
    $.getJSON(host_url+'api/getLevelAccessList',null,function(res){
        $("[name=txtLevel]").html("");
        res.map(function(d){
            $("[name=txtLevel]").append(`<option value="${d.id}">${d.name}</option>`);
        });
    });

    // ACCIÓN AL PRESIONAR EL BOTÓN DE CREAR USUARIO
    $("#openNewUserModal").click(function(){
        $("#UserModalTitle").html("Ingresar nuevo usuario");
        $("#UserModalInfo").html(`Complete los siguientes datos para crear un nuevo usuario. 
            Posteriormente, se le enviará un correo con la información necesaria para acceder 
            al sistema`);

        $("[name=txtEmail]").prop("disabled",false);

        $("#UserDataModal").data("action","create");
        $("#UserDataModal").data("id", "0" );
        $("#UserDataModal").modal('show');
    });

    // ACCIÓN AL PRESIONAR EL BOTÓN DE MODIFICAR USUARIO
    $("#tableData").on("click",".modifyUser", function(){
        $("#UserDataModal").data("id", $(this).data("id") );
        $.getJSON(host_url+'api/getUser/'+$(this).data("id"),null,function(r){
            $("#UserModalTitle").html("Modificar usuario");
            $("#UserModalInfo").html(`Puede modificar el nombre y los permisos del usuario seleccionado.`);
        
            $("[name=txtName]").val(r.name);
            $("[name=txtEmail]").val(r.email); $("[name=txtEmail]").prop("disabled",true);
            $("[name=txtLevel]").val(r.level.id);

            $("#UserDataModal").data("action","modify");
            $("#UserDataModal").modal('show');
        });
    });

    // ACCIÓN AL PRESIONAR EL BOTÓN DE ELIMINAR USUARIO
    $("#tableData").on("click",".deleteUser", function(){
        $("#UserDataDeleteModal").data("id", $(this).data("id") );
        $("#UserDataDeleteModal").modal('show');        
    });

    // ACCIÓN AL MOMENTO DE CERRAR LA VENTANA MODAL DE USUARIOS
    $('#UserDataModal').on('hidden.bs.modal', function (e) {
        $("[name=txtName]").removeClass("is-invalid");
        $("[name=txtEmail]").removeClass("is-invalid");
        $("[name=txtLevel]").removeClass("is-invalid");
        $('#UserDataForm')[0].reset();
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

    // ACCIÓN AL MOMENTO DE ENVIAR EL FORMULARIO PARA ELIMINAR USUARIO
    $("#UserDataDeleteForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: host_url + "api/deleteUser/" + $("#UserDataDeleteModal").data("id"),
            method: "POST",
            success: function (res) {
                $('#UserDataDeleteModal').modal('hide');
                showScreenMessage('El usuario ha sido eliminado exitosamente.','success');
                $("#userTable").DataTable().ajax.reload();
            },
            error: function (data) {
                x = data.responseJSON;
                showScreenMessage(x.msg,'danger',"ERROR");
            }
        });
    });
});
</script>