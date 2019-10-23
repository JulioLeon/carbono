$(document).ready(function () {
	cargotiendas();
	
});

function cargotiendas() {
	$.ajax({
		type: "post",
		url: "Almacen/tiendas",
		data: {},
		success: function (response) {
		    console.log(response);
		  $("#tiendaalm").html(response);
		  $("#utiendaalm").html(response);
		}
	});
}

function agregar_almacen() {
    var codigo = $("#codalm").val();
    var nombre = $("#nomalm").val();
    var tienda = $("#tiendaalm").val();
    var estado = $("#estalm").val();
    $.ajax ({
        type: "post",
        url : "Almacen/crea_almacen",
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
            window.location.href="Almacen";             
            // switch (JSON.parse(response)) {
			// 	case 1:
			//         alert("Se insertó correctamente!");
            //         window.location.href="Almacen";             
			//         break; 
			// 	default: 
			// 	 alert("ERROR EN EL SISTEMA");
			//   }
	
		}
    })
}

function editarAlmacen(codigo, nombre) {
    //alert("valor: " + codigo + " - " + nombre);
    $("#ucodalm").val(codigo);    
    $("#unomalm").val(nombre);
}