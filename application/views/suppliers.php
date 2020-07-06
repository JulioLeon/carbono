<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 <?php include"sidebar.php"; ?>
 
  <?php
	
	if(!isset($supplier_name)){
    $supplier_name=$mobile=$phone=$email=$country=$state=
    $postcode=$address=$supplier_code=$gstin=$pan=$state_code=
    $company_name=$company_mobile=$tax_number=$country_id=$state_id=$opening_balance='';
	}
 ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Agregar/Actualizar Proveedor</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="<?php echo $base_url; ?>suppliers"><?= $this->lang->line('suppliers_list'); ?></a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
           

            <!-- form start -->
              <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'suppliers-form', 'enctype'=>'multipart/form-data', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>

              
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                      <label for="supplier_name" class="col-sm-4 control-label"><?= $this->lang->line('supplier_name'); ?><label class="text-danger">*</label></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder=""  value="<?php print $supplier_name; ?>" autofocus>
          <span id="supplier_name_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
                  
                  <div class="form-group">
                  <label for="state" class="col-sm-4 control-label">Tipo documento
                      <label class="text-danger">*</label> 
                  </label>
		  
                  <div class="col-sm-8">
                    <select class="form-control select2" id="tipodoc" name="tipodoc"  style="width: 100%;" >                    
                    </select>
                    <span id="state_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>

                  <div class="form-group">
                      <label for="documento" class="col-sm-4 control-label">Nro Documento<label class = "text-danger">*</label></label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control no_special_char_no_space" id="nrodoc" name="nrodoc" placeholder="" value="<?php print $nrodoc; ?>">
                          <span id="nrodoc_msg" style="display:none" class="text-danger"></span>
                      </div>
                    </div>
                    
                
                  <div class="form-group">
                      <label for="mobile" class="col-sm-4 control-label"><?= $this->lang->line('mobile'); ?></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="" value="<?php print $mobile; ?>" >
          <span id="mobile_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="email" class="col-sm-4 control-label"><?= $this->lang->line('email'); ?></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php print $email; ?>" >
          <span id="email_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>

                  <div class="form-group">
                  <label for="phone" class="col-sm-4 control-label"><?= $this->lang->line('phone'); ?></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control no_special_char_no_space" id="phone" name="phone" placeholder="" value="<?php print $phone; ?>" >
          <span id="phone_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
                  
                                     
                  <!-- ########### -->
               </div>
               
                
               <div class="col-md-5">
                    

                  <div class="form-group">
                  <label for="country" class="col-sm-4 control-label"><?= $this->lang->line('country'); ?></label>

                  <div class="col-sm-8">
          <select class="form-control select2" id="country" name="country"  style="width: 100%;"  value="<?php print $country; ?>">
            <?php
            $query1="select * from db_country where status=1";
            $q1=$this->db->query($query1);
            if($q1->num_rows($q1)>0)
             {
                 foreach($q1->result() as $res1)
               {
                 $selected = ($country_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->country."</option>";
               }
             }
             else
             {
                ?>
                <option value="">No se encontraron registros</option>
                <?php
             }
            ?>
                  </select>
          <span id="country_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
                   <div class="form-group">
                   <label for="state" class="col-sm-4 control-label"><?= $this->lang->line('state'); ?></label>
                  
          <div class="col-sm-8">
                    <select class="form-control select2" id="state" name="state"  style="width: 100%;" >
            <?php
            $query2="select * from db_states where status=1";
            $q2=$this->db->query($query2);
            if($q2->num_rows()>0)
             {
              echo '<option value="">-Select-</option>'; 
              foreach($q2->result() as $res1)
               {
                 $selected = ($state_id==$res1->id)? 'selected' : '';
                 echo "<option $selected value='".$res1->id."'>".$res1->state."</option>";
               }
             }
             else
             {
                ?>
                <option value="">No se encontraron registros</option>
                <?php
             }
            ?>
                  </select>
          <span id="state_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>
                  
                   <div class="form-group">
                  <label for="postcode" class="col-sm-4 control-label"><?= $this->lang->line('postcode'); ?></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control no_special_char_no_space" id="postcode" name="postcode" placeholder="" value="<?php print $postcode; ?>" >
          <span id="postcode_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>

                  <div class="form-group">
                          <label for="gstin" class="col-sm-4 control-label"><?= $this->lang->line('gst_number'); ?></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="gstin" name="gstin" placeholder="" value="<?php print $gstin; ?>" >
                          <span id="gstin_msg" style="display:none" class="text-danger"></span>
                          </div>
                          </div>
                          <div class="form-group">
                          <label for="tax_number" class="col-sm-4 control-label"><?= $this->lang->line('tax_number'); ?></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="" value="<?php print $tax_number; ?>" >
                          <span id="tax_number_msg" style="display:none" class="text-danger"></span>
                          </div>
                    </div>

                   <div class="form-group">
                  <label for="address" class="col-sm-4 control-label"><?= $this->lang->line('address'); ?></label>
                  <div class="col-sm-8">
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="" ><?php print $address; ?></textarea>
          <span id="address_msg" style="display:none" class="text-danger"></span>
                  </div>
                  </div>                  
                   
                </div>
                  <!-- ########### -->
</div>
              
				
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <?php
                                    if($supplier_name!=""){
                                         $btn_name="Actualizar";
                                         $btn_id="update";
                                         ?>
                                 <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                                 <?php
                                    }
                                              else{
                                                  $btn_name="Guardar";
                                                  $btn_id="save";
                                              }
                                    
                                              ?>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="submit" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Cerrar</button>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->

            <?= form_close(); ?>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/suppliers.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
