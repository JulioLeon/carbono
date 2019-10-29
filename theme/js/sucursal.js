$(document).ready(function () {
	cargotiendas();
	
});

function cargotiendas() {
	$.ajax({
		type: "post",
		url: "Sucursal/tiendas",
		data: {},
		success: function (response) {
		    console.log(response);
		  $("#tiendaalm").html(response);
		  $("#utiendaalm").html(response);
		}
	});
}

function agregar_sucursal() {
    var codigo = $("#codalm").val();
    var nombre = $("#nomalm").val();
    var tienda = $("#tiendaalm").val();
    var estado = $("#estalm").val();
    $.ajax ({
        type: "post",
        url : "Sucursal/crea_sucursal",
        data : {
            codigo:codigo,
            nombre:nombre,
            tienda:tienda,
            estado:estado
        },
        success: function (response) {
            let jason = JSON.parse(response)
            console.log(jason);
            alert(jason);
            window.location.href="Sucursal";             
            // switch (JSON.parse(response)) {
			// 	case 1:
			//         alert("Se insertó correctamente!");
            //         window.location.href="Sucursal";             
			//         break; 
			// 	default: 
			// 	 alert("ERROR EN EL SISTEMA");
			//   }
	
		}
    })
}

function editarSucursal(codigo, nombre,id_sucu,estado) {
    //alert("valor: " + codigo + " - " + nombre);
    $("#ucodalm").val(codigo);    
    $("#unomalm").val(nombre);
    $("#utiendaalm").val(id_sucu);
    $("#uestalm").val(estado);
}

function actualizar_sucursal() {
    var codigo = $("#ucodalm").val();
    var nombre = $("#unomalm").val();
    var tienda = $("#utiendaalm").val();
    var estado = $("#uestalm").val();
    $.ajax({
        type: "post",
        url : "Sucursal/upd_sucursal",
        data : {
            codigo:codigo,
            nombre:nombre,
            tienda:tienda,
            estado:estado
        },
        success: function (response) {
            let jason = JSON.parse(response)
            console.log(jason);
            alert(jason);
            window.location.href="Sucursal";             
            // switch (JSON.parse(response)) {
			// 	case 1:
			//         alert("Se insertó correctamente!");
            //         window.location.href="Sucursal";             
			//         break; 
			// 	default: 
			// 	 alert("ERROR EN EL SISTEMA");
			//   }
	
		}
    })
}