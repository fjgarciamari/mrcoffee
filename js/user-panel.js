// Aqui iran todas las funciones que se ejecutan nada mas ha cargado la página
$(document).ready(function () {

    // Le añade la funcionalidad de abrir el modal de añadir usuario
    $(".panel-usuario__add-usuario").click(function () {
        muestraModalAddUsuario();
    })

    // Le añade la funcionalidad de enviar el form al boton de añadir usuario
    $('#enviarUsuarioNuevo').click(function () {
        let serializedData = $("#form-add-usuario").serialize();

        //guarda valores del formulario
        let dniClienteVal = $("#form-add-usuario input[name=dniCliente]").val();
        let direccionVal = $("#form-add-usuario input[name=direccion]").val();
        let nombreVal = $("#form-add-usuario input[name=nombre]").val();
        let emailVal = $("#form-add-usuario input[name=email]").val();

        //Llama a PHP para guardar el usuario
        $.ajax({
            url: "../php/controllers/add-usuario.php",
            data: serializedData,
            type: 'post',
            success: function(){
                alert("Usuario guardado");
                $("#modal-add-usuario").hide();
                
                //Crea objeto cliente para añadir la fila
                let cliente = {dniCliente: dniClienteVal, direccion: direccionVal, nombre: nombreVal, email: emailVal};
                crearFilaUsuario(cliente);
                
            },
            error: function(){
                alert("Fallo al añadir el usuario");
                $("#modal-add-usuario").hide();
            }
            
        })
    })

    $('#cancelarUsuarioNuevo').click( function() {
        $("#modal-add-usuario").hide();
    })

    // Le da funcionalidad al boton modificar usuario dentro del modal
    $('#modificarUsuario').click(function () {
        let serializedData = $("#form-edit-usuario").serialize();
        let dniCliente = $("#form-edit-usuario input[name=dniCliente]").val();
        //Llama a PHP para editar el usuario
        $.ajax({
            url: "../php/controllers/edit-usuario.php",
            data: serializedData,
            type: 'post',
            success: function(){
                alert("Usuario editado");

                //Modificar la fila en el momento
                $("#cliente"+dniCliente).children(".tabla-usuarios__contenido-nombre").html($("#form-edit-usuario input[name=nombre]").val());
                $("#cliente"+dniCliente).children(".tabla-usuarios__contenido-direccion").html($("#form-edit-usuario input[name=direccion]").val());
                $("#cliente"+dniCliente).children(".tabla-usuarios__contenido-email").html($("#form-edit-usuario input[name=email]").val());

                $("#modal-edit-usuario").hide();
            },
            error: function(){
                alert("Fallo al añadir el usuario");
                $("#modal-edit-usuario").hide();
            }
            
        })
    })

    $("#cancelarModificarUsuario").click( function() {
        $("#modal-edit-usuario").hide();
    })

    



    actualizaUsuarios();
    
})

function muestraModalAddUsuario(){
    $('#form-add-usuario').trigger("reset");
    $("#modal-add-usuario").show();
}

function actualizaUsuarios(){
    $.ajax({
        type: "post",
        url: "../php/controllers/get-all-clientes.php",
        dataType: "json",
        success: function (response) {
            // Cargar los usuarios en la "tabla"
            $.each(response, function (i, cliente) {
                crearFilaUsuario(cliente);
                 
            });
        },
        error: function (response){
            alert("No se han podido cargar los usuarios");
        }
    });

}

function crearFilaUsuario(cliente){
    let fila = document.createElement("div");
    fila.id = "cliente"+cliente["dniCliente"];
    fila.className = "tabla-usuarios__contenido-fila";

    let celdaDni = document.createElement("div");
    celdaDni.className = "tabla-usuarios__contenido-valor tabla-usuarios__contenido-dniCliente";
    celdaDni.innerHTML = cliente["dniCliente"];

    let celdaNombre = document.createElement("div");
    celdaNombre.className = "tabla-usuarios__contenido-valor tabla-usuarios__contenido-nombre";
    celdaNombre.innerHTML = cliente["nombre"];

    let celdaDireccion = document.createElement("div");
    celdaDireccion.className = "tabla-usuarios__contenido-valor tabla-usuarios__contenido-direccion";
    celdaDireccion.innerHTML = cliente["direccion"];

    let celdaEmail = document.createElement("div");
    celdaEmail.className = "tabla-usuarios__contenido-valor tabla-usuarios__contenido-email";
    celdaEmail.innerHTML = cliente["email"];

    let celdaAcciones = document.createElement("div");
    celdaAcciones.className = "tabla-usuarios__contenido-acciones";
    let botonEditar = document.createElement("div");
    botonEditar.className = "boton boton--verde";
    botonEditar.innerHTML = "Editar";
    botonEditar.onclick = function(){
        
        $("#form-edit-usuario input[name=dniCliente]").val(cliente['dniCliente']);
        $("#form-edit-usuario input[name=nombre]").val(cliente['nombre']);
        $("#form-edit-usuario input[name=direccion]").val(cliente['direccion']);
        $("#form-edit-usuario input[name=email]").val(cliente['email']);

        $("#modal-edit-usuario").show();
    }
    let botonBorrar = document.createElement("div");
    botonBorrar.className = "boton boton--rojo";
    botonBorrar.innerHTML = "Borrar";
    botonBorrar.onclick = function(){
        $.ajax({
            url: "../php/controllers/delete-usuario.php",
            data: {dniCliente : cliente["dniCliente"]},
            type: 'post',
            success: function(){
                $("#cliente"+cliente['dniCliente']).remove();
                alert("Usuario borrado");

            },
            error: function(){
                alert("Fallo al borrar el usuario");
            }
            
        })
    }
    celdaAcciones.appendChild(botonBorrar);
    celdaAcciones.appendChild(botonEditar);

    fila.appendChild(celdaDni);
    fila.appendChild(celdaNombre);
    fila.appendChild(celdaDireccion);
    fila.appendChild(celdaEmail);
    fila.appendChild(celdaAcciones);

    $(".tabla-usuarios__contenido").append(fila);
}