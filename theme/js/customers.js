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

$('#save,#update').click(function (e) {

	var base_url=$("#base_url").val().trim();
    /*Initially flag set true*/
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Datos requerido').addClass('required');
            $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             $('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


    //Validate Input box or selection box should not be blank or empty
	check_field("customer_name");
	//check_field("mobile");
	check_field("state");

    var email=$("#email").val().trim();
    if (email!='' && !validateEmail(email)) {
            $("#email_msg").html("Invalid Email!").show();
             //flag=false;
             toastr["warning"]("Please Enter valid Email ID.")
			return;
        }
        else{
        	$("#email_msg").html("Invalid Email!").hide();
        }

	if(flag==false)
    {
		toastr["warning"]("You have Missed Something to Fillup!")
		return;
    }

    var this_id=this.id;

    if(this_id=="save")  //Save start
    {

					if(confirm("¿ Quiere guardar el registro ?")){
						e.preventDefault();
						data = new FormData($('#customers-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: 'newcustomers',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
             // alert(result);return;
							if(result=="success")
							{
								//alert("Record Saved Successfully!");
								window.location=base_url+"customers";
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
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();
					   }
					   });
				}

				//e.preventDefault


    }//Save end
	
	else if(this_id=="update")  //Update start
    {
						
					if(confirm("¿ Quiere guardar el registro ?")){
						e.preventDefault();
						data = new FormData($('#customers-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'customers/update_customers',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
							if(result=="success")
							{
								//toastr["success"]("Record Updated Successfully!");
								window.location=base_url+"customers";
								//return;
							}
							else if(result=="failed")
							{
							   //alert("¡Lo siento! No se pudo guardar el registro. Intente nuevamente");
							   toastr["error"]("¡Lo siento! No se pudo guardar el registro. Intente nuevamente!");
							   //	return;
							}
							else
							{
								toastr['error'](result);
							}
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();
							//return;
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
	
	$.post("customers/update_status",{id:id,status:status},function(result){
		if(result=="success")
				{
				  toastr["success"]("Record Updated Successfully!");
				  //alert("Status Updated Successfully!");
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
				  return false;
				}
				else{
				  toastr["error"](result);
				  return false;
				}
	});
}
//update status end


//Delete Record start
function delete_customers(q_id)
{
	
   if(confirm("¿ Seguro que quiere eliminar el registro ?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post("customers/delete_customers",{q_id:q_id},function(result){
  // alert(result);return;
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
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: 'customers/multi_delete',
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