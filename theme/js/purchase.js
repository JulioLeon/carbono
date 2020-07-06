
//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}


$('#save,#update').click(function (e) {
	var base_url=$("#base_url").val().trim();

    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Datos requerido').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


   //Los inputs o select no deben estar vacios
	  check_field("supplier_id");
    check_field("pur_date");
    check_field("purchase_status");
    //check_field("warehouse_id");
	/*if(!isNaN($("#amount").val().trim()) && parseInt($("#amount").val().trim())==0){
        toastr["error"]("You have entered Payment Amount! <br>Please Select Payment Type!");
        return;
    }*/
	if(flag==false)
	{
		toastr["error"]("Falta llenar un dato!");
		return;
	}

	//Al menos agregar un registro
  var rowcount=document.getElementById("hidden_rowcount").value;
	var flag1=false;
	for(var n=1;n<=rowcount;n++){
		if($("#td_data_"+n+"_1").val()!=null && $("#td_data_"+n+"_1").val()!=''){
			flag1=true;
		}	
	}
	
    if(flag1==false){
    	toastr["warning"]("Por favor seleccione un item!!");
        $("#item_search").focus();
		return;
    }
    //end

    var tot_subtotal_amt=$("#subtotal_amt").text();
    var other_charges_amt=$("#other_charges_amt").text();//other_charges include tax calcualated amount
    var tot_discount_to_all_amt=$("#discount_to_all_amt").text();
    var tot_round_off_amt=$("#round_off_amt").text();
    var tot_total_amt=$("#total_amt").text();
    var tot_total_amt2=$("#addmoneda2").text();
    var total_puriva=$("#total_puriva").text();
    var mon_bas = $("#idmonbas").val();
    var tip_doc = $("#pur_tipdoc").val();
    var ser_doc = $("#pur_serie").val();
    var num_doc = $("#pur_correlativo").val();
    var fec_inp = $("#pur_date").val();
    var fec_vto = $("#pur_fecvto").val();
    var glosa = $("#reference_no2").val();
    var this_id=this.id;    
    
			if(confirm("Quiere guardar el registro?")){
				e.preventDefault();
        data = new FormData($('#purchase-form')[0]);//form name       
        /*Check XSS Code*/
        if(!xss_validation(data)){ return false; }        
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $("#"+this_id).attr('disabled',true);  //Enable Save or Update button
        add_stock(rowcount,fec_inp,glosa,mon_bas,tip_doc,ser_doc,num_doc,fec_vto);
				$.ajax({
				type: 'POST',
        url: base_url+'purchase/purchase_save_and_update?command='+this_id+'&rowcount='+rowcount+'&tot_subtotal_amt='+tot_subtotal_amt+'&tot_discount_to_all_amt='+
        tot_discount_to_all_amt+'&tot_round_off_amt='+tot_round_off_amt+'&tot_total_amt='+tot_total_amt+'&tot_total_amt2='+tot_total_amt2+'&mon_bas='+mon_bas+"&other_charges_amt="+other_charges_amt+'&total_puriva='+total_puriva,
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result){
         // alert(result);return;        
				result=result.split("<<<###>>>");
					if(result[0]=="success")
					{                        
            //location.href=base_url+"purchase/invoice/"+result[1];
					}
					else if(result[0]=="failed")
					{
					   toastr['error']("No se a podido guardar. Intente otra vez");
					}
					else
					{
						alert(result);
					}
					$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
					$(".overlay").remove();

			   }
			   });
		}
  
});

function add_stock(lineas, fec_inp,glosa,mon_bas,tip_doc,ser_doc,num_doc,fec_vto) {  
  var i = 1;  
  //alert("probando... " + mon_bas + " / " + ser_doc);
  //for(var i=1;i<=lineas;i++) {
    $("#purchase_table .detalle_item").each(function(){
      var codpro = $("#tr_item_id_"+i).val();
      var n2 = $("#td_data_"+i+"_1").val();
      var cantidad = $("#td_data_"+i+"_3").val();
      var pre_uni = $("#td_data_"+i+"_4").val();
      var mon_iva = $("#td_data_"+i+"_5").val();
      var mon_tot = $("#td_data_"+i+"_9").val();
      var almacen = $("#td_data_"+i+"_13").val();      
      //console.log(n1 + " /" +  n2 + " /" + n3 + " / " + n4);
      $.ajax({
        type: "post",
        url : "ingreso_stock",
        data: {
            almacen : almacen,
            codpro  : codpro,
            monbas : mon_bas,
            cantidad : cantidad,
            pre_uni : pre_uni,
            mon_iva : mon_iva,           
            mon_tot : mon_tot,
            tip_doc : tip_doc,
            ser_doc : ser_doc,
            num_doc : num_doc,
            fec_inp : fec_inp,
            fec_vto : fec_vto,
            glosa : glosa
        },
      success: function (response) {
        //alert (response) ; //Aqui recibo mi mensajede mivariable output. Insert, delete, update.
        //window.location.href='Impuesto';  
        console.log(response);
        //console.log(JSON.parse(response));        
      }
      });          
      i++;
    }); 
  //}
}

