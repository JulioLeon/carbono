<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_datatable.php"; ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  
  <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Vista/Buscar Comprar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <div class="pay_now_modal">
    </div>
    <div class="view_payments_modal">
    </div>

    <!-- Main content -->
    <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
    <input type="hidden" id='base_url' value="<?=$base_url;?>">
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$page_title;?></h3>
              <?php if($CI->permissions('purchase_add')) { ?>
              <div class="box-tools">
                <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>purchase/add">
                <i class="fa fa-plus"></i> <?= $this->lang->line('new_purchase'); ?></a>
              </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped" width="100%">
                <thead class="bg-primary ">
                <tr>
                  <th class="text-center">
                    <input type="checkbox" class="group_check checkbox" >
                  </th>
                  <th><?= $this->lang->line('purchase_date'); ?></th>
                  <th><?= $this->lang->line('purchase_code'); ?></th>
				          <th><?= $this->lang->line('purchase_status'); ?></th>
                  <th><?= $this->lang->line('reference_no'); ?></th>
                  <th><?= $this->lang->line('supplier_name'); ?></th>
                  <!-- <th>Warehouse</th> -->
                  <th><?= $this->lang->line('total'); ?></th>
                  <th><?= $this->lang->line('paid_amount'); ?></th>
                  <th><?= $this->lang->line('payment_status'); ?></th>
                  <th><?= $this->lang->line('created_by'); ?></th>
                  <th><?= $this->lang->line('action'); ?></th>
                </tr>
                </thead>
                <tbody>
				
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <?= form_close();?>
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
<?php include"comman/code_js_datatable.php"; ?>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: 'dd-mm-yyyy',
     todayHighlight: true
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
    //datatables
   var table = $('#example2').DataTable({ 

      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
 /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Borrar',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',text: 'Copiar',exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',text:'Imprimir',exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Ver' },  

            ]
        },
        /* FOR EXPORT BUTTONS END */

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"   
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('purchase/ajax_list')?>",
            "type": "POST",
            
            complete: function (data) {
             $('.column_checkbox').iCheck({
                checkboxClass: 'icheckbox_square-orange',
                /*uncheckedClass: 'bg-white',*/
                radioClass: 'iradio_square-orange',
                increaseArea: '10%' // optional
              });
             call_code();
              //$(".delete_btn").hide();
             },

        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,10 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        {
            "targets" :[0],
            "className": "text-center",
        },
        
        ],
    });
    new $.fn.dataTable.FixedHeader( table );
});
</script>
<script src="<?php echo $theme_link; ?>js/purchase.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
