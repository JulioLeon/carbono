<!-- jQuery 2.2.3 -->
<script src="<?php echo $theme_link; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $theme_link; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $theme_link; ?>dist/js/app.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $theme_link; ?>plugins/fastclick/fastclick.js"></script>
<!-- Select2 -->
<script src="<?php echo $theme_link; ?>plugins/select2/select2.full.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $theme_link; ?>dist/js/demo.js"></script>
<!--Toastr notification -->
<script src="<?php echo $theme_link; ?>toastr/toastr.js"></script>
<script src="<?php echo $theme_link; ?>toastr/toastr_custom.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Sweet alert -->
<script src="<?php echo $theme_link; ?>js/sweetalert.min.js"></script>
<!-- Custom JS -->
<script src="<?php echo $theme_link; ?>js/special_char_check.js"></script>
<script src="<?php echo $theme_link; ?>js/custom.js"></script>
<!-- sweet alert -->
<script src="<?php echo $theme_link; ?>js/sweetalert.min.js"></script>
<!-- Autocomplete -->      
<script src="<?php echo $theme_link; ?>plugins/autocomplete/autocomplete.js"></script>
<!-- Pace Loader -->
<script src="<?php echo $theme_link; ?>plugins/pace/pace.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-orange',
      /*uncheckedClass: 'bg-white',*/
      radioClass: 'iradio_square-orange',
      increaseArea: '10%' // optional
    });
  });
</script>
<!-- CSRF Token Protection -->
<script type="text/javascript" >
$(function($) { // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({ data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }  }); });
</script>
<!-- Initialize Select2 Elements -->
<script type="text/javascript"> $(".select2").select2(); </script>
<!-- Initialize date with its Format -->
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: '<?php echo $VIEW_DATE;?>',
     todayHighlight: true
    });
</script>
<!-- Initialize toggler -->
<script type="text/javascript">
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();   
  });
</script>
<!-- start pace loader -->
<script type="text/javascript">
$(document).ajaxStart(function() { Pace.restart(); }); 
</script>  
<script type="text/javascript">
$(document).ready(function () { setTimeout(function() {$( ".alert-dismissable" ).fadeOut( 1000, function() {});}, 10000); });
</script>
