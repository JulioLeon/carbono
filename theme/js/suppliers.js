/*Email validation code*/
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
/*Email validation code end*/

$(document).submit(function(event) {
	event.preventDefault();
	if(document.getElementById('save')){
		$("#save").trigger('click');
	}
	else{
		$("#update").trigger('click');	
	}
});

$(document).ready(function(){
	cargotipodoc();
});

function cargotipodoc() {
	//console.log("Desde el JS");
	$.ajax({
		type: "post",
		url: "loadTipoDoc",
		data: {},
		success: function (response) {
			$("#tipodoc").html(response);
			//console.log("Desde el JS - Ayax Succes");
		}
	});	
}
function vrfnrodocumento() {
	var numero = $("#nrodoc").val();
	var tipodoc = $("#tipodoc").val();
	console.log(numero + "tipo: " + tipodoc);	
	if (tipodoc == "1") {
		if (numero.length == 8) {
			$("#nrodoc").css("background-color","#D7E7A9");			
			$("#nrodoc_msg").fadeOut(200).hide();
		}
		else {
			$("#nrodoc").css("background-color","#F99A9C");
			$('#nrodoc_msg').fadeIn(200).show().html('El numero debe ser de 8 cifras').addClass('required');
		}
	} 
	if (tipodoc == "6")	{
		if (numero.length == 11){
			$("#nrodoc").css("background-color","#D7E7A9");
			$("#nrodoc_msg").fadeOut(200).hide();
		}
		else {
			$("#nrodoc").css("background-color","#F99A9C");	
			$('#nrodoc_msg').fadeIn(200).show().html('El numero debe ser de 11 cifras').addClass('required');
		}
	}
	
}

function guardarproveedor() {
	var base_url=$("#base_url").val().trim();
	var nombre = $("#supplier_name").val().trim();
	var tipodoc= $("#tipodoc").val().trim();
	var nrodoc = $("#nrodoc").val().trim();
	var mobile = $("#mobile").val().trim();
	var email2 = $("#email").val().trim();
	var phone  = $("#phone").val().trim();
	var country= $("#country").val().trim();
	var state  = $("#state").val().trim();
	var postcode = $("#postcode").val().trim();
	var gstin  = $("#gstin").val().trim();
	var tax_number = $("#tax_number").val().trim();
	var address = $("#address").val().trim();
	$.ajax({
		type: "post",
		url: "newsuppliers",
		data: {
			nombre : nombre,
			tipodoc : tipodoc,
			nrodoc : nrodoc,
			mobile : mobile,
			email2 : email2,
			phone : phone,
			country : country,
			state : state,
			postcode : postcode,
			gstin: gstin,
			tax_number : tax_number,
			address : address		  
		},
		success: function(result){
			// alert(result);return;
			if(result=="success")
			{
				//alert("Record Saved Successfully!");
				window.location=base_url+"suppliers";
				return;
			}
			else if(result=="failed")
			{
			toastr['error']("¡Lo siento! No se pudo guardar el registro. Intente nuevamente");
			//	return;
			}
			else
			{
				toastr['error'](result);
			}
			//$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
			//$(".overlay").remove();		
		}
	    });
}

$('#save,#update').click(function (e) {
    var base_url=$("#base_url").val().trim();
    /*Initially flag set true*/
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Dato requerido').addClass('required');
            //$('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
            // $('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


    //Validate Input box or selection box should not be blank or empty
	check_field("supplier_name");
	check_field("tipodoc");
	check_field("nrodoc");

    var email=$("#email").val().trim();
    if (email!='' && !validateEmail(email)) {
            $("#email_msg").html("Correo inválido!").show();
             flag=false;
        }
        else{
        	$("#email_msg").html("Correo Inválido!").hide();
        }

	if(flag==false)
    {
		toastr["warning"]("Falta un dato requerido!")
		return;
    }

    var this_id=this.id;

    if(this_id=="save")  //Save start
    {
	if(confirm("¿ Quiere guardar el registro ?")){		
		var nombre = $("#supplier_name").val().trim();
		var tipodoc= $("#tipodoc").val().trim();
		var nrodoc = $("#nrodoc").val().trim();
		var mobile = $("#mobile").val().trim();
		var email2 = $("#email").val().trim();
		var phone  = $("#phone").val().trim();
		var country= $("#country").val().trim();
		var state  = $("#state").val().trim();
		var postcode = $("#postcode").val().trim();
		var gstin  = $("#gstin").val().trim();
		var tax_number = $("#tax_number").val().trim();
		var address = $("#address").val().trim();
		//e.preventDefault();
		//data = new FormData($('#suppliers-form')[0]);//form name
		/*Check XSS Code*/
		//if(!xss_validation(data)){ return false; }
		
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
		
		
	}
//e.preventDefault
    }//Save end
	
	else if(this_id=="update")  //Update start
    {
							
					if(confirm("¿ Quiere guardar el registro ?")){
						e.preventDefault();
						data = new FormData($('#suppliers-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'suppliers/update_suppliers',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
							if(result=="success")
							{
								//toastr["success"]("Record Updated Successfully!");
								window.location=base_url+"suppliers";
							}
							else if(result=="failed")
							{
							   toastr["error"]("¡Lo siento! No se pudo guardar el registro. Intente nuevamente!");
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
	
	$.post("suppliers/update_status",{id:id,status:status},function(result){
		if(result=="success")
				{
					 toastr["success"]("Status Updated Successfully!");
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
					toastr["error"]("Failed to Update Status.Try again!");
				  failed.currentTime = 0; 
				  failed.play();

				  return false;
				}
				else{
					toastr['error'](result);
				  failed.currentTime = 0; 
				  failed.play();
				  return false;
				}
	});
}
//update status end


//Delete Record start
function delete_suppliers(q_id)
{
	
   if(confirm("¿ Seguro que quiere eliminar el registro ?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post("suppliers/delete_suppliers",{q_id:q_id},function(result){
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
				  toastr["error"]("Error! Something Went Wrong!");
				}
				$(".overlay").remove();
				return false;
   });
   }//end confirmation
}

//Delete Record end
//Delete Record end
function multi_delete(){
	//var base_url=$("#base_url").val().trim();
    var this_id=this.id;
    
		if(confirm("¿Está seguro?")){
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: 'suppliers/multi_delete',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				result=result.trim();
  //alert(result);return;
				if(result=="success")
				{
					toastr["success"]("Record Deleted Successfully!");
					success.currentTime = 0; 
				  	success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
				   toastr["error"]("¡Lo siento! No se pudo guardar el registro. Intente nuevamente!");
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