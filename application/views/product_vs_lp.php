	<?php require_once('loader.php');?>
    <body>
    <div class="content-wrapper">
    <section class="content">
    
    <div class="box-body compact">
	<table id="example">
    <thead>
    <th>Product ID</th>
    <th>Description</th>
    <th>Available Qty</th>
    <th>Booked Qty</th>
    </thead>
    
    <tbody>
    <?php  
	$avalibale_qty=0;
	$booked_qty=0;
	foreach($pro_vs_lp as $pro_vs_lps){  
	$avalibale_qty=$avalibale_qty+$pro_vs_lps->quantity;
	$booked_qty=$booked_qty+$pro_vs_lps->booked_quantity;
	?>
    
    <tr>
    <td><?php echo $pro_vs_lps->product_id ?></td>
    <td><?php echo $pro_vs_lps->description ?></td>
    <td><?php echo $pro_vs_lps->quantity ?></td>
    <td><?php echo $pro_vs_lps->booked_quantity ?></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th><?php echo $avalibale_qty  ?></th>
    <th><?php echo $booked_qty  ?></th>
    </tfoot>
    </table>  
	
  <br>
  <table>
  <tr>
  <td>Export to Excel</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input class="btn btn-primary" type="button" value="Export to Excel Sheet" id="exporttoexcel"/> </td> 
  </tr>
  </table>
    </div>
    </section>
    
    </div>
 </html>

  
<script type="text/javascript">
      $('#example').dataTable({
           "scrollY": "350px",
           "scrollCollapse": true,
           "paging": false
        }); 

	$("#exporttoexcel").click(function () {
	window.location.pathname ="index.php/report/Dashboard/download_Excel";

	 }); 
 </script> 
  

