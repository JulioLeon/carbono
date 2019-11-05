$(document).ready(function () {
	//cargotiendas();
	
});

// function cargotiendas() {
// 	$.ajax({
// 		type: "post",
// 		url: "Sucursal/tiendas",
// 		data: {},
// 		success: function (response) {
// 		    console.log(response);
// 		  $("#tiendaalm").html(response);
// 		  $("#utiendaalm").html(response);
// 		}
// 	});
// }

function agregar_sucursal() {
    var codigo = $("#codsuc").val();
    var nombre = $("#nomsuc").val();
    var tienda = $("#dirsuc").val();
    var estado = $("#estsuc").val();
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
    $("#ucodsuc").val(codigo);    
    $("#unomsuc").val(nombre);
    $("#udirsuc").val(id_sucu);
    $("#uestsuc").val(estado);
}

function actualizar_sucursal() {
    var codigo = $("#ucodsuc").val();
    var nombre = $("#unomsuc").val();
    var tienda = $("#udirsuc").val();
    var estado = $("#uestsuc").val();
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