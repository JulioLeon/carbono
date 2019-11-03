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

function agregar_comprobante() {
    var codigo = $("#codcom").val();
    var nombre = $("#nomcom").val();
    var tipcom = $("#tipcom").val();
    var tipmov = $("#tipmov").val();
    $.ajax ({
        type: "post",
        url : "Comprobantes/crea_comprobantes",
        data : {
            codigo:codigo,
            nombre:nombre,
            tipcom:tipcom,
            tipmov:tipmov
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

function editarComprobantes(codigo,nombre,tipcom, tipmov,estado) {
    //alert("valor: " + codigo + " - " + nombre);
    $("#ucodcom").val(codigo);    
    $("#unomcom").val(nombre);
    $("#utipcom").val(tipcom);
    $("#utipmov").val(tipmov);
    $("#uestacom").val(estado);
}

function actualizar_comprobantes() {
    var codigo = $("#ucodcom").val();
    var nombre = $("#unomcom").val();
    var tipcom = $("#utipcom").val();
    var tipmov = $("#utipmov").val();
    var estado = $("#uestacom").val();
    $.ajax({
        type: "post",
        url : "Comprobantes/upd_comprobante",
        data : {
            codigo:codigo,
            nombre:nombre,
            tipcom:tipcom,
            tipmov:tipmov,
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
function borrar_registro(cod) {
    var rpta = window.confirm("¿Desea eliminar el registro?");
    if (rpta == true) {
        $.ajax({
            type: "post",
            url: "Comprobantes/del_comprobante",
            data: {
                cod : cod            
            },
            success: function (response) {
                alert (response) ;
                window.location.href='Comprobantes';              
            }
        });
    } else {
        window.location.href='Comprobantes';   
    }    
}