$("#item_search").autocomplete({
    source: function(data, cb){
        $.ajax({
        	autoFocus:true,
            url: $("#base_url").val()+'items/get_json_items_details',
            method: 'GET',
            dataType: 'json',
            /*showHintOnFocus: true,
			autoSelect: true, 
			
			selectInitial :true,*/
			
            data: {
                name: data.term
            },
            success: function(res){
              //console.log(res);
                var result;
                result = [
                    {
                        //label: 'No se encontraron registros '+data.term,
                        label: 'No se encuentra registro ',
                        value: ''
                    }
                ];

                if (res.length) {
                    result = $.map(res, function(el){
                        return {
                            label: el.item_code +'--'+ el.label,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                           // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,
                        };
                    });
                }

                cb(result);
            }
        });
    },
        //loader start
        search: function (e, u) {
        },
        select: function (e, u) { 
        	
            //$("#mobile").val(u.item.mobile)
            //$("#item_search").val(u.item.value);
            //$("#customer_dob").val(u.item.customer_dob)
            //$("#address").val(u.item.address)
            //alert("id="+u.item.id);
            var item_id =u.item.id;
            return_row_with_data(item_id);
        },   
        //loader end
});

function return_row_with_data(item_id){
	var base_url=$("#base_url").val().trim();
	var rowcount=$("#hidden_rowcount").val();
	$.post(base_url+"purchase/return_row_with_data/"+rowcount+"/"+item_id,{},function(result){
        //alert(result);
        cargo_almacen(rowcount);
        $('#purchase_table tbody').append(result);
       	$("#hidden_rowcount").val(parseInt(rowcount)+1);
        success.currentTime = 0;
        success.play();
        enable_or_disable_item_discount();        
    }); 
}
function cargo_almacen(rowcount) {
  $.ajax({
     type: "post",
     url: "loadalmacen",
     data: {},
     success: function (response) {
        //$("#pur_loadalm").html(response);
        $("#td_data_"+rowcount+"_13").html(response);
     }
  });
}
//INCREMENT ITEM
function increment_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
  var available_qty=$("#tr_available_qty_"+rowcount+"_13").val();
  //if(parseInt(item_qty)<parseInt(available_qty)){
    item_qty=parseFloat(item_qty)+1;
    $("#td_data_"+rowcount+"_3").val(item_qty);
  //}
  //console.log(item_qty);
  //console.log(available_qty);
  calculate_tax(rowcount);
}
//DECREMENT ITEM
function decrement_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
  if(item_qty<=1){
    $("#td_data_"+rowcount+"_3").val(1);
    return;
  }
  $("#td_data_"+rowcount+"_3").val(parseFloat(item_qty)-1);
  calculate_tax(rowcount);
}

function update_paid_payment_total() {
  var rowcount=$("#paid_amt_tot").attr("data-rowcount");
  var tot=0;
  for(i=1;i<rowcount;i++){
    if(document.getElementById("paid_amt_"+i)){
      tot += parseFloat($("#paid_amt_"+i).html());
    }
  }
  $("#paid_amt_tot").html(tot.toFixed(2));
}
function delete_payment(payment_id){
 if(confirm("¿ Seguro que quiere eliminar el registro ?")){
    var base_url=$("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"purchase/delete_payment",{payment_id:payment_id},function(result){
   //alert(result);return;
   result=result.trim();
     if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          $("#payment_row_"+payment_id).remove();
          success.currentTime = 0; 
          success.play();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
          failed.currentTime = 0; 
          failed.play();
        }
        else{
          toastr["error"](result);
          failed.currentTime = 0; 
          failed.play();
        }
        $(".overlay").remove();
        update_paid_payment_total();
   });
   }//end confirmation   
  }

  //Delete Record start
