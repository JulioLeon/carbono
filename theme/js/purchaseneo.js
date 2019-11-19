
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
    $("#idmonbas").val(porciones[0]);
 }

 function cargomonedas2() {     
    $.ajax({
       type: "post",
       url: "loadmonedas2",
       data: {},
       success: function (response) {                       
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
         $("#pur_tipdoc").append(response);
          
       }
    });
 }



// FIN DE CAMBIOS 