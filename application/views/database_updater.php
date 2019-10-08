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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $page_title;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title;?></li>
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
          <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Update Database</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
          <div class="row">
            <?php 
              $disabled ='';
              if($current_version==$latest_version) {
              $disabled ='disabled';?>
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-success ">
                       <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Database Up-to-Date!</strong>
                </div>
           </div>
           <?php }
           else{ ?>
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-warning ">
                       <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Please update database: Latest version available <?= $latest_version; ?>
                        <br>Note: Before updating database,Please take Database backup! and make it sure!
                      </strong>
                </div>
           </div>
           <?php }?>

            <div class="col-xs-4 col-xs-offset-4">

              <table class="table table-bordered">
                <tr><td>Current Version</td><td><?= $current_version; ?></td></tr>
              </table>
              <label class="text-center text-success msg" style="display: none;">Please wait!!...</label>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 text-center">
              <button <?= $disabled;?> type="button" class="btn btn-lrg update_db btn-success" title="Ajax Request">
                <i class="fa fa-database fa-refresh"></i>&nbsp; Update Database
              </button>
            </div>
          </div>
          <div class="ajax-content">
          </div>
        </div>
       
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

<script type="text/javascript">
  $(".update_db").click(function(event) {
    $(".update_db").attr('disabled',true); 
    $(".msg").show();
    var base_url=$("#base_url").val().trim();
    $.post(base_url+'/updates/update_db', {}, function(result) {
      if(result=='success'){
        alert("Database Updated Successfully!");
        location.reload();
      }
      else{
        alert("Failed to Update Database!Try again or Contact Admin!");
      }
      $(".msg").hide();
      $(".update_db").attr('disabled',false); 
    });
  });
</script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

</body>
</html>
