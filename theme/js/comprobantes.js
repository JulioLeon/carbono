$(document).ready(function () {
	//cargotiendas();
	
});

// function cargotiendas() {
// 	$.ajax({
// 		type: "post",
// 		url: "Comprobantes/tiendas",
// 		data: {},
// 		success: function (response) {
// 		    console.log(response);
// 		  $("#tiendaalm").html(response);
// 		  $("#utiendaalm").html(response);
// 		}
// 	});
// }

function agregar_comprobantes() {
    var codigo = $("#codsuc").val();
    var nombre = $("#nomsuc").val();
    var tienda = $("#dirsuc").val();
    var estado = $("#estsuc").val();
    $.ajax ({
        type: "post",
        url : "Comprobantes/crea_comprobantes",
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
            window.location.href="Comprobantes";             
            // switch (JSON.parse(response)) {
			// 	case 1:
			//         alert("Se insertó correctamente!");
            //         window.location.href="Comprobantes";             
			//         break; 
			// 	default: 
			// 	 alert("ERROR EN EL SISTEMA");
			//   }
	
		}
    })
}

function editarComprobantes(codigo, nombre,tipodoc, tipomov,estado) {
    //alert("valor: " + codigo + " - " + nombre);
    $("#ucodsuc").val(codigo);    
    $("#unomsuc").val(nombre);
    $("#udirsuc").val(id_sucu);
    $("#uestsuc").val(estado);
}

function actualizar_comprobantes() {
    var codigo = $("#ucodsuc").val();
    var nombre = $("#unomsuc").val();
    var tienda = $("#udirsuc").val();
    var estado = $("#uestsuc").val();
    $.ajax({
        type: "post",
        url : "Comprobantes/upd_comprobantes",
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
            window.location.href="Comprobantes";             
            // switch (JSON.parse(response)) {
			// 	case 1:
			//         alert("Se insertó correctamente!");
            //         window.location.href="Comprobantes";             
			//         break; 
			// 	default: 
			// 	 alert("ERROR EN EL SISTEMA");
			//   }
	
		}
    })
}