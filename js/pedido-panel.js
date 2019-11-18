// Aqui iran todas las funciones que se ejecutan nada mas ha cargado la página
$(document).ready(function () {

    // Le añade la funcionalidad de abrir el modal de añadir pedido
    $(".panel-pedido__add-pedido").click(function () {
        muestraModalAddPedido();
    })

    // Le añade la funcionalidad de enviar el form al boton de añadir pedido
    $('#enviarPedidoNuevo').click(function () {
        let form = $("#form-add-pedido")[0];
        let formData = new FormData(form);

        //guarda valores del formulario
        let fechaVal = $("#form-add-pedido input[name=fecha]").val();
        let dirEntregaVal = $("#form-add-pedido input[name=dirEntrega]").val();
        let nTarjetaVal = $("#form-add-pedido input[name=nTarjeta]").val();
        let fechaCaducidadVal = $("#form-add-pedido input[name=fechaCaducidad]").val();
        let matriculaRepartidorVal = $("#form-add-pedido input[name=matriculaRepartidor]").val();
        let dniClienteVal = $("#form-add-pedido input[name=dniCliente]").val();

        
        //Llama a PHP para guardar el pedido
        $.ajax({
            url: "../php/controllers/add-pedido.php",
            data: formData,
            type: 'post',
            dataType: 'json',
            contentType: false,
            processData: false,
            // En la respuesta viene la url de la imagen
            success: function(response){
                let idPedidoVal = response["idPedido"];
                alert("Pedido guardado");
                $("#modal-add-pedido").hide();
                
                //Crea objeto pedido para añadir la fila
                let pedido = {idPedido: idPedidoVal, fecha: fechaVal, dirEntrega: dirEntregaVal, nTarjeta: nTarjetaVal, 
                    fechaCaducidad: fechaCaducidadVal, matriculaRepartidor: matriculaRepartidorVal, dniCliente: dniClienteVal};
                crearFilaPedido(pedido);
                
            },
            error: function(){
                alert("Fallo al añadir el pedido");
                $("#modal-add-pedido").hide();
            }
            
        })
    })

    $("#cancelarPedidoNuevo").click(function () {
        $("#modal-add-pedido").hide();
    })

    // Le da funcionalidad al boton modificar pedido dentro del modal
    $('#modificarPedido').click(function () {
        let serializedData = $("#form-edit-pedido").serialize();
        let idPedido = $("#form-edit-pedido input[name=idPedido]").val();
        //Llama a PHP para editar el pedido
        $.ajax({
            url: "../php/controllers/edit-pedido.php",
            data: serializedData,
            type: 'post',
            success: function(){
                alert("Pedido editado");

                //Modificar la fila en el momento
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-idPedido").html($("#form-edit-pedido input[name=idPedido]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-fecha").html($("#form-edit-pedido input[name=fecha]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-dirEntrega").html($("#form-edit-pedido input[name=dirEntrega]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-nTarjeta").html($("#form-edit-pedido input[name=nTarjeta]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-fechaCaducidad").html($("#form-edit-pedido input[name=fechaCaducidad]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-matriculaRepartidor").html($("#form-edit-pedido input[name=matriculaRepartidor]").val());
                $("#pedido"+idPedido).children(".tabla-pedidos__contenido-dniCliente").html($("#form-edit-pedido input[name=dniCliente]").val());

                $("#modal-edit-pedido").hide();
            },
            error: function(){
                alert("Fallo al añadir el pedido");
                $("#modal-edit-pedido").hide();
            }
            
        })
    })

    $("#cancelarModificarPedido").click(function () {
        $("#modal-edit-pedido").hide();
    })



    actualizaPedidos();
    
})

function muestraModalAddPedido(){
    $("#modal-add-pedido").show();
}

