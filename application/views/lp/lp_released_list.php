<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact">
     
   	  <h3>Released LPs</h3>
     
     	<table id="example" class="table">
        	<thead>
        	<tr>
            	<th>LP#</th>
               <th>Destination</th>
                <th>Delivery Bloked Removed</th>
                <th>Vessel Closing</th>
                <th>Cargo Ready</th>
                <th>Released Date</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach($released_lp_list->result() as $lp_list){ ?>
            	<tr>
                	<td><?php echo $lp_list->ref?></td>
                    <td><?php echo$lp_list->tmp_destination?></td>
                    <td><?php echo $lp_list->delivery_block_removed_date?></td>
                    <td><?php echo $lp_list->vessel_closing_date?></td>
                    <td><?php echo $lp_list->cargo_ready_date?></td>
                    <td><?php echo $lp_list->datetime?></td>
                </tr>
             <?php } ?>   
            </tbody>
            
        </table>
     
     	
     </div>
   </section>
 </div>
 
 <script>

$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "400px",
        "scrollCollapse": false,
        "paging":         false
    });

});
 
 </script>