function delete_purchase(q_id)
{
  
   if(confirm("¿ Seguro que quiere eliminar el registro ?")){
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("purchase/delete_purchase",{q_id:q_id},function(result){
   //alert(result);return;
     if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
        }
        else{
           toastr["error"](result);
        }
        $(".overlay").remove();
        return false;
   });
   }//end confirmation
}
//Delete Record end
function multi_delete(){
  //var base_url=$("#base_url").val().trim();
    var this_id=this.id;
    
    if(confirm("¿Está seguro?")){
      data = new FormData($('#table_form')[0]);//form name
      /*Check XSS Code*/
      if(!xss_validation(data)){ return false; }
      
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $("#"+this_id).attr('disabled',true);  //Enable Save or Update button
      $.ajax({
      type: 'POST',
      url: 'purchase/multi_delete',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(result){
        result=result.trim();
  //alert(result);return;
        if(result=="success")
        {
          toastr["success"]("Registro eliminado exitosamente!");
          success.currentTime = 0; 
            success.play();
          $('#example2').DataTable().ajax.reload();
          $(".delete_btn").hide();
          $(".group_check").prop("checked",false).iCheck('update');
        }
        else if(result=="failed")
        {
           toastr["error"]("Lo sentimos, no se pudo guardar el registro. ¡Inténtalo de nuevo!");
           failed.currentTime = 0; 
           failed.play();
        }
        else
        {
          toastr["error"](result);
          failed.currentTime = 0; 
            failed.play();
        }
        $("#"+this_id).attr('disabled',false);  //Enable Save or Update button
        $(".overlay").remove();
       }
       });
  }
  //e.preventDefault
}

function pay_now(purchase_id){
  $.post('purchase/show_pay_now_modal', {purchase_id: purchase_id}, function(result) {
    $(".pay_now_modal").html('').html(result);
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: 'dd-mm-yyyy',
     todayHighlight: true
    });
    $('#pay_now').modal('toggle');

  });
}
function view_payments(purchase_id){
  $.post('purchase/view_payments_modal', {purchase_id: purchase_id}, function(result) {
    $(".view_payments_modal").html('').html(result);
    $('#view_payments_modal').modal('toggle');
  });
}

function save_payment(purchase_id){
  var base_url=$("#base_url").val().trim();

    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Datos requerido').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


   //Validate Input box or selection box should not be blank or empty
    check_field("amount");
    check_field("payment_date");


    var payment_date=$("#payment_date").val().trim();
    var amount=$("#amount").val().trim();
    var payment_type=$("#payment_type").val().trim();
    var payment_note=$("#payment_note").val().trim();

    if(amount == 0){
      toastr["error"]("Please Enter Valid Amount!");
      return false; 
    }

    if(amount > parseFloat($("#due_amount_temp").html().trim())){
      toastr["error"]("Entered Amount Should not be Greater than Due Amount!");
      return false;
    }

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $(".payment_save").attr('disabled',true);  //Enable Save or Update button
    $.post('purchase/save_payment', {purchase_id: purchase_id,payment_type:payment_type,amount:amount,payment_date:payment_date,payment_note:payment_note}, function(result) {
      result=result.trim();
  //alert(result);return;
        if(result=="success")
        {
          $('#pay_now').modal('toggle');
          toastr["success"]("¡Pago registrado con éxito!");
          success.currentTime = 0; 
          success.play();
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed")
        {
           toastr["error"]("Lo sentimos, no se pudo guardar el registro. ¡Inténtalo de nuevo!");
           failed.currentTime = 0; 
           failed.play();
        }
        else
        {
          toastr["error"](result);
          failed.currentTime = 0; 
          failed.play();
        }
        $(".payment_save").attr('disabled',false);  //Enable Save or Update button
        $(".overlay").remove();
    });
}

function delete_purchase_payment(payment_id){
 if(confirm("¿ Seguro que quiere eliminar el registro ?")){
    var base_url=$("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"purchase/delete_payment",{payment_id:payment_id},function(result){
   //alert(result);return;
   result=result.trim();
     if(result=="success")
        {
          $('#view_payments_modal').modal('toggle');
          toastr["success"]("Record Deleted Successfully!");
          success.currentTime = 0; 
          success.play();
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
          failed.currentTime = 0; 
          failed.play();
        }
        else{
          toastr["error"](result);
          failed.currentTime = 0; 
          failed.play();
        }
        $(".overlay").remove();
   });
   }//end confirmation   
  }