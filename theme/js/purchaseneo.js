
// INICIO MIS CAMBIOS 
$( document ).ready(function() {
   cargomonedas2();
   cargocondiciones2();
   loadcompro2();
  // cargo_almacen();
  
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

//  function add_stock() {
//     //alert("probando");
//     var i = 1;
//     $("#purchase_table .detalle_item").each(function(){
//       var n1 = $("#tr_item_id_"+i).val();
//       var n2 = $("#td_data_"+i+"_1").val();
//       var n3 = $("#td_data_"+i+"_3").val();
//       var n4 = $("#td_data_"+i+"_13").val();
//       console.log(n1 + " /" +  n2 + " /" + n3 + " / " + n4);
//       $.ajax({
//          type: "post",
//          url : "ingreso_stock",
//          data: {
//             valor01 : n4,
//             valor02 : n1,
//             valor03 : n3
//          },
//       success: function (response) {
//          alert (response) ; //Aqui recibo mi mensajede mivariable output. Insert, delete, update.         
//          console.log(response);         
//       }
//       });            
//       i++;
//     });
   
//  }



// FIN DE CAMBIOS 