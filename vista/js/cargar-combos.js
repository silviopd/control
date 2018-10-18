
function cargarComboUsuarioSesion(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/usuario.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Usuario</option>';
            }
            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.login+'">'+item.login+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboUsuario(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/usuario.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Usuario</option>';
            }else{
                html += '<option value="0">Todos los Usuarios</option>';
            }
            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_usuario+'">'+item.login+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboPais(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/pais.cargar.combo.controlador.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Pais</option>';
            }else{
                html += '<option value="0">Todas los Paises</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_pais+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboCiudad(p_nombreCombo, p_tipo,p_codigoPais){
    
    $.post
    (
	"../controlador/ciudad.cargar.combo.controlador.php",
        {
         p_codigoPais:p_codigoPais   
        }
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una ciudad</option>';
            }else{
                html += '<option value="0">Todas las ciudades</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_ciudad+'">'+item.nombre+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}
