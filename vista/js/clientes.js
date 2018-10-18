$(document).ready(function () {
    cargarComboPais("#cbopais", "todos");
    cargarComboPais("#cbopaismodal", "seleccione");
    
    cargarComboUsuario("#cbousuario","todos");
    cargarComboUsuario("#cbousuariomodal","seleccione");
    
    listar();
});

$("#cbopais").change(function () {
    var codigoPais = $("#cbopais").val();
    cargarComboCiudad("#cbociudad", "todos", codigoPais);
    listar();
});

$("#cbociudad").change(function () {
    listar();
});

$("#cbousuario").change(function () {
    listar();
});

$("#cbopaismodal").change(function () {
    var codigoPais = $("#cbopaismodal").val();
    cargarComboCiudad("#cbociudadmodal", "seleccione", codigoPais);
});

function listar() {

    var codigoPais = $("#cbopais").val();
    if (codigoPais == null) {
        codigoPais = 0;
    }
    var codigoCiudad = $("#cbociudad").val();
    if (codigoCiudad == null) {
        codigoCiudad = 0;
    }
    var codigoUsuario = $("#cbousuario").val();
    if (codigoUsuario == null) {
        codigoUsuario = 0;
    }

    $.post(
            "../controlador/cliente.listar.controlador.php",
            {
                codigoPais: codigoPais,
                codigoCiudad: codigoCiudad,
                codigoUsuario: codigoUsuario
            }
    ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>NOMBRES</th>';
            html += '<th>SEXO</th>';
            html += '<th>EMAIL</th>';
            html += '<th>VIP</th>';
            html += '<th>PAIS</th>';
            html += '<th>CIUDAD</th>';
            html += '<th>USUARIO</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td align="center">' + item.codigo + '</td>';
                html += '<td>' + item.nombres + '</td>';
                html += '<td>' + item.sexo + '</td>';
                html += '<td>' + item.email + '</td>';
                html += '<td>' + item.vip + '</td>';
                html += '<td>' + item.pais + '</td>';
                html += '<td>' + item.ciudad + '</td>';
                html += '<td>' + item.usuario + '</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo + ')"><i class="fa fa-pencil"></i></button>';
                html += '&nbsp;&nbsp;';
                html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo + ')"><i class="fa fa-close"></i></button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado").html(html);   //funcion(variable)

            $("#tabla-listado").dataTable({
                "aaSorting": [[1, "asc"]]
            });


        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function eliminar(codigoCliente) {

    swal({
        title: "Confirme",
        text: "¿Esta seguro de eliminar el registro seleccionado?",
        showCancelButton: true,
        confirmButtonColor: '#d93f1f',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/eliminar.png"
    },
            function (isConfirm) {
                if (isConfirm) {

                    $.post(
                            "../controlador/cliente.eliminar.controlador.php",
                            {
                                codigoCliente: codigoCliente
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) { //ok
                            listar();
                            swal("Exito", datosJSON.mensaje, "success");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                }
            });
}


$("#frmgrabar").submit(function (evento) {
    evento.preventDefault();

    swal({
        title: "Confirme",
        text: "¿Esta seguro de grabar los datos ingresados?",
        showCancelButton: true,
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/pregunta.png"
    },
            function (isConfirm) {

                if (isConfirm) { //el usuario hizo clic en el boton SI     

                    //procedo a grabar

                    $.post(
                            "../controlador/cliente.agregar.editar.controlador.php",
                            {
                                p_datosFormulario: $("#frmgrabar").serialize()
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;

                        if (datosJSON.estado === 200) {
                            swal("Exito", datosJSON.mensaje, "success");

                            $("#btncerrar").click();
                            listar();
                        } else {
                            swal("Mensaje del sistema", resultado, "warning");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });

                }
            });
});


$("#btnagregar").click(function () {
    $("#txttipooperacion").val("agregar");

    $("#txtcodigo").val("");
    $("#txtapellidos").val("");
    $("#txtnombres").val("");
    $("#txtemail").val("");
    $("#cbosexomodal").val("M");
    
//    $("#cbovipmodal").val("0");
    $("#cbovipmodal0").prop('checked', true);
    
    $("#cbopaismodal").val("");
    $("#cbociudadmodal").empty();
    $("#cbousuariomodal").val("");

    $("#titulomodal").text("Agregar Nuevo Cliente");
});


$("#myModal").on("shown.bs.modal", function () {
    $("#txtapellidos").focus();
});

function leerDatos( codigoCliente){
    
    $.post
        (
            "../controlador/cliente.leer.datos.controlador.php",
            {
                p_codigoCliente: codigoCliente
            }
        ).done(function(resultado){
            var datosJSON = resultado;
            if (datosJSON.estado === 200){
                
                $.each(datosJSON.datos, function(i,item) {
                    $("#txtcodigo").val( item.codigo_cliente );
                    $("#txtapellidos").val( item.apellidos );
                    $("#txtnombres").val( item.nombres );
                    $("#txtemail").val( item.email );
                    $("#cbosexomodal").val( item.sexo );
                    
//                    $("#cbovipmodal").val( item.vip );
                    
                    if (item.vip==0) {
                        $("#cbovipmodal0").prop('checked', true);
                    }else{
                        $("#cbovipmodal1").prop('checked', true);
                    }
                    
                    
                    $("#cbopaismodal").val( item.codigo_pais );
                    $("#cbousuariomodal").val( item.codigo_usuario );
                    
                    $("#cbopaismodal").change();
                    
                    $("#myModal").on("shown.bs.modal", function(){
                        $("#cbociudadmodal").val( item.codigo_ciudad );
                    });
                    
                });
                
            }else{
                swal("Mensaje del sistema", resultado , "warning");
            }
        })
    
}