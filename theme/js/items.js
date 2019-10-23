$('#save,#update').click(function (e) {
	var base_url=$("#base_url").val().trim();
    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            //$('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


    //Validate Input box or selection box should not be blank or empty
	check_field("item_name");
	check_field("category_id");
	check_field("unit_id");//units of measurments
	check_field("price");
	//check_field("alert_qty");
	check_field("tax_id");
	check_field("purchase_price");
	check_field("tax_type");
	//check_field("profit_margin");
	check_field("sales_price");
	
    if(flag==false)
    {
		toastr["warning"]("Te ha faltado un dato necesario!");
		return;
    }

    var this_id=this.id;

    if(this_id=="save")  //Save start
    {

					if(confirm("¿Desea guardar el registro?")){
						e.preventDefault();
						data = new FormData($('#items-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: 'newitems',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
							if(result=="success")
							{
								//alert("Record Saved Successfully!");
								window.location=base_url+'items';//"items-view.php";
								return;
							}
							else if(result=="failed")
							{
							   toastr["error"]("Hemos fallado al guardar el registro. Intenta de nuevo!");
							   //	return;
							}
							else
							{
								toastr["error"](result);
								
							}
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();

					   }
					   });
				}
				return;
				//e.preventDefault


    }//Save end
	
	else if(this_id=="update")  //Save start
    {
				
					if(confirm("¿Desea actualizar el registro?")){
						e.preventDefault();
						data = new FormData($('#items-form')[0]);//form name3
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'items/update_items',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
							if(result=="success")
							{
								window.location=base_url+'items';
							}
							else if(result=="failed")
							{
							   toastr["error"]("Hemos fallado al guardar el registro. Intenta de nuevo!");
							}
							else
							{
								  toastr["error"](result);
							}
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();
							return;
					   }
					   });
				}

				//e.preventDefault


    }//Save end
	

});


//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}

//update status start
function update_status(id,status)
{
	
	$.post("items/update_status",{id:id,status:status},function(result){
		if(result=="success")
				{
					 toastr["success"]("Estado actualizado!");
				  //alert("Status Updated Successfully!");
				  success.currentTime = 0; 
				  success.play();
				  if(status==0)
				  {
					  status="Inactive";
					  var span_class="label label-danger";
					  $("#span_"+id).attr('onclick','update_status('+id+',1)');
				  }
				  else{
					  status="Active";
					   var span_class="label label-success";
					   $("#span_"+id).attr('onclick','update_status('+id+',0)');
					  }

				  $("#span_"+id).attr('class',span_class);
				  $("#span_"+id).html(status);
				  return false;
				}
				else if(result=="failed"){
					toastr["error"]("Hemos fallado al actualizar el estado. Intente de nuevo!");
				  failed.currentTime = 0; 
				  failed.play();

				  return false;
				}
				else{
					toastr["error"](result);
				  failed.currentTime = 0; 
				  failed.play();
				  return false;
				}
	});
}
//update status end

//Delete Record start
function delete_items(q_id)
{
	
   if(confirm("¿Desea eliminar el registro?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("items/delete_items",{q_id:q_id},function(result){
   //alert(result);return;
	   if(result=="success")
				{
				  toastr["success"]("Registro a sido borrado correctamente!");
				  $('#example2').DataTable().ajax.reload();
				}
				else if(result=="failed"){
				  toastr["error"]("¡Error al borrar!. El registro está siendo usado");
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
    
		if(confirm("Está seguro de borrar todos los registros ?")){
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: 'items/multi_delete',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				result=result.trim();
  //alert(result);return;
				if(result=="success")
				{
					toastr["success"]("Registro a sido borrado correctamente!");
					success.currentTime = 0; 
				  	success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
				   toastr["error"](" Hemos fallado al grabar el registro. Intente de nuevo!");
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

//CALCULATED PURCHASE PRICE
function calculate_purchase_price(){
	var price = (isNaN(parseFloat($("#price").val().trim()))) ? 0 :parseFloat($("#price").val().trim()); 
	var tax = (isNaN(parseFloat($('option:selected', "#tax_id").attr('data-tax')))) ? 0 :parseFloat($('option:selected', "#tax_id").attr('data-tax')); 
	$("#purchase_price").val( (price + (price*tax)/parseFloat(100)).toFixed(2));
	calculate_sales_price();
}
$("#price").keyup(function(event) {
	calculate_purchase_price();
});
$("#tax_id").change(function(event) {
	calculate_purchase_price();
});

//CALCUALATED SALES PRICE
function calculate_sales_price(){
	var purchase_price = (isNaN(parseFloat($("#purchase_price").val().trim()))) ? 0 :parseFloat($("#purchase_price").val().trim()); 
	var profit_margin = (isNaN(parseFloat($("#profit_margin").val().trim()))) ? 0 :parseFloat($("#profit_margin").val().trim()); 
	var tax_type = $("#tax_type").val();
	var sales_price =parseFloat(0);
	if(tax_type=='Inclusive'){
		sales_price = purchase_price + ((purchase_price*profit_margin)/parseFloat(100));
	}
	else{
		var price = (isNaN(parseFloat($("#price").val().trim()))) ? 0 :parseFloat($("#price").val().trim()); 
		sales_price = price + ((price*profit_margin)/parseFloat(100));
	}
	$("#sales_price").val(sales_price.toFixed(2));
}
$("#tax_type").change(function(event) {
	calculate_sales_price();
});
$("#profit_margin").keyup(function(event) {
	calculate_sales_price();
});
//END