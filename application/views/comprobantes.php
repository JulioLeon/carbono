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
        <small>suc_001</small>
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
                <!-- <button data-toggle="modal"  data-toggle="modal" data-target="#modaladdcomprobantes" class="btn btn-warning"><i class="fa fa-plus "></i> Nuevo Almacén</button> -->
                <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus "></i>Nuevo Tipo de Comprobante</button>
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
                  <th>Nombre Comprobante</th>
                  <th>Tipo Doc.</th>  
                  <th>Tipo Mov.</th>                                        	         	  	  
                  <th>estado</th> 
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

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">    
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header header-custom" style="position:relative;">          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white;">×</span></button>
          <h4 class="modal-title text-center">Agregar Tipo de Comprobante</h4>          
        </div>
        <div class="modal-body">
          <!-- formulario -->
          <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Código</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="codcom" value="">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nomcom">                    
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Codigo Tipo Comprobante </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="tipcom">
                  </div>
                </div>
              </div> 

              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Tipo de movimiento </label>
                  <div class="col-sm-8">
                    <select class="form-control" id="tipmov">
                        <option>--[ seleccione estado ]--</option>
                        <option selected value="1">Venta</option>
                        <option value="0">Compra</option>                        
                    </select>
                  </div>
                </div>
              </div>   

            </div>

            <small id="passwordHelpBlock" class="form-text text-muted">
              ( * ) Dato necesario
            </small>                      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button  onclick= "agregar_comprobante();" type="button" class="btn btn-primary">Agregar Tipo Comprobante</button>
        </div>
      </div>
      </div>
      
    </div>
  </div>
<!-- Final modal --> 
 
<!-- Modal Actualizar -->
<div class="modal fade" id="updatecomprobantes" role="dialog">    
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header header-custom" style="position:relative;">          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white;">×</span></button>
          <h4 class="modal-title text-center">Actualizar Comprobante</h4>          
        </div>
        <div class="modal-body">
          <!-- formulario -->
          <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Código</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="ucodcom" value="" disable>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Nombre</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="unomcom">                    
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Codigo Tipo Comprobante </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="utipcom">
                  </div>
                </div>
              </div> 

              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Tipo de movimiento </label>
                  <div class="col-sm-8">
                    <select class="form-control" id="utipmov">
                        <option>--[ seleccione estado ]--</option>
                        <option selected value="1">Venta</option>
                        <option value="0">Compra</option>                        
                    </select>
                  </div>
                </div>
              </div>   
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-3 col-form-label">Estado </label>
                  <div class="col-sm-8">
                    <select class="form-control" id="uestacom">
                        <option>--[ seleccione estado ]--</option>
                        <option selected value="1">Activo</option>
                        <option value="0">Inactivo</option>                        
                    </select>
                  </div>
                </div>
              </div>           
            </div>

            <small id="passwordHelpBlock" class="form-text text-muted">
              ( * ) Dato necesario
            </small>                      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button  onclick= "actualizar_comprobantes();" type="button" class="btn btn-primary">Actualizar Comprobante</button>
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
                text: 'Borrar',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',text: 'Copiar',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',text:'Imprimir',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Ver' },  

            ]
        },
     "language": {
         "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
     },
     ajax: {
         url: "<?php echo base_url('Comprobantes/ajax_list')?>",
         dataSrc: ''
     },dom: "Bfrtip",
     columns: [
       
        { data: 'cod_doc' },
        { data: 'nom_doc' },
        { data: 'tip_doc' },
        { data: 'tip_mov' },
        { data: null,"render" : function(data){
              if (data.estado==1) {
                  return "<span class='label label-success'>Activo</span>";                
              }
              else {
                return "<span class='label label-danger'>Inactivo</span>";
              }

           }  },
        { data: null,"render" : function(data){          
          return "<div class='btn-group' title='Ver acciones'> " +
		      "<a class='btn btn-primary btn-o dropdown-toggle' data-toggle='dropdown' href='#' aria-haspopup='true' aria-expanded='false'>Acción <span class='caret'></span></a>" +
          "<ul role='menu' class='dropdown-menu dropdown-light pull-right'>" + 
          "<li><a title='Editar registro ?' href='#' onclick=\"editarComprobantes('"+data.cod_doc+"','" + data.nom_doc + "','" + data.tip_doc + "','" + data.tip_mov + "','" + data.estado + "');\"   data-toggle='modal' data-target='#updatecomprobantes'>" +
          "<i class='fa fa-fw fa-edit text-blue'></i>Editar	</a>	</li>" + 
          "<li><a style='cursor:pointer' title='Borrar registro ?' onclick=\"borrar_registro('"+data.cod_doc+"');\">	<i class='fa fa-fw fa-trash text-red'></i>Borrar</a></li></ul>" + 
	        "</div>";
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
        url: "<?php echo base_url('Comprobantes/ajax_list')?>",
        data: {           
        },
        success: function (response) {
                       
        }
    });
}
</script>


<script src="<?php echo $theme_link; ?>js/items.js"></script>
<script src="<?php echo $theme_link; ?>js/comprobantes.js"></script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
