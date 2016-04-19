	<?php require_once('loader.php');?>
    <body>
    <div class="content-wrapper">
    <section class="content">
    <h2>Inventory vs LPs to Ship<br>
      
    </h2>
    <div class="box-body compact">
	<table id="example">
    <thead>
    <tr>
    <th>Product ID</th>
    <th>Description</th>
    <th align="center" style="text-align:center">Available Qty</th>
    <th align="center" style="text-align:center">LP Qty</th>
    <th align="center" style="text-align:center">Difference</th>
    <th align="center" style="text-align:center">Booked Qty</th>
    </thead>
    
    <tbody>
    <?php  
	$avalibale_qty=0;
	$booked_qty=0;
	$lp_qty=0;
	$diff=0;
	foreach($pro_vs_lp->result() as $pro_vs_lps){  
		$avalibale_qty = $avalibale_qty + $pro_vs_lps->quantity;
		$booked_qty = $booked_qty + $pro_vs_lps->booked_quantity;
		$lp_qty=$lp_qty+$pro_vs_lps->lp_quantity;
		$diff=$diff+$pro_vs_lps->quantity-$pro_vs_lps->lp_quantity;
	?>
    
        <tr>
            <td><?php echo $pro_vs_lps->product_id ?></td>
            <td><?php echo $pro_vs_lps->description ?></td>
            <td align="center"><?php echo $pro_vs_lps->quantity ?></td>
            <td align="center"><?php echo $pro_vs_lps->lp_quantity ?></td>
            <td align="center"><?php echo $pro_vs_lps->quantity-$pro_vs_lps->lp_quantity ?></td>
            <td align="center"><?php echo $pro_vs_lps->booked_quantity ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th style="text-align:center"><?php echo $avalibale_qty  ?></th>
    <th style="text-align:center"><?php echo $lp_qty  ?></th>
    <th style="text-align:center"><?php echo $diff  ?></th>
    <th style="text-align:center"><?php echo $booked_qty  ?></th>
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
  

