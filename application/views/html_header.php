<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="<?php echo base_url()?>skin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/css/gsl.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/plugins/datatables/dataTables.fixedColumns.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>skin/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url()?>skin/plugins/fullcalendar/fullcalendar.min.css">

<script src="<?php echo base_url()?>skin/plugins/jQuery/jQuery-2.1.3.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url()?>skin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url()?>skin/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/fastclick/fastclick.min.js"></script>
<script src="<?php echo base_url()?>skin/dist/js/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/pie.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/light.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/exporting.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/dist/js/highcharts.js" type="text/javascript"></script>  
 <script src="<?php echo base_url()?>skin/plugins/flot/jquery.canvasjs.min.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>skin/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/datatables/dataTables.scroller.js"></script>
<script src="<?php echo base_url()?>skin/plugins/datatables/dataTables.fixedColumns.js"></script>
<script src="<?php echo base_url()?>skin/plugins/knob/jquery.knob.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/input-mask/tableToExcel.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>skin/plugins/input-mask/bootstrap-popover.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>skin/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>skin/plugins/fullcalendar/jquery-ui.min.js"></script>
<script src="<?php echo base_url()?>skin/plugins/fullcalendar/moment.min.js"></script>
<script src="<?php echo base_url()?>skin/plugins/fullcalendar/abcd.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function () {
	$(document).ajaxSend(function(event, request, settings) {
    	$('#loading-indicator').show();
	});
	
	$(document).ajaxComplete(function(event, request, settings) {
		$('#loading-indicator').hide();
	});

});
</script>