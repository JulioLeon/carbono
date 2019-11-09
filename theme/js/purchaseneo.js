
// INICIO MIS CAMBIOS 
$( document ).ready(function() {
   cargomonedas2();
   cargocondiciones2();
   loadcompro2();
  
});

 function loaddesc2(e) {
   var pizza = e;
    var porciones = pizza.split('-');
    $("#verpizza").val(porciones[1]);
    // alert(porciones[1]); //porción3

 }

 function cargomonedas2() {     
    $.ajax({
       type: "post",
       url: "loadmonedas2",
       data: {},
       success: function (response) {
            alert("cargomoneda");
            console.log(response);
            $("#addmoneda2").append(response);         
       }
    });
 }


 function cargocondiciones2() {
    $.ajax({
       type: "post",
       url: "loadcondiciones2",
       data: {},
       success: function (response) {
        console.log(response); 
        $("#addcondicion2").html(response);          
       }
    });
 }

 function loadcompro2() {
    $.ajax({
       type: "post",
       url: "loadneocomprobantes2",
       data: {},
       success: function (response) {
         $("#neocomprobante2").append(response);
          
       }
    });
 }


function sigla2(e) {
   var valor = e;
   $.ajax({
      type: "post",
      url: "verificarcod2",
      data: {
         valor: valor
      },
    
      success: function (response) {
        
         $("#neoserie2").html(response);
         $("#correlativo2").val("");
      }
   });
}

function verycorrelativo2(e) {
  var corre  = e ;
  $.ajax({
     type: "post",
     url: "verycorre2",
     data: {
        corre: corre
     },
     success: function (response) {
      
       var corre  =  JSON.parse(response)
       $("#correlativo2").val(corre);
     }
  });
}


// FIN DE CAMBIOS 