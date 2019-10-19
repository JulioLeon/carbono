<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_datatable.php"; ?>

<!-- Lightbox -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/lightbox/ekko-lightbox.css">
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
        <small>alm_001</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

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
              <!-- Aqui el primero -->
              <div class="box-tools">                
                <button data-toggle="modal"  data-toggle="modal" data-target="#modaladdalmacen" class="btn btn-warning"><i class="fa fa-plus "></i> Nuevo Almacén</button>
              </div>

              <div class="card-header " style=" background-color: #00a65a;">           
                
              </div>

            <!-- Aqui el cierre de etiqueta php -->           
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example33" class="table table-bordered table-striped" width="100%">
                <thead class="bg-primary ">
                <tr>
                                   
                  <th>Código</th>
                  <th>Nombre Almacén</th>
                  <th>Ubicación</th>  
                  <th>estado</th>                                        
	         	  	  <!-- <th><?= $this->lang->line('status'); ?></th> -->
                  <!-- <th><?= $this->lang->line('action'); ?></th> -->
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
    
    <!-- inicio Modal -->

    
  

     <?= form_close();?>
  </div>

  <!-- /.content-wrapper -->
  <?php include"footer.php"; ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- Agregando Modales -->
 <!-- Modal Agredar almacen -->
 <div class="modal fade" id="modaladdalmacen"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar Almacén</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">                                                       
              <!-- formulario -->
              <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Código</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="codalm">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Almacén</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nomalm">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Local </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="localm">
                  </div>
                </div>
              </div>
                      
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Estado </label>
                  <div class="col-sm-8">
                    <select class="custom-select" id="estalm">
                        <option selected>--[ seleccione estado ]--</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>                        
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-3 col-form-label">Descripción </label>
                      <div class="col-sm-8">
                        <textarea  id="desalm" name="desalm" class="form-control"></textarea>
                      </div>
                    </div>
            </div>
            </div>

            <small id="passwordHelpBlock" class="form-text text-muted">
              ( * ) Dato necesario
            </small>                      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button  type="button" class="btn btn-primary">Agregar Almacén</button>
        </div>
      </div>
    </div>
  </div>
  </div>

    <!-- Final modal -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_datatable.php"; ?>
<!-- Lightbox -->
<script src="<?php echo $theme_link; ?>plugins/lightbox/ekko-lightbox.js"></script>
<script type="text/javascript">
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
</script>
<script type="text/javascript">
$(document).ready(function() {

  mostrar();
    //datatables
    $('#example33').DataTable({
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Columns' },  

            ]
        },
     "language": {
         "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
     },
     ajax: {
         url: "<?php echo base_url('Almacen/ajax_list')?>",
         dataSrc: ''
     },dom: "Bfrtip",
     columns: [
       
        { data: 'cod_alm' },
        { data: 'nom_alm' },
        { data: 'nom_suc' },
        { data: null,"render" : function(data){
              if (data.estado==1) {
                  return "<span class='label label-success'>Activo</span>";                
              }
              else {
                return "<span class='label label-danger'>Inactivo</span>";
              }

           }  }
     ],
     "responsive": true     

 });
   
});
</script>
<script>
  function mostrar() {
    $.ajax({
        type: "post",
        url: "<?php echo base_url('Almacen/ajax_list')?>",
        data: {           
        },
        success: function (response) {
            console.log(response);            
        }
    });
}
</script>


<script src="<?php echo $theme_link; ?>js/items.js"></script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