function actualizaPedidos(){
    $.ajax({
        type: "post",
        url: "../php/controllers/get-all-pedidos.php",
        dataType: "json",
        success: function (response) {
            // Cargar los pedidos en la "tabla"
            $.each(response, function (i, pedido) {
                crearFilaPedido(pedido);
            });
        },
        error: function (){
            alert("No se han podido cargar los pedidos");
        }
    });

}

function crearFilaPedido(pedido){
    let fila = document.createElement("div");
    fila.id = "pedido"+pedido["idPedido"];
    fila.className = "tabla-pedidos__contenido-fila";

    let celdaIdPedido = document.createElement("div");
    celdaIdPedido.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-idPedido";
    celdaIdPedido.innerHTML = pedido["idPedido"];

    let celdaFecha = document.createElement("div");
    celdaFecha.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-fecha";
    celdaFecha.innerHTML = pedido["fecha"];

    let celdaDirEntrega = document.createElement("div");
    celdaDirEntrega.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-dirEntrega";
    celdaDirEntrega.innerHTML = pedido["dirEntrega"];

    let celdaNTarjeta = document.createElement("div");
    celdaNTarjeta.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-nTarjeta";
    celdaNTarjeta.innerHTML = pedido["nTarjeta"];

    let celdaFechaCaducidad = document.createElement("div");
    celdaFechaCaducidad.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-fechaCaducidad";
    celdaFechaCaducidad.innerHTML = pedido["fechaCaducidad"];

    let celdaMatriculaRepartidor = document.createElement("div");
    celdaMatriculaRepartidor.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-matriculaRepartidor";
    celdaMatriculaRepartidor.innerHTML = pedido["matriculaRepartidor"];

    let celdaDniCliente = document.createElement("div");
    celdaDniCliente.className = "tabla-pedidos__contenido-valor tabla-pedidos__contenido-dniCliente";
    celdaDniCliente.innerHTML = pedido["dniCliente"];

    let celdaAcciones = document.createElement("div");
    celdaAcciones.className = "tabla-pedido__contenido-acciones";
    let botonEditar = document.createElement("div");
    botonEditar.className = "boton boton--verde";
    botonEditar.innerHTML = "Editar";
    botonEditar.onclick = function(){

        $("#form-edit-pedido input[name=idPedido]").val(pedido["idPedido"]);
        $("#form-edit-pedido input[name=fecha]").val(pedido["fecha"]);
        $("#form-edit-pedido input[name=dirEntrega]").val(pedido["dirEntrega"]);
        $("#form-edit-pedido input[name=nTarjeta]").val(pedido["nTarjeta"]);
        $("#form-edit-pedido input[name=fechaCaducidad]").val(pedido["fechaCaducidad"]);
        $("#form-edit-pedido input[name=matriculaRepartidor]").val(pedido["matriculaRepartidor"]);
        $("#form-edit-pedido input[name=dniCliente]").val(pedido["dniCliente"]);

        $("#modal-edit-pedido").show();
    }
    let botonBorrar = document.createElement("div");
    botonBorrar.className = "boton boton--rojo";
    botonBorrar.innerHTML = "Borrar";
    botonBorrar.onclick = function(){
        $.ajax({
            url: "../php/controllers/delete-pedido.php",
            data: {idPedido : pedido['idPedido']},
            type: 'post',
            success: function(){
                $("#pedido"+pedido['idPedido']).remove();
                alert("Pedido borrado");

            },
            error: function(){
                alert("Fallo al borrar el pedido");
            }
            
        })
    }
    celdaAcciones.appendChild(botonBorrar);
    celdaAcciones.appendChild(botonEditar);

    fila.appendChild(celdaIdPedido);
    fila.appendChild(celdaFecha);
    fila.appendChild(celdaDirEntrega);
    fila.appendChild(celdaNTarjeta);
    fila.appendChild(celdaFechaCaducidad);
    fila.appendChild(celdaMatriculaRepartidor);
    fila.appendChild(celdaDniCliente);

    fila.appendChild(celdaAcciones);

    $(".tabla-pedidos__contenido").append(fila);
}