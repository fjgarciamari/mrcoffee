// Aqui iran todas las funciones que se ejecutan nada mas ha cargado la página
$(document).ready(function () {

    // Le añade la funcionalidad de abrir el modal de añadir producto
    $(".panel-producto__add-producto").click(function () {
        muestraModalAddProducto();
    })

    // Le añade la funcionalidad de enviar el form al boton de añadir producto
    $('#enviarProductoNuevo').click(function () {
        let form = $("#form-add-producto")[0];
        let formData = new FormData(form);

        //guarda valores del formulario
        let nombreVal = $("#form-add-producto input[name=nombre]").val();
        let origenVal = $("#form-add-producto input[name=origen]").val();
        let tipoVal = $("#form-add-producto input[name=tipoMolido]").val();
        let marcaVal = $("#form-add-producto input[name=marca]").val();
        let pesoVal = $("#form-add-producto input[name=peso]").val();
        let unidadesVal = $("#form-add-producto input[name=unidades]").val();
        let precioVal = $("#form-add-producto input[name=precio]").val();

        
        //Llama a PHP para guardar el producto
        $.ajax({
            url: "../php/controllers/add-producto.php",
            data: formData,
            type: 'post',
            dataType: 'json',
            contentType: false,
            processData: false,
            // En la respuesta viene la url de la imagen
            success: function(response){
                let fotoUrl = response["fotoUrl"];
                let idProductoVal = response["idProducto"];
                alert("Producto guardado");
                $("#modal-add-producto").hide();
                
                //Crea objeto producto para añadir la fila
                let producto = {idProducto: idProductoVal, foto: fotoUrl, nombre: nombreVal, 
                                origen: origenVal, tipoMolido: tipoVal, marca: marcaVal,
                                peso: pesoVal, unidades: unidadesVal, precio: precioVal};
                crearFilaProducto(producto);
                
            },
            error: function(){
                alert("Fallo al añadir el producto");
                $("#modal-add-producto").hide();
            }
            
        })
    })

    // Le da funcionalidad al boton modificar producto dentro del modal
    $('#modificarProducto').click(function () {
        let serializedData = $("#form-edit-producto").serialize();
        let idProducto = $("#form-edit-producto input[name=idProducto]").val();
        //Llama a PHP para editar el producto
        $.ajax({
            url: "../php/controllers/edit-producto.php",
            data: serializedData,
            type: 'post',
            success: function(){
                alert("Producto editado");

                //Modificar la fila en el momento
                $("#producto"+idProducto).children(".tabla-productos__contenido-nombre").html($("#form-edit-producto input[name=nombre]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-origen").html($("#form-edit-producto input[name=origen]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-marca").html($("#form-edit-producto input[name=marca]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-tipo").html($("#form-edit-producto input[name=tipoMolido]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-unidades").html($("#form-edit-producto input[name=unidades]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-peso").html($("#form-edit-producto input[name=peso]").val());
                $("#producto"+idProducto).children(".tabla-productos__contenido-precio").html($("#form-edit-producto input[name=precio]").val());

                $("#modal-edit-producto").hide();
            },
            error: function(){
                alert("Fallo al añadir el producto");
                $("#modal-edit-producto").hide();
            }
            
        })
    })



    actualizaProductos();
    
})

function muestraModalAddProducto(){
    $("#modal-add-producto").show();
}

function actualizaProductos(){
    $.ajax({
        type: "post",
        url: "../php/controllers/get-all-productos.php",
        dataType: "json",
        success: function (response) {
            // Cargar los productos en la "tabla"
            $.each(response, function (i, producto) {
                crearFilaProducto(producto);
            });
        },
        error: function (){
            alert("No se han podido cargar los productos");
        }
    });

}

function crearFilaProducto(producto){
    let fila = document.createElement("div");
    fila.id = "producto"+producto["idProducto"];
    fila.className = "tabla-productos__contenido-fila";

    let celdaIdProducto = document.createElement("div");
    celdaIdProducto.className = "tabla-productos__contenido-valor tabla-productos__contenido-idProducto";
    celdaIdProducto.innerHTML = producto["idProducto"];

    let celdaFoto = document.createElement("div");
    celdaFoto.className = "tabla-productos__contenido-valor tabla-productos__contenido-foto";
    let imgFoto = document.createElement("img");
    imgFoto.src = producto["foto"];
    celdaFoto.appendChild(imgFoto);

    let celdaNombre = document.createElement("div");
    celdaNombre.className = "tabla-productos__contenido-valor tabla-productos__contenido-nombre";
    celdaNombre.innerHTML = producto["nombre"];

    let celdaOrigen = document.createElement("div");
    celdaOrigen.className = "tabla-productos__contenido-valor tabla-productos__contenido-origen";
    celdaOrigen.innerHTML = producto["origen"];

    let celdaMarca = document.createElement("div");
    celdaMarca.className = "tabla-productos__contenido-valor tabla-productos__contenido-marca";
    celdaMarca.innerHTML = producto["marca"];

    let celdaTipo = document.createElement("div");
    celdaTipo.className = "tabla-productos__contenido-valor tabla-productos__contenido-tipo";
    celdaTipo.innerHTML = producto["tipoMolido"];

    let celdaPeso = document.createElement("div");
    celdaPeso.className = "tabla-productos__contenido-valor tabla-productos__contenido-peso";
    celdaPeso.innerHTML = producto["peso"];

    let celdaUnidades = document.createElement("div");
    celdaUnidades.className = "tabla-productos__contenido-valor tabla-productos__contenido-unidades";
    celdaUnidades.innerHTML = producto["unidades"];

    let celdaPrecio = document.createElement("div");
    celdaPrecio.className = "tabla-productos__contenido-valor tabla-productos__contenido-precio";
    celdaPrecio.innerHTML = producto["precio"];

    let celdaAcciones = document.createElement("div");
    celdaAcciones.className = "tabla-productos__contenido-acciones";
    let botonEditar = document.createElement("div");
    botonEditar.className = "boton boton--verde";
    botonEditar.innerHTML = "Editar";
    botonEditar.onclick = function(){

        $("#form-edit-producto input[name=idProducto]").val(producto["idProducto"]);
        $("#form-edit-producto input[name=nombre]").val(producto["nombre"]);
        $("#form-edit-producto input[name=origen]").val(producto["origen"]);
        $("#form-edit-producto input[name=tipoMolido]").val(producto["tipoMolido"]);
        $("#form-edit-producto input[name=marca]").val(producto["marca"]);
        $("#form-edit-producto input[name=peso]").val(producto["peso"]);
        $("#form-edit-producto input[name=unidades]").val(producto["unidades"]);
        $("#form-edit-producto input[name=precio]").val(producto["precio"]);

        $("#modal-edit-producto").show();
    }
    let botonBorrar = document.createElement("div");
    botonBorrar.className = "boton boton--rojo";
    botonBorrar.innerHTML = "Borrar";
    botonBorrar.onclick = function(){
        $.ajax({
            url: "../php/controllers/delete-producto.php",
            data: {idProducto : producto['idProducto']},
            type: 'post',
            success: function(){
                $("#producto"+producto['idProducto']).remove();
                alert("Producto borrado");

            },
            error: function(){
                alert("Fallo al borrar el producto");
            }
            
        })
    }
    celdaAcciones.appendChild(botonBorrar);
    celdaAcciones.appendChild(botonEditar);

    fila.appendChild(celdaIdProducto);
    fila.appendChild(celdaFoto);
    fila.appendChild(celdaNombre);
    fila.appendChild(celdaOrigen);
    fila.appendChild(celdaMarca);
    fila.appendChild(celdaTipo);
    fila.appendChild(celdaPeso);
    fila.appendChild(celdaUnidades);
    fila.appendChild(celdaPrecio);

    fila.appendChild(celdaAcciones);

    $(".tabla-productos__contenido").append(fila);
}