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
      //total purchase amt
      $q1=$this->db->query("SELECT COALESCE(SUM(grand_total),0) AS pur_total FROM db_purchase");
      $pur_total=$q1->row()->pur_total;

      //Total SAles amount
      $query6="SELECT COALESCE(sum(grand_total),0) AS tot_sal_grand_total FROM db_sales ";
      $sal_total=$this->db->query($query6)->row()->tot_sal_grand_total;

      //total sales amt
      $q2=$this->db->query("SELECT COALESCE(SUM(tax_amt),0) AS tax_amt FROM db_salesitems");
      $tax_amt=$q2->row()->tax_amt;
      
      //total expense amt
      $q3=$this->db->query("SELECT COALESCE(SUM(expense_amt),0) AS exp_total FROM db_expense");
      $exp_total=$q3->row()->exp_total;
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-info pull-right btnExport" title="Download Data in Excel Format">Excel</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover " id="report-data" >
                <tr><td><?= $this->lang->line('total_purchase'); ?></td><td class="text-right text-bold"><?php echo $CI->currency(number_format($pur_total,2,'.','')); ?></td></tr>   
                <tr><td><?= $this->lang->line('total_sales'); ?></td><td class="text-right text-bold"><?php echo $CI->currency(number_format($sal_total,2,'.','')); ?></td></tr>   
                <tr><td><?= $this->lang->line('total_sales_tax'); ?></td><td class="text-right text-bold"><?php echo $CI->currency(number_format(($tax_amt),2,'.','')); ?></td></tr>   
                <tr><td><?= $this->lang->line('total_expense'); ?></td><td class="text-right text-bold"><?php echo $CI->currency(number_format($exp_total,2,'.','')); ?></td></tr>   
                <tr><td><?= $this->lang->line('profit'); ?></td><td class="text-right text-bold"><?php echo $CI->currency(number_format($sal_total-($pur_total+($tax_amt)+$exp_total),2,'.','')); ?></td></tr>   
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
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


<script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>
<script>
function convert_excel(type, fn, dl) {
    var elt = document.getElementById('report-data');
    var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
    return dl ?
        XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
        XLSX.writeFile(wb, fn || ('Sales-Report.' + (type || 'xlsx')));
}
$(".btnExport").click(function(event) {
 convert_excel('xlsx');
});
</script